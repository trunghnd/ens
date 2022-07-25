<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;
use ZipArchive;


class FinanceExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 900; // 15 minutes

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Running Finance Export");
        $apikey = config('hubspot.api_key');

        $this->start_time = microtime(true);

        //Get deals to export
        $deal_list = $this->api_request(
            'https://api.hubapi.com/crm/v3/objects/deals/search?hapikey='.config('hubspot.api_key'),
            'POST',
            [ "filterGroups" => [
                [
                  "filters" => [
                    [
                      "operator" => "EQ",
                      "propertyName" => "finance___ready_for_export",
                      "value" => "true"
                    ]
                  ]
                ]
              ],
              "properties" => [
                "id"
              ]
            ]
        );
        Log::debug("export:deal_list", $deal_list['results']);

        if (empty($deal_list['results'])) {
            Log::debug('export: Nothing to process');
            return;
        }

        $deal_ids = array_column($deal_list['results'], 'id');
        $deal_properties = join(',', $this->deal_properties);

        Log::debug("export:deal_properties", [$deal_properties]);

        $deals_eeca = [];
        $deals_non_eeca = [];
        foreach ($deal_ids as $deal_id) {
            $deal = $this->api_request("https://api.hubapi.com/crm/v3/objects/deals/{$deal_id}?properties={$deal_properties}&hapikey=".config('hubspot.api_key'));
            Log::debug("export:deal({$deal_id})", $deal);
            if ($deal) {
                if (!empty($deal['properties']['assessment___funding___eeca_funding']) && $deal['properties']['assessment___funding___eeca_funding'] == 'true') {
                    $deals_eeca[] = $deal;
                } else {
                    $deals_non_eeca[] = $deal;
                }
            }
        }

        Log::debug("Non EECA deals: " . count($deals_non_eeca) . " / EECA: " . count($deals_eeca));

        foreach ($deals_non_eeca as &$deal) {
            $deal['engagements'] = $this->get_attachments($deal['id']);
            $deal['products'] = $this->get_products($deal['id']);
            $deal['sorted_products'] = $this->sort_products($deal['products']);
            $deal['address'] = $this->get_address($deal['id']);
        }
        foreach ($deals_eeca as &$deal) {
            $deal['engagements'] = $this->get_attachments($deal['id']);
            $deal['products'] = $this->get_products($deal['id']);
            $deal['sorted_products'] = $this->sort_products($deal['products']);
            $deal['address'] = $this->get_address($deal['id']);
        }

        $end = microtime(true);

        // Create ZIP file for EECA deals
        // $zipFileName = $this->create_deals_zip($deals_eeca);
        $export = time();
        $zipFileName = "export-{$export}.zip";
        $zip = new ZipArchive();
        if ($zip->open(storage_path("app/{$zipFileName}"), ZipArchive::CREATE) === TRUE) {
            if (count($deals_non_eeca)) {
                Storage::makeDirectory("{$export}/TI - GI");
                $account_export = $this->account_export_csv($deals_non_eeca, "{$export}/TI - GI/Account Export.csv");
                $zip->addFile($account_export, "TI - GI/Account Export.csv");
                $quotes = $this->all_attachments($deals_non_eeca, "app/{$export}/TI - GI");
                $this->add_files_to_zip($zip, $quotes, "{$export}/TI - GI", "TI - GI");
            }
            if (count($deals_eeca)) {
                Storage::makeDirectory("{$export}/CH - EECA");
                $account_export = $this->account_export_csv($deals_eeca, "{$export}/CH - EECA/Account Export.csv");
                $bulk_upload = $this->bulk_upload_csv($deals_eeca, "{$export}/CH - EECA/Bulk Upload.csv");
                $zip->addFile($account_export, "CH - EECA/Account Export.csv");
                $zip->addFile($bulk_upload, "CH - EECA/Bulk Upload.csv");
                $quotes = $this->all_attachments($deals_eeca, "app/{$export}/CH - EECA");
                $this->add_files_to_zip($zip, $quotes, "{$export}/CH - EECA", "CH - EECA");
            }
        }
        $zip->close();
        Log::debug("export:completed zip {$zipFileName}");

        //Upload to HubSpot
        $response = Http::attach(
            'file',
            file_get_contents(storage_path("app/{$zipFileName}")),
            $zipFileName
        )->post('https://api.hubapi.com/files/v3/files?hapikey=' . config('hubspot.api_key'), [
            'fileName' => $zipFileName,
            'charsetHunch' => 'UTF-8',
            'options' => json_encode([
                "access" => "PUBLIC_NOT_INDEXABLE",
                "overwrite" => false,
                "duplicateValidationStrategy" => "NONE",
                "duplicateValidationScope" => "EXACT_FOLDER"
            ]),
        'folderPath' => '/finance-export'
        ])->json();

        if (!empty($response['url'])) {
            Log::debug("export:zip uploaded to {$response['url']}");
            //Update Finance Export record (id: 205706412, type: 2-1521650)
            $update = $this->api_request(
                'https://api.hubapi.com/crm/v3/objects/2-1521650/205706412?hapikey='.config('hubspot.api_key'),
                'PATCH',
                [
                    'properties' => [
                        'finance___zip_file_link' => $response['url'],
                        'finance___zip_updated_date' => strtotime('UTC today') * 1000
                    ]
                ]
            );

            //Set URL in included deals
            foreach ($deal_ids as $deal_id) {
                $this->api_request(
                    "https://api.hubapi.com/crm/v3/objects/deal/{$deal_id}?hapikey=".config('hubspot.api_key'),
                    'PATCH',
                    [
                        'properties' => [
                            'finance___zip_file_link' => $response['url'],
                        ]
                    ]
                );
            }
        }

        // Delete all temp files
        Storage::deleteDirectory($export);
        Storage::delete($zipFileName);

        Log::debug('export:result', [
            'debug' => [
                'requests' => $this->api_request_count,
                'start' => $this->start_time,
                'end' => $end,
                'time' => $end - $this->start_time,
                'zip' => $zipFileName,
                'quotes' => $quotes,
                'account_export' => $account_export,
                'bulk_upload' => $bulk_upload ?? null,
                'file' => $response['url'],
                'update' => $update,
            ],
            'eeca' => $deals_eeca,
            'non' => $deals_non_eeca,
        ]);

        Log::info('Done');
    }

    protected function sum_col($rows, $key)
    {
        $sum = 0;
        foreach ($rows as $row) {
            $sum += $row[$key] ?? 0;
        }
        return $sum;
    }

    protected function account_export_csv($deals, $filename)
    {
        $csv = Writer::createFromString();
        $header = [
            'Lead Reference',
            'Branch',
            'Date PIA Complete',
            'Ownership Status',
            'Owner Name',
            'Postal Address',
            'Property Address',
            'Deposit Received',
            'Ceiling Product 1',
            'QTY',
            'Price',
            'Max Price',
            'Ceiling Product 2',
            'QTY',
            'Price',
            'Max Price',
            'UFL Product 1',
            'QTY',
            'Price',
            'Max Price',
            'UFL Product 2',
            'QTY',
            'Price',
            'Max Price',
            'UFL Product 3',
            'QTY',
            'Price',
            'Max Price',
            'Ground Vapour Barrier',
            'Qty',
            'Price',
            'Max Price',
            'Remedial Labour Ceiling',
            'Qty',
            'Price',
            'Max Price',
            'Remedial Labour UFL',
            'Price',
            'Max Price',
            'Cylinder Wrap',
            'Qty',
            'Price',
            'Max Price',
            'HWC Pipe Lagging',
            'QTY',
            'Price',
            'Max Price',
            'Other Pipe Lagging',
            'QTY',
            'Price',
            'Max Price',
            'Draft Excluders Inside Doors',
            'QTY',
            'Price',
            'Max Price',
            'Brush Excluders Outside Doors',
            'QTY',
            'Price',
            'Max Price',
            'Weather Strip',
            'QTY',
            'Price',
            'Max Price',
            'Travel Cost',
            'Total Installed Solution Cost',
            'Total Discount',
            'Rates/Finance Company',
            'Rates/Finance Company Amount',
            'EECA Grant %',
            'EECA Grant',
            'Third Party Funding Provider',
            'Third Party Funding %',
            'Third Party Funding',
            'Manufacturer\'s Discount',
            'Owner/Landlord Contribution %',
            'Total for Customer to Pay',
            'Undiscounted Travel Cost',
            'Owner Email',
            'Salesperson'
        ];
        $csv->insertOne($header);
        foreach ($deals as $deal) {
            Log::debug("export:csv row", $deal);
            $row = array_fill(0, 79, '');
            $row[0] = $deal['id']; //Lead Reference
            $row[1] = $deal['properties']['branch'] ?? ''; //Branch
            $row[2] = $deal['properties']['pia___h___s_finish___date'] ?? ''; //Date PIA Complete
            $row[3] = $deal['address']['assessement___owner___ownership_status'] ?? ''; //Ownership Status
            $row[4] = ($deal['owner']['firstname'] ?? '') . ' ' . ($deal['owner']['lastname'] ?? ''); //Owner Name
            $row[5] = $deal['address']['postal___street_address'] ?? ''; //Postal Address
            $row[6] = $deal['address']['street_address'] ?? ''; //Property Address
            $row[7] = $deal['properties']['finance___deposit_received'] ?? ''; //Deposit Received
            $row[8] = $deal['sorted_products']['ceiling'][0]['name'] ?? ''; //Ceiling Product 1
            $row[9] = $deal['sorted_products']['ceiling'][0]['quantity'] ?? ''; //QTY
            $row[10] = $deal['sorted_products']['ceiling'][0]['price'] ?? ''; //Price
            $row[11] = $deal['sorted_products']['ceiling'][0]['unit_price'] ?? ''; //Max Price
            $row[12] = $deal['sorted_products']['ceiling'][1]['name'] ?? ''; //Ceiling Product 2
            $row[13] = $deal['sorted_products']['ceiling'][1]['quantity'] ?? ''; //QTY
            $row[14] = $deal['sorted_products']['ceiling'][1]['price'] ?? ''; //Price
            $row[15] = $deal['sorted_products']['ceiling'][1]['unit_price'] ?? ''; //Max Price
            $row[16] = $deal['sorted_products']['ufl'][0]['name'] ?? ''; //UFL Product 1
            $row[17] = $deal['sorted_products']['ufl'][0]['quantity'] ?? ''; //QTY
            $row[18] = $deal['sorted_products']['ufl'][0]['price'] ?? ''; //Price
            $row[19] = $deal['sorted_products']['ufl'][0]['unit_price'] ?? ''; //Max Price
            $row[20] = $deal['sorted_products']['ufl'][1]['name'] ?? ''; //UFL Product 2
            $row[21] = $deal['sorted_products']['ufl'][1]['quantity'] ?? ''; //QTY
            $row[22] = $deal['sorted_products']['ufl'][1]['price'] ?? ''; //Price
            $row[23] = $deal['sorted_products']['ufl'][1]['unit_price'] ?? ''; //Max Price
            $row[24] = $deal['sorted_products']['ufl'][2]['name'] ?? ''; //UFL Product 3
            $row[25] = $deal['sorted_products']['ufl'][2]['quantity'] ?? ''; //QTY
            $row[26] = $deal['sorted_products']['ufl'][2]['price'] ?? ''; //Price
            $row[27] = $deal['sorted_products']['ufl'][2]['unit_price'] ?? ''; //Max Price
            $row[28] = $deal['sorted_products']['gvb'][0]['name'] ?? ''; //Ground Vapour Barrier
            $row[29] = $deal['sorted_products']['gvb'][0]['quantity'] ?? ''; //Qty
            $row[30] = $deal['sorted_products']['gvb'][0]['price'] ?? ''; //Price
            $row[31] = $deal['sorted_products']['gvb'][0]['unit_price'] ?? ''; //Max Price
            $row[32] = $deal['sorted_products']['ceiling_remedial'][0]['name'] ?? ''; //Remedial Labour Ceiling
            $row[33] = $deal['sorted_products']['ceiling_remedial'][0]['quantity'] ?? ''; //Qty
            $row[34] = $deal['sorted_products']['ceiling_remedial'][0]['price'] ?? ''; //Price
            $row[35] = $deal['sorted_products']['ceiling_remedial'][0]['unit_price'] ?? ''; //Max Price
            $row[36] = $deal['sorted_products']['ufl_remedial'][0]['name'] ?? ''; //Remedial Labour UFL
            $row[37] = $deal['sorted_products']['ufl_remedial'][0]['price'] ?? ''; //Price
            $row[38] = $deal['sorted_products']['ufl_remedial'][0]['unit_price'] ?? ''; //Max Price
            $row[39] = ''; //Cylinder Wrap IGNORE
            $row[40] = $deal['properties']['pia___other_products___quantity_of_cylinder_wraps_installed'] ?? ''; //Qty
            $row[41] = ''; //Price IGNORE
            $row[42] = ''; //Max Price IGNORE
            $row[43] = $deal['sorted_products']['hwc'][0]['name'] ?? ''; //HWC Pipe Lagging
            $row[44] = $deal['properties']['pia___other_products___length_of_lagging_installed'] ?? ''; //QTY
            $row[45] = $deal['sorted_products']['hwc'][0]['price'] ?? ''; //Price
            $row[46] = $deal['sorted_products']['hwc'][0]['unit_price'] ?? ''; //Max Price
            $row[47] = ''; //Other Pipe Lagging IGNORE
            $row[48] = ''; //QTY IGNORE
            $row[49] = ''; //Price IGNORE
            $row[50] = ''; //Max Price IGNORE
            $row[51] = ''; //Draft Excluders Inside Doors IGNORE
            $row[52] = $deal['properties']['pia___other_products___number_of_doors_draft_proofed'] ?? ''; //QTY
            $row[53] = ''; //Price IGNORE
            $row[54] = ''; //Max Price IGNORE
            $row[55] = ''; //Brush Excluders Outside Doors IGNORE
            $row[56] = $deal['properties']['pia___other_products___number_of_doors_draft_proofed'] ?? ''; //QTY
            $row[57] = ''; //Price IGNORE
            $row[58] = ''; //Max Price IGNORE
            $row[59] = ''; //Weather Strip IGNORE
            $row[60] = $deal['properties']['pia___other_products___meters_of_weather_strip_installed'] ?? ''; //QTY
            $row[61] = ''; //Price IGNORE
            $row[62] = ''; //Max Price IGNORE
            $row[63] = $deal['sorted_products']['travel'][0]['price'] ?? ''; //Travel Cost
            $row[64] = $deal['properties']['amount'] ?? ''; //Total Installed Solution Cost
            $row[65] = $deal['properties']['finance___total_discount'] ?? ''; //Total Discount
            $row[66] = $deal['properties']['rates___finance_company'] ?? ''; //Rates/Finance Company
            $row[67] = $deal['properties']['rates___finance_amount'] ?? ''; //Rates/Finance Company Amount
            $row[68] = $deal['properties']['eeca_grant_percentage'] ?? ''; //EECA Grant %
            $row[69] = $deal['properties']['eeca_grant_amount_total'] ?? ''; //EECA Grant
            $row[70] = $deal['properties']['n3rd_party_funding_provider'] ?? ''; //Third Party Funding Provider
            $row[71] = $deal['properties']['finance___3rd_party_funding_percentage'] ?? ''; //Third Party Funding %
            $row[72] = $deal['properties']['finance___3rd_party_funding_amount'] ?? ''; //Third Party Funding
            $row[73] = $deal['properties']['manufacturer_s_discount'] ?? ''; //Manufacturer's Discount
            $row[74] = $deal['properties']['insulation_assessment___quote_details___owners_contribution'] ?? ''; //Owner/Landlord Contribution %
            $row[75] = $deal['properties']['finance___total_for_customer_to_pay'] ?? ''; //Total for Customer to Pay
            $row[76] = $deal['properties']['undiscounted_travel_cost'] ?? ''; //Undiscounted Travel Cost
            $row[77] = $deal['occupant']['email'] ?? ''; //Owner Email
            $row[78] = $deal['properties']['owner_id'] ?? ''; //Salesperson
            $csv->insertOne($row);
        }
        $filepath = storage_path("app/{$filename}");
        Storage::put($filename, $csv->toString());
        return $filepath;
    }

    protected function bulk_upload_csv($deals, $filename)
    {
        $csv = Writer::createFromString();
        $header = [
            'Date of Completion',
            'Owner First Name',
            'Owner Surname',
            'Owner Contact Number',
            'Owner Email',
            'Rental Property YN',
            'Tenant Name',
            'Tenant Contact',
            'Tenant Mobile',
            'Flat / Unit No',
            'Street Number',
            'Street Name',
            'Street Type',
            'Suburb',
            'Town',
            'PostCode',
            'CSC Verified',
            'Self Identified as Maori',
            'House Levels',
            'Approx year house built',
            'Recessed lights',
            'Extractor fans',
            'metal flues',
            'Comment',
            'Ceiling insulation',
            'none existing Product',
            'Ceiling insulation',
            'none existing (sqm)',
            'Ceiling insulation',
            'none existing cost/sqm',
            'Ceiling insulation',
            'some existing Product',
            'Ceiling insulation',
            'some existing (sqm)',
            'Ceiling insulation',
            'some existing cost/sqm',
            'Underfloor insulation Product',
            'Underfloor insulation (sqm)',
            'Underfloor insulation cost/sqm',
            'Underfloor moisture barrier (sqm)',
            'Underfloor moisture barrier cost/sqm',
            'If measure not installed',
            'why',
            'Draught proofing of doors (per door)',
            'Draught proofing of doors cost',
            'Hot water cylinder wrap (per house)',
            'Hot water cylinder wrap cost',
            'Hot water pipe lagging (per meter)',
            'Hot water pipe lagging cost',
            'Remedial work (hours) ceiling',
            'Remedial work cost/hour ceiling',
            'Remedial work (hours) underfloor',
            'Remedial work cost/hour underfloor',
            'Total Installed Insulation Cost to House Owner',
            'Heater Type Installed',
            'Heater make/model',
            'Unit cost heating appliance',
            'Total Installed Heating Cost to House Owner',
            'Heating Source Prior to Installation',
            'Third Party Contribution',
            'Targeted Rate Scheme',
            'Referral?',
            'No. of Occupants',
            'No. of Occupants aged 0-5',
            'No. of Occupants aged 6-12',
            'No. of Occupants aged 13-17',
            'No. of Occupants aged 65+'
        ];
        $csv->insertOne($header);
        foreach ($deals as $deal) {
            $row = array_fill(0, 66, '');
            $row[0] = $deal['pia___finalise___finalisation_date'] ?? ''; // Date of Completion
            $row[1] = $deal['address']['owner']['firstname'] ?? ''; // Owner First Name
            $row[2] = $deal['address']['owner']['lastname'] ?? ''; // Owner Surname
            $row[3] = $deal['address']['owner']['phone'] ?? ''; // Owner Contact Number
            $row[4] = $deal['address']['owner']['email'] ?? ''; // Owner Email
            $row[5] = in_array($deal['address']['assessement___owner___ownership_status'] ?? '', ['Owner','Occupier']) ? 'N' : 'Y'; // Rental Property YN
            $row[6] = ''; // Tenant Name IGNORE / Leave blank
            $row[7] = ''; // Tenant Contact IGNORE / Leave blank
            $row[8] = ''; // Tenant Mobile IGNORE / Leave blank
            $row[9] = ''; // Flat / Unit No IGNORE / Leave blank
            $row[10] = $deal['address']['street_number'] ?? ''; // Street Number
            $row[11] = $deal['address']['street'] ?? ''; // Street Name
            $row[12] = $deal['address']['street_type'] ?? ''; // Street Type
            $row[13] = $deal['address']['suburb'] ?? ''; // Suburb
            $row[14] = $deal['address']['city'] ?? ''; // Town
            $row[15] = $deal['address']['post_code'] ?? ''; // PostCode
            $row[16] = $deal['address']['eeca_funding_csc_sdi'] ?? ''; // CSC Verified
            $row[17] = ''; // Self Identified as Maori IGNORE / Leave blank
            $row[18] = $deal['insulation_assessment___site_assessment___storeys'] ?? ''; // House Levels
            $row[19] = $deal['eeca___decade_built'] ?? ''; // Approx year house built
            $row[20] = $deal['install___check_list___amount_of_downlights_found'] ?? ''; // Recessed lights
            $row[21] = ($deal['pia___ceiling___quantity_of_ceiling_cd_s'] ?? false) ? 'Y' : 'N'; // Extractor fans
            $row[22] = ($deal['pia___ceiling___quantity_of_ceiling_cd_s'] ?? false) ? 'Y' : 'N'; // metal flues
            $row[23] = $deal['insulation_assessment___quote_details___notes_and_comments'] ?? ''; // Comment
            $row[24] = $deal['sorted_products']['ceiling_totalfill'][0]['name'] ?? ''; // Ceiling insulation
            $row[25] = $deal['insulation_assessment___ceiling_assessment___existing_insulation_type'] ?? ''; // none existing Product
            $row[26] = $deal['sorted_products']['ceiling_totalfill'][0]['name'] ?? ''; // Ceiling insulation
            $row[27] = $deal['sorted_products']['ceiling_totalfill'][0]['quantity'] ?? ''; // none existing (sqm)
            $row[28] = $deal['sorted_products']['ceiling_totalfill'][0]['name'] ?? ''; // Ceiling insulation
            $row[29] = $deal['sorted_products']['ceiling_totalfill'][0]['unit_price'] ?? ''; // none existing cost/sqm
            $row[30] = $deal['sorted_products']['ceiling_topup'][0]['name'] ?? ''; // Ceiling insulation
            $row[31] = $deal['insulation_assessment___ceiling_assessment___existing_insulation_type'] ?? ''; // some existing Product
            $row[32] = $deal['sorted_products']['ceiling_topup'][0]['name'] ?? ''; // Ceiling insulation
            $row[33] = $deal['sorted_products']['ceiling_topup'][0]['quantity'] ?? ''; // some existing (sqm)
            $row[34] = $deal['sorted_products']['ceiling_topup'][0]['name'] ?? ''; // Ceiling insulation
            $row[35] = $deal['sorted_products']['ceiling_topup'][0]['unit_price'] ?? ''; // some existing cost/sqm
            $row[36] = $deal['sorted_products']['ufl'][0]['name'] ?? ''; // Underfloor insulation Product
            $row[37] = $deal['sorted_products']['ufl'][0]['quantity'] ?? ''; // Underfloor insulation (sqm)
            $row[38] = $deal['sorted_products']['ufl'][0]['unit_price'] ?? ''; // Underfloor insulation cost/sqm
            $row[39] = $deal['sorted_products']['gvb'][0]['quantity'] ?? ''; // Underfloor moisture barrier (sqm)
            $row[40] = $deal['sorted_products']['gvb'][0]['unit_price'] ?? ''; // Underfloor moisture barrier cost/sqm
            $row[41] = ($deal['insulation_assessment___underfloor___q_a_recommend_gvb'] ?? '') == 'Yes' ? '' : 'Q&A not recommended'; // If measure not installed
            $row[42] = ''; // why IGNORE / Leave blank
            $row[43] = $deal['pia___other_products___number_of_doors_draft_proofed'] ?? ''; // Draught proofing of doors (per door)
            $row[44] = ''; // Draught proofing of doors cost IGNORE / Leave blank
            $row[45] = $deal['pia___other_products___quantity_of_cylinder_wraps_installed'] ?? ''; // Hot water cylinder wrap (per house)
            $row[46] = ''; // Hot water cylinder wrap cost IGNORE / Leave blank
            $row[47] = $deal['pia___other_products___length_of_lagging_installed'] ?? ''; // Hot water pipe lagging (per meter)
            $row[48] = $deal['sorted_products']['hwc'][0]['price'] ?? ''; // Hot water pipe lagging cost
            $row[49] = $deal['sorted_products']['ceiling_remedial'][0]['quantity'] ?? ''; // Remedial work (hours) ceiling
            $row[50] = $deal['sorted_products']['ceiling_remedial'][0]['price'] ?? ''; // Remedial work cost/hour ceiling
            $row[51] = $deal['sorted_products']['ufl_remedial'][0]['name'] ?? ''; // Remedial work (hours) underfloor
            $row[52] = $deal['sorted_products']['ufl_remedial'][0]['price'] ?? ''; // Remedial work cost/hour underfloor
            $row[53] = $deal['finance___total_for_customer_to_pay'] ?? ''; // Total Installed Insulation Cost to House Owner
            $row[54] = ''; // Heater Type Installed IGNORE / Leave blank
            $row[55] = ''; // Heater make/model IGNORE / Leave blank
            $row[56] = ''; // Unit cost heating appliance IGNORE / Leave blank
            $row[57] = ''; // Total Installed Heating Cost to House Owner IGNORE / Leave blank
            $row[58] = ''; // Heating Source Prior to Installation IGNORE / Leave blank
            $row[59] = $deal['finance___3rd_party_funding'] ?? ''; // Third Party Contribution
            $row[60] = ''; // Targeted Rate Scheme IGNORE / Leave blank
            $row[61] = ($deal['eeca_funding_csc_sdi'] ?? false) == 'CSC' ? 'No referral' : 'Income Referral'; // Referral?
            $row[62] = ($deal['assessment___occupants___residents_0_5'] ?? 0) + ($deal['assessment___occupants___residents_6_12'] ?? 0) + ($deal['assessment___occupants___residents_13_17'] ?? 0) + ($deal['assessment___occupants___residents_18_64'] ?? 0) + ($deal['assessment___occupants___residents_65_'] ?? 0); // No. of Occupants
            $row[63] = $deal['assessment___occupants___residents_0_5'] ?? ''; // No. of Occupants aged 0-5
            $row[64] = $deal['assessment___occupants___residents_6_12'] ?? ''; // No. of Occupants aged 6-12
            $row[65] = $deal['assessment___occupants___residents_13_17'] ?? ''; // No. of Occupants aged 13-17
            $row[66] = $deal['assessment___occupants___residents_65_'] ?? ''; // No. of Occupants aged 65+
            $csv->insertOne($row);
        }
        $filepath = storage_path("app/{$filename}");
        Storage::put($filename, $csv->toString());
        return $filepath;
    }

    protected function all_attachments($deals, $path)
    {
        $filenames = [];
        foreach ($deals as &$deal) {
            $attachments = $this->get_attachments($deal['id']);
            foreach ($attachments as $id => $url) {
                try {
                    $filename = basename($url);
                    $file_full_path = storage_path("{$path}/{$filename}");
                    $response = Http::withOptions([
                        'sink' => $file_full_path
                    ])->get($url);
                    if ($response->successful()) {
                        $filenames[] = $filename;
                    }
                } catch (Exception $e) {
                    Log::warning("Can't download", ['url' => $url, 'deal_id' => $deal['id']]);
                }
            }
        }
        return $filenames;
    }

    protected function add_files_to_zip($zip, $filenames, $source_path, $dest_path)
    {
        foreach ($filenames as $filename) {
            if (Storage::exists("{$source_path}/{$filename}")) {
                $zip->addFile(storage_path("app/{$source_path}/{$filename}"), "{$dest_path}/".basename($filename));
            }
        }
    }

    protected function get_address($deal_id)
    {
        $address_assoc = $this->api_request("https://api.hubapi.com/crm/v3/objects/0-3/{$deal_id}/associations/2-1185166?hapikey=" . config('hubspot.api_key'));

        if (empty($address_assoc['results'])) {
            return null;
        }

        $address_properties = join(',', $this->address_properties);
        $contact_properties = join(',', $this->contact_properties);

        $address_data = $this->api_request("https://api.hubapi.com/crm/v3/objects/2-1185166/{$address_assoc['results'][0]['id']}?properties={$contact_properties}&hapikey=" . config('hubspot.api_key'));

        $address = $address_data['properties'];
        $address['id'] = $address_data['id'];
        $address['contacts'] = [];

        //Get all address' associated contacts
        //ONLY FOR FIRST ADDRESS
        $contacts = $this->api_request("https://api.hubapi.com/crm/v3/objects/2-1185166/{$address_assoc['results'][0]['id']}/associations/0-1?hapikey=" . config('hubspot.api_key'));

        foreach ($contacts['results'] as $c) {
            $contact_res = $this->api_request("https://api.hubapi.com/crm/v3/objects/contacts/{$c['id']}?properties={$contact_properties}&hapikey=" . config('hubspot.api_key'));

            $contact = $contact_res['properties'];
            $contact['id'] = $contact_res['id'];
            switch ($contact['type_of_owner']) {
                case 'Owner Occupier':
                    $address['owner'] = $contact;
                    $address['occupant'] = $contact;
                    break;
                case 'Landlord':
                    $address['owner'] = $contact;
                    $address['landlord'] = $contact;
                    break;
                case 'Property Manager':
                    $address['property_manager'] = $contact;
                    break;
                default:
            }

            switch ($contact['ownership_status']) {
                case 'Owner Occupier':
                case 'Landlord':
                case 'Property Manager':
                    $address['ownership_status'] = $contact['ownership_status'];
                    break;
                case 'Occupant':
                    $address['occupant'] = $contact;
                    break;
                default:
            }

            $address['contacts'][] = $contact;
        }

        return $address;
    }

    protected function get_products($deal_id)
    {
        $product_properties = join(',', $this->product_properties);
        $products = [];
        $quoted_products = $this->api_request("https://api.hubapi.com/crm/v3/objects/0-3/{$deal_id}/associations/2-1494682?hapikey=" . config('hubspot.api_key'));

        foreach ($quoted_products['results'] as $p) {
            $quoted_product = $this->api_request("https://api.hubapi.com/crm/v3/objects/2-1494682/{$p['id']}?properties={$product_properties}&hapikey=" . config('hubspot.api_key'));
            $product = $quoted_product['properties'];
            $product['id'] = $quoted_product['id'];

            if ($product['quoted___installed'] == 'Installed') {
                $products[] = $product;
            }
        }

        return $products;
    }

    protected function sort_products($products)
    {
        $filtered = [
            'ceiling' => [],
            'ceiling_totalfill' => [],
            'ceiling_topup' => [],
            'ufl' => [],
            'ceiling_remedial' => [],
            'ufl_remedial' => [],
            'hwc' => [],
            'travel' => [],
            'gvb' => [],
        ];
        foreach ($products as $product) {
            switch ($product['product_group']) {
                case 'Ceiling Insulation (Total Fill)':
                    $filtered['ceiling'][] = $product;
                    $filtered['ceiling_totalfill'][] = $product;
                    break;
                case 'Ceiling Insulation (Top-Up)':
                    $filtered['ceiling'][] = $product;
                    $filtered['ceiling_topup'][] = $product;
                    break;
                case 'Underfloor Insulation':
                    $filtered['ufl'][] = $product;
                    break;
                case 'Ceiling Remedial Work':
                    $filtered['ceiling_remedial'][] = $product;
                    break;
                case 'Underfloor Remedial Work':
                    $filtered['ufl_remedial'][] = $product;
                    break;
                case 'HWC Lagging':
                    $filtered['hwc'][] = $product;
                    break;
                case 'Travel':
                    $filtered['travel'][] = $product;
                    break;
                case 'Ground Vapor Barrier':
                    $filtered['gvb'][] = $product;
                    break;
                default:
            }
        }

        return $filtered;
    }

    protected function get_attachments($deal_id)
    {
        $engagement_ids = $this->api_request("https://api.hubapi.com/crm-associations/v1/associations/{$deal_id}/HUBSPOT_DEFINED/11?hapikey=".config('hubspot.api_key'));

        $engagements = [];
        $files = [];

        if (count($engagement_ids['results'])) {
            foreach ($engagement_ids['results'] as $engagement_id) {
                $engagement = $this->api_request("https://api.hubapi.com/engagements/v1/engagements/{$engagement_id}?hapikey=".config('hubspot.api_key'));

                if ($engagement) {
                    $engagements[] = $engagement['engagement'];
                    if (isset($engagement['engagement']['bodyPreview']) && 
                        strtolower(substr($engagement['engagement']['bodyPreview'], -3)) == 'pdf' && 
                        isset($engagement['attachments'][0]['id'])) {
                        $files[$engagement['attachments'][0]['id']] = $engagement['engagement']['bodyPreview'];
                    }
                }
            }
        }

        return $files;
    }

    protected $deal_properties = [
        'amount',
        'assessment___occupants___residents_0_5',
        'assessment___occupants___residents_13_17',
        'assessment___occupants___residents_18_64',
        'assessment___occupants___residents_65_',
        'assessment___occupants___residents_6_12',
        'assessment___funding___eeca_funding',
        'branch',
        'eeca___decade_built',
        'eeca_funding_csc_sdi',
        'eeca_grant_amount_total',
        'eeca_grant_percentage',
        'finance___3rd_party_funding',
        'finance___3rd_party_funding_amount',
        'finance___3rd_party_funding_percentage',
        'finance___deposit_received',
        'finance___total_discount',
        'finance___total_for_customer_to_pay',
        'install___check_list___amount_of_downlights_found',
        'insulation_assessment___ceiling_assessment___existing_insulation_type',
        'insulation_assessment___quote_details___notes_and_comments',
        'insulation_assessment___quote_details___owners_contribution',
        'insulation_assessment___site_assessment___storeys',
        'insulation_assessment___underfloor___q_a_recommend_gvb',
        'manufacturer_s_discount',
        'n3rd_party_funding_provider',
        'owner_id',
        'pia___ceiling___quantity_of_ceiling_cd_s',
        'pia___finalise___finalisation_date',
        'pia___h___s_finish___date',
        'pia___other_products___length_of_lagging_installed',
        'pia___other_products___meters_of_weather_strip_installed',
        'pia___other_products___number_of_doors_draft_proofed',
        'pia___other_products___quantity_of_cylinder_wraps_installed',
        'rates___finance_amount',
        'rates___finance_company',
        'undiscounted_travel_cost',
    ];
    protected $address_properties = [
        'assessement___owner___ownership_status',
        'city',
        'eeca_funding_csc_sdi',
        'post_code',
        'postal___street_address',
        'street',
        'street_address',
        'street_number',
        'street_type',
        'suburb',
    ];
    protected $contact_properties = [
        'email',
        'firstname',
        'lastname',
        'mobilephone',
        'ownership_status',
        'phone',
        'type_of_owner',
    ];
    protected $product_properties = [
        'finance___3rd_party_funding',
        'name',
        'price',
        'pricing_type',
        'product_group',
        'quantity',
        'quoted___installed',
        'unit_price',
    ];

    //Track API request usage
    protected $api_request_count = 0;
    protected $start_time;

    protected function api_request($url, $method = 'GET', $request_data = [])
    {
        $data = null;
        switch ($method) {
            case 'GET':
                $data = Http::get($url)->json();
                break;
            case 'POST':
                $data = Http::post($url, $request_data)->json();
                break;
            case 'PATCH':
                $data = Http::patch($url, $request_data)->json();
                break;
        }
        $this->api_request_count += 1;
        if ($this->api_request_count % 10 == 0) {
            sleep(1);
        }

        return $data;
    }
}
