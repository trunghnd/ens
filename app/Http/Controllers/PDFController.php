<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mailgun\Mailgun;
use PDF;

class PDFController extends Controller
{
    /**
     * Return the Quote PDF directly to the browser, for testing
     * 
     */
    public function test(Request $request)
    {
        $pdf = $this->gen_pdf($request);
        return $pdf->stream();
    }

    protected function gen_pdf(Request $request)
    {
        $jsonbody = json_decode($request->getContent(), true);
        Log::debug("gen_pdf:body", $jsonbody);

        /* DOnt think we need this here as it is in generate_quote
        $pdf_name = time().'-'.$jsonbody['properties']['quote_number'];
        $pdf_name = $jsonbody['properties']['assessment_type'].'_Quote'.'-'.$jsonbody['properties']['quote_number'].'-'.time();
        
        $pdf_name_prefix = $jsonbody['properties']['assessment_type'];
        $pdf_name = $pdf_name_prefix.'_Quote-B'.'-'.$jsonbody['properties']['quote_number'].'-'.time();
        
        */

        $data = [
            'assessor_name' => $jsonbody['assessor_name'] ?? "Not set",
            'assessor_email' => $jsonbody['assessor_email'] ?? "Not set",
            'contact_for_access' => $jsonbody['properties']['contact_for_access'] ?? "Not set",
            'owner_name' => $jsonbody['properties']['owner_name'] ?? "Not set",
            'owner_email' => $jsonbody['properties']['owner_email'] ?? "Not set",
            'property_address' => $jsonbody['properties']['property_address'] ?? "Not set",
            'postal_address' => $jsonbody['properties']['postal_address'] ?? "Not set",
            'owner_telephone' => $jsonbody['properties']['owner_telephone'] ?? "Not set",
            'owner_mobile_phone' => $jsonbody['properties']['owner_mobile_phone'] ?? "Not set",
            'ownership_status' => $jsonbody['properties']['ownership_status'] ?? "Not set",
            'quote_date' => $jsonbody['properties']['quote_date'] ?? "Not set",
            'quote_notes' => $jsonbody['properties']['quote_notes'] ?? "Not set",
            'solution' => $jsonbody['properties']['solution'] ?? "Not set",
            'occupier_name' => $jsonbody['properties']['occupier_name'] ?? "Not set",
            'occupier_phone' => $jsonbody['properties']['occupier_phone'] ?? "Not set",
            'occupier_mobile' => $jsonbody['properties']['occupier_mobile'] ?? "",
            'occupier_email' => $jsonbody['properties']['occupier_email'] ?? "Not set",
            'product_array' => $jsonbody['products'],
            'deposit_required' => $jsonbody['properties']['deposit_required'] ?? "Not set",
            'quote_number' => $jsonbody['properties']['quote_number'] ?? "Not set",
            'totals_total' => $jsonbody['properties']['totals_total'] ?? "Not set",
            'totals_discount' => $jsonbody['properties']['totals_discount'] ?? "Not set",
            'totals_eeca_contribution' => $jsonbody['properties']['totals_eeca_contribution'] ?? "Not set",
            'totals_tpf_provider' => $jsonbody['properties']['n3rd_party_funding'] ?? "Not set",
            'totals_tpf' => $jsonbody['properties']['n3rd_party_funding_amount'] ?? "Not set",
            'totals_to_pay' => $jsonbody['properties']['totals_to_pay'] ?? "Not set",
            'totals_owners_contribution' => $jsonbody['properties']['owners_contribution'] ?? "Not set",
            'lead_time' => $jsonbody['properties']['lead_time'] ?? "Not set",
            'balance_remaining' => $jsonbody['properties']['balance_remaining'] ?? "Not set",
            'signature' => $jsonbody['properties']['signature'] ?? false,
            'date_signed' => $jsonbody['properties']['date_signed'] ?? "--",
            'actions_required_array' => $jsonbody['properties']['actions_required_array'] ?? "Not set",
            'preferred_payment_option' => $jsonbody['properties']['preferred_payment_option'] ?? "Not set",
            'assessment_type' => $jsonbody['properties']['assessment_type'] ?? "Not set"
        ];

        return PDF::loadView('quote-pdf', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generate_quote(Request $request)
    {
        $jsonbody = json_decode($request->getContent(), true);
        /*
        $pdf_name = time().'-'.$jsonbody['properties']['quote_number'];
        $pdf_name = $jsonbody['properties']['assessment_type'].'_Quote'.'-'.$jsonbody['properties']['quote_number'].'-'.time();
        $pdf_name_prefix = $jsonbody['properties']['assessment_type'];
        */
        
        $pdf_name_prefix = str_replace(' ', '_', $jsonbody['properties']['assessment_type']);
        

        $pdf_name = $pdf_name_prefix.'_Quote'.'-'.$jsonbody['properties']['quote_number'].'-'.time();

        $pdf = $this->gen_pdf($request);
        $filename = $pdf_name.'.pdf';
        $quote = $pdf->output();

        $assessmentID = $jsonbody['assessmentID'];

        $response = Http::attach(
            'file',
            $quote,
            $filename
        )->post('https://api.hubapi.com/files/v3/files?hapikey=' . config('hubspot.api_key'), [
            'fileName' => $filename,
            'charsetHunch' => 'UTF-8',
            'options' => json_encode([
                            "access" => "PUBLIC_NOT_INDEXABLE",
                            "overwrite" => false,
                            "duplicateValidationStrategy" => "NONE",
                            "duplicateValidationScope" => "EXACT_FOLDER"
                        ]),
        'folderPath' => '/app/assets/'.$assessmentID.'/quotes'
        ]);

        $file_res = $response->json();

        /*Add to note and attach*/
        $note = [
            "engagement"=> [
                "active"=> true,
                "ownerId"=> 167936641,
                "type"=> "NOTE",
                "timestamp"=> time() * 1000,
                "createdAt"=> 0
            ],
            "associations"=> [
                "contactIds"=> [],
                "companyIds"=> [],
                "dealIds"=> [$assessmentID],
                "ownerIds"=> [],
                "ticketIds"=>[]
            ],
            "attachments"=> [
                [ "id"=> $file_res['id'] ]
            ],
            "metadata"=> [
                "subject"=> "",
                "body"=> $file_res['url']
            ]
        ];

        $response = Http::post('https://api.hubapi.com/engagements/v1/engagements?hapikey=' . config('hubspot.api_key'), $note);

        $note_res = $response->json();

        /*Add to pdf string*/
        $proposal = [
            "properties" => [
                "insulation_assessment___pricing___proposal" => $note['metadata']['body'] ?? ''
            ]
        ];

        $response = Http::patch('https://api.hubapi.com/crm/v3/objects/deal/'.$assessmentID.'?hapikey=' . config('hubspot.api_key'), $proposal);

        $res = $response->json();
        if(false){ // sending the quote now happens at a separate end point. The code in the if can be deleted at a later date.
            //Get associated address from HS
            $address = Http::get("https://api.hubapi.com/crm/v3/objects/0-3/{$assessmentID}/associations/2-1185166?hapikey=" . config('hubspot.api_key'))->json();

            //Get all address' associated contacts
            if (isset($address['results']) && count($address['results'])) {
                Log::debug('quote:address', $address['results']);
                $contacts = Http::get("https://api.hubapi.com/crm/v3/objects/2-1185166/{$address['results'][0]['id']}/associations/0-1?hapikey=" . config('hubspot.api_key'))->json();

                if (!count($contacts['results'])) {
                    throw new \Exception("GenQuote: no contacts for address {$address['results'][0]['id']} (quote {$jsonbody['properties']['quote_number']}");
                }

                //Email attached quote to Contacts that have the Owner Type field set
                $logo_url = asset('images/energysmart-signature.jpg');
                $mg = Mailgun::create(config('mailgun.api_key'));
                // $mjml = new \Qferrer\Mjml\Renderer\BinaryRenderer(base_path('node_modules/.bin/mjml'));
                foreach ($contacts['results'] as $c) {
                    $contact = Http::get("https://api.hubapi.com/crm/v3/objects/contacts/{$c['id']}?properties=ownership_status,type_of_owner,email,firstname,lastname&hapikey=" . config('hubspot.api_key'))->json();

                    if (!in_array($contact['properties']['ownership_status'], ['Owner Occupier', 'Landlord'])) {
                        Log::debug('quote:skipping emailing non-owner', [$assessmentID,$contact['properties']]);
                        continue;
                    }
                    //Send email via mailgun
                    Log::debug('quote:emailing contact', [$assessmentID,$contact['properties']]);
                    $customer_name = "{$contact['properties']['firstname']} {$contact['properties']['lastname']}";
                    $to = $contact['properties']['email'];
                    $html = "";

                    $mg_res = $mg->messages()->send('app.kiwi.energysmart.co.nz', [
                        'from'    => 'noreply@app.kiwi.energysmart.co.nz',
                        'to'      => $to,
                        'bcc'     => ['7882545@bcc.hubspot.com'],
                        'subject' => 'EnergySmart Quotation',
                        'attachment' => [['fileContent' => $quote, 'filename' => $filename]],
                        'text'    => "Dear ${customer_name},

            Thank you for the opportunity to assess your home and to provide you a quotation for our recommended solutions.
            In order for you to proceed with our proposed solution you will need to:
            1. Read the attached PDF Quotation document.
            2. Pay the deposit. Once the deposit has been paid, our team shall be in contact with you to arrange a suitable date for installation.

            To pay a deposit by:
            Internet Banking: pay to account ANZ 06 0821 0259765 05 and reference the Job number 619197Chr.
            Credit Card: Phone 0800 777 111 and speak to your local oﬃce.
            Cheque: Post to EnergySmart, P O Box 19755, Christchurch 8241

            Kind regards,
            The EnergySmart Team

            55 Francella Street • PO Box 19755, Christchurch 8241
            0800 777 111 • energysmart.co.nz

            EnergySmart Auckland ph: 0800777111
            support@energysmart.co.nz",
                        'html' => $html
                    ]);
                    Log::debug('Quote email', [$mg_res]);
                }
            } else {
                throw new Exception("GenQuote: ".$jsonbody['properties']['quote_number']." address not found");
            }
        }
        return $res;
    }
}