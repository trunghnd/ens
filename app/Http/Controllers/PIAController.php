<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mailgun\Mailgun;
use PDF;

class PIAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF(Request $request)
    {
        $reqbody = json_decode($request->getContent(), true);
        Log::debug("pia: requested", [$reqbody]);
        if (empty($reqbody['objectId']) || empty($reqbody['objectType'] || $reqbody['objectType'] != 'DEAL')) {
            return response('Error.', 500);
        }

        //Get Deal
        $deal_id = $reqbody['objectId'];
        $data = $this->get_data($deal_id);
        Log::debug("pia: got deal ${deal_id}");

        //Generate PDF 
       //$filename = time() . '-' . $deal_id . '.pdf';
        $filename = $data['deal']['assessment_type'] . '_PIA-' . $data['deal']['dealname'] . "_" . time() . ".pdf";
        $pdf = PDF::loadView('pia-pdf', $data);
        $pia = $pdf->output();
        Log::info("pia: generated PDF for deal ${deal_id}");

        //Upload and attach to Deal
        $response = Http::attach(
            'file',
            $pia,
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
        'folderPath' => '/app/assets/'.$deal_id.'/pia'
        ]);

        $file_res = $response->json();

        /*Add to note and attach*/
        $note = [
            "engagement"=> [
                "active"=> true,
                "type"=> "NOTE",
                "timestamp"=> time() * 1000,
            ],
            "associations"=> [
                "dealIds"=> [$deal_id],
            ],
            "attachments"=> [
                [ "id"=> $file_res['id'] ]
            ],
            "metadata"=> [
                "subject"=> "PIA",
                "body"=> $file_res['url']
            ]
        ];

        $response = Http::post('https://api.hubapi.com/engagements/v1/engagements?hapikey=' . config('hubspot.api_key'), $note);

        $note_res = $response->json();
        Log::debug("pia: attached PDF to deal ${deal_id}");

        /* Update deal and add PDF URL in property */
        $deal_update = [
            "properties" => [
                "pia___latest_pia" => $file_res['url']
            ]
        ];

        $deal_resp = Http::patch('https://api.hubapi.com/crm/v3/objects/deal/'.$deal_id.'?hapikey=' . config('hubspot.api_key'), $deal_update);
        if ($deal_resp->ok()) {
            Log::debug("pia: added PDF URL to deal ${deal_id}");
        }

        return $file_res;
    }

    public function test($deal_id)
    {
        $data = $this->get_data($deal_id);

        return view('pia-pdf', $data);
    }

    public function get_data($deal_id)
    {
        $deal_fields = [
            'dealname',
            'assessment_type',
            'owner_name',
            'owner_contact_number',
            'owner_mobile',
            'assessment___occupant_details___mobile',
            'assessment___occupant_details___telephone',
            'installation_booked_date',
            'insulation_assessment___other_measures___hwc_pipe_lagging_req',
            'insulation_assessment___site_assessment___decade_built',
            'insulation_assessment___site_assessment___storeys',
            'insulation_assessment___underfloor___why_is_space_not_accessible',
            'insulation_assessment___ceiling___insulation_work_necessary',
            'pia___ceiling___any_insulation_touching_roofing_materials_',
            'pia___ceiling___any_open_air_pockets_along_perimeter_and_edges_',
            'pia___ceiling___any_significant_gaps__tucks_or_folds_',
            'pia___ceiling___ceiling_installation_meets_nz_4246_intent_',
            'pia___ceiling___clearance_to_ceiling_rdl',
            'pia___ceiling___clearance_to_chimney_and_outer_faces_of_flue',
            'pia___ceiling___clearance_to_other_ceiling_cd',
            'pia___ceiling___existing_insulation_refitted_levelled_damp_insulation_removed_',
            'pia___ceiling___gaps___50mm_width_in_existing_insulation_filled_',
            'pia___ceiling___good_friction_fits_in_ceiling',
            'pia___ceiling___installation_debris_removed_from_ceiling_',
            'pia___ceiling___installer_and_manufacturers_label_present',
            'pia___ceiling___insulation_installed_in_ceiling_space_with_foil_as_roof_underlay_',
            'pia___ceiling___insulation_installed_under_header_tank',
            'pia___ceiling___is_product_installed_on_funding_agreement_',
            'pia___ceiling___no_air_movement_between_insulation_and_ceiling_',
            'pia___ceiling___quantity_of_ceiling_rdl',
            'pia___ceiling___quantity_of_chimney_and_flue',
            'pia___ceiling___quantity_of_other_ceiling_cd',
            'pia___ceiling___recessed_space_insulated_down_and_across',
            'pia___ceiling___tightly_fitted_between_joists_ceiling_runners_and_strong_backs_',
            'pia___ceiling___top_plate_covered_',
            'pia___ceiling___was_ceiling_access_hatch_insulated_',
            'pia___ceiling___was_correct_ceiling_product_installed_',
            'pia___ceiling___was_there_existing_insulation_in_ceiling_',
            'pia___ceiling_wall___any_significant_gaps__tucks_or_folds',
            'pia___ceiling_wall___ceiling_space_wall_insulation_installed_',
            'pia___ceiling_wall___installer_and_manufacturer_labels_present',
            'pia___ceiling_wall___insulation_compressed',
            'pia___ceiling_wall___insulation_meets_nzs4246',
            'pia___ceiling_wall___is_product_installed_on_the_funding_agreement',
            'pia___ceiling_wall___product_fastened_into_place_with_full_contact',
            'pia___finalise___branch_manager_signature',
            'pia___finalise___finalisation_comments',
            'pia___finalise___finalisation_date',
            'pia___finalise___finalised_by',
            'pia___h__s_finish___assessment___hazard_id_sighted',
            'pia___other_products___does_qa_manual_recommend_gvb_',
            'pia___other_products___gvb_comments',
            'pia___other_products___gvb_installation_debris_removed_',
            'pia___other_products___gvb_installed_as_per_nz_4246_',
            'pia___other_products___gvb_installed_quantity',
            'pia___other_products___length_of_lagging_installed',
            'pia___other_products___pipe_lagging_as_per_climate_zone_requirements_',
            'pia___other_products___pipe_lagging_properly_fixed_',
            'pia___other_products___was_gvb_installed_',
            'pia___subfloor_wall___any_significant_gaps__tucks_or_folds',
            'pia___subfloor_wall___insulation_compressed',
            'pia___subfloor_wall___insulation_meets_nzs4246',
            'pia___subfloor_wall___is_product_installed_correct_as_per_eeca_spec',
            'pia___subfloor_wall___product_fastened_into_place_with_full_contact',
            'pia___subfloor_wall___product_label_correctly_fixed_on_site',
            'pia___subfloor_wall___service_area_prod_group_____3_or_non_combustible',
            'pia___subfloor_wall___good_friction_fits',
            'pia___subfloor_wall___was_subfloor_space_wall_insulation_installed_',
            'pia___underfloor___all_accessible_underfloor_areas_done_',
            'pia___underfloor___any_folds_too_big_with_insulation_hanging_below_joists_',
            'pia___underfloor___any_sagging_in_underfloor_insulation_',
            'pia___underfloor___any_significant_gaps_underfloor',
            'pia___underfloor___clearance_to_underfloor_cd',
            'pia___underfloor___clearances_maintained_to_underfloor_plumbing_',
            'pia___underfloor___existing_insulation_remaining_',
            'pia___underfloor___good_friction_fits_underfloor_',
            'pia___underfloor___has_the_product_been_stabled_correctly_',
            'pia___underfloor___installer_and_manufacturer_s_label_present_',
            'pia___underfloor___insulation_compressed_',
            'pia___underfloor___insulation_in_full_contact_under_floor_',
            'pia___underfloor___insulation_quantity',
            'pia___underfloor___is_product_installed_on_funding_agreement_',
            'pia___underfloor___is_subfloor_not_enclosed__product_suitable_for_open_perimeter_floor_',
            'pia___underfloor___product_installed_to_bottom_plate_',
            'pia___underfloor___quantity_of_underfloor_cd',
            'pia___underfloor___service_area_product_group_number__3_or_non_combustible_',
            'pia___underfloor___underfloor_insulation_debris_removed_',
            'pia___underfloor___underfloor_insulation_meets_nz_4246_intent_',
            'post_code',
            'street_address',
        ];
        $deal_properties = join(',', $deal_fields);

        //Get Deal
        $deal = Http::get("https://api.hubapi.com/crm/v3/objects/deals/{$deal_id}?properties={$deal_properties}&hapikey=" . config('hubspot.api_key'))->json();

        $deal['properties']['id'] = $deal['id'];
        //Translate HS booleans to Yes/No
        foreach ($deal['properties'] as &$property) {
            if ($property == 'true') {
                $property = 'Yes';
            } elseif ($property == 'false') {
                $property = 'No';
            }
        }

        $data = [
            'deal' => $deal['properties']
        ];

        //Get Quoted Products
        $quoted_products = Http::get("https://api.hubapi.com/crm/v3/objects/0-3/{$deal['id']}/associations/2-1494682?hapikey=" . config('hubspot.api_key'))->json();

        $products = [];
        foreach ($quoted_products['results'] as $c) {
            $get_product = Http::get("https://api.hubapi.com/crm/v3/objects/2-1494682/{$c['id']}?properties=pricing_type,js_position,name,eeca_name,quantity,quoted___installed,unit_measure&hapikey=" . config('hubspot.api_key'));
            if (!$get_product->ok()) {
                continue;
            }
            
            $quoted_product = $get_product->json();
            $product = $quoted_product['properties'];
            $product['id'] = $quoted_product['id'];

            if ($quoted_product['properties']['pricing_type'] && $quoted_product['properties']['quoted___installed']) {
                $product_type = $quoted_product['properties']['pricing_type'];
                $product_name = trim($quoted_product['properties']['eeca_name']);
                $product_state = $quoted_product['properties']['quoted___installed'];
                $product_addedby = $quoted_product['properties']['js_position'];
                $product_quantity = $quoted_product['properties']['quantity'];
                if($product_state == 'Quoted' && $product_addedby == 'Added on JobSheet'){
                    $product_quantity = 0;    
                }

                if (!empty($products[$product_type][$product_name][$product_state])) {
                    $products[$product_type][$product_name][$product_state] += $product_quantity;
                } else {
                    $products[$product_type][$product_name][$product_state] = $product_quantity;
                }
            }
        }

        // remove non-installed item
        foreach ($products as $product_type => $product_list) {
            foreach ($product_list as $product_name=>$product) {       
                if (empty($product['Installed']) || $product['Installed'] < 1) {
                    // unset($product_list[$product_name]);
                    unset($products[$product_type][$product_name]);
                }
            }
        }


        $installed_types = [];
        foreach ($products as $product_type => $product_list) {
            foreach ($product_list as $product) {       
                if (!empty($product['Installed']) && $product['Installed'] > 0) {
                    $installed_types[$product_type] = true;
                }
    
            }
        }

        $data['products'] = $products;
        $data['installed_types'] = $installed_types;

       // $data['audit_passed'] = ( this is not longer used. should only show passeed. https://www.wrike.com/workspace.htm?acc=2735225#/task-view?id=860443868&pid=695189724&cid=364564370
       //     $deal['properties']['pia___ceiling_wall___insulation_meets_nzs4246'] == 'Yes' &&
       //     $deal['properties']['pia___other_products___gvb_installed_as_per_nz_4246_'] == 'Yes' &&
       //     $deal['properties']['pia___underfloor___underfloor_insulation_meets_nz_4246_intent_'] == 'Yes' &&
        //    $deal['properties']['pia___subfloor_wall___insulation_meets_nzs4246'] == 'Yes' &&
       //     $deal['properties']['pia___ceiling___ceiling_installation_meets_nz_4246_intent_'] == 'Yes'
       // );

        //Get associated address
        $address = Http::get("https://api.hubapi.com/crm/v3/objects/0-3/{$deal['id']}/associations/2-1185166?hapikey=" . config('hubspot.api_key'))->json();

        //Get all address' associated contacts
        $contacts = Http::get("https://api.hubapi.com/crm/v3/objects/2-1185166/{$address['results'][0]['id']}/associations/0-1?hapikey=" . config('hubspot.api_key'))->json();

        foreach ($contacts['results'] as $c) {
            $contact = Http::get("https://api.hubapi.com/crm/v3/objects/contacts/{$c['id']}?properties=type_of_owner,ownership_status,email,firstname,lastname,phone,mobilephone&hapikey=" . config('hubspot.api_key'))->json();

            $contact['properties']['id'] = $contact['id'];
            switch ($contact['properties']['type_of_owner']) {
                case 'Owner Occupier':
                    $data['owner'] = $contact['properties'];
                    $data['occupant'] = $contact['properties'];
                    break;
                case 'Landlord':
                    $data['owner'] = $contact['properties'];
                    $data['landlord'] = $contact['properties'];
                    break;
                case 'Property Manager':
                    $data['property_manager'] = $contact['properties'];
                    break;
                default:
            }

            switch ($contact['properties']['ownership_status']) {
                case 'Owner Occupier':
                case 'Landlord':
                case 'Property Manager':
                    $data['deal']['ownership_status'] = $contact['properties']['ownership_status'];
                    break;
                case 'Occupant':
                    $data['occupant'] = $contact['properties'];
                    break;
                default:
            }
        }

        return $data;
    }
}
