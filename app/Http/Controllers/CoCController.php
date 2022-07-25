<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PDF;

class CoCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF(Request $request)
    {

        $reqbody = json_decode($request->getContent(), true);
        Log::debug("coc: requested", [$reqbody]);
        if (empty($reqbody['objectId']) || empty($reqbody['objectType'] || $reqbody['objectType'] != 'DEAL')) {
            return response('Error.', 500);
        }

        //Get Deal
        $deal_id = $reqbody['objectId'];

         //paths to assets
         $pathLogo = public_path().'/images/energysmart-logo.png';
         $pathRMC = public_path().'/images/rcm.png';
         $pathBlankCheckbox = public_path().'/images/blank-check-box.png';
         $pathCheckbox = public_path().'/images/check-box.png';
 
         $pathCSS = public_path().'/css/coc.css';
 
         //Get assets
         $imageLogo = base64_encode(file_get_contents($pathLogo));
         $imageRMC = base64_encode(file_get_contents($pathRMC));
         $imageBlankCheckBox = base64_encode(file_get_contents($pathBlankCheckbox));
         $imageCheckBox = base64_encode(file_get_contents($pathCheckbox));
 
         $css = file_get_contents($pathCSS);
 
         $data = $this->get_data($deal_id);
         // return $data;
         $filename ='Heat_Pump_CoC-' . $data['deal']['dealname'] . "_" . time() . ".pdf";
         $data['rmc'] = $imageRMC;
         $data['logo'] = $imageLogo;
         $data['css'] = $css;
         $data['blankCheckBox'] = $imageBlankCheckBox;
         $data['checkBox'] = $imageCheckBox;
         $pdf = PDF::loadView('coc-pdf', $data);
        $coc = $pdf->output();
        // return $pdf->download('coc.pdf');
        // return view('coc-pdf', $data);
        // return $data['deal'];
        Log::info("coc: generated PDF for deal ${deal_id}");

        //Upload and attach to Deal
        $response = Http::attach(
            'file',
            $coc,
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
            'folderPath' => '/app/assets/'.$deal_id.'/coc'
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
                "subject"=> "CoC",
                "body"=> $file_res['url']
            ]
        ];

        $response = Http::post('https://api.hubapi.com/engagements/v1/engagements?hapikey=' . config('hubspot.api_key'), $note);

        $note_res = $response->json();
        Log::debug("coc: attached PDF to deal ${deal_id}");

        /* Update deal and add PDF URL in property */
        $deal_update = [
            "properties" => [
                "heat_pump___coc___pdf_link" => $file_res['url']
            ]
        ];

        $deal_resp = Http::patch('https://api.hubapi.com/crm/v3/objects/deal/'.$deal_id.'?hapikey=' . config('hubspot.api_key'), $deal_update);
        return $deal_resp;
        Log::debug("coc: added PDF URL to deal ${deal_id}");

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
            'street_address',
            'owner_name',
            'owner_contact_number',
            'heat_pump___coc___type_of_work',
            'heat_pump___coc___the_prescribed_electrical_work_is',
            'deal.heat_pump___coc___specify_high_risk',
            'heat_pump___coc___additional_standards_of_electrical_code_of_practice_were_required',
            'heat_pump___coc___specify_additional_standards',
            'heat_pump___coc___from_date_that_prescribed_electrical_work_undertaken',
            'heat_pump___coc___to_date_that_prescribed_electrical_work_undertaken',
            'heat_pump___coc___contains_fittings_that_are_safe_to_connect_to_a_power_supply',
            'heat_pump___coc___specify_type_of_supply_system',
            'heat_pump___coc___the_installation_has_an_earthing_system_that_is__correctly_rated',
            'heat_pump___coc___ps_of_the_installation_to_which_this_certificate_relates_that__are_safe_to_con',
            'heat_pump___coc___specify',
            'heat_pump___coc___description_of_work',
            'heat_pump___coc___the_work_relies_on_manufacturers_instructions',
            'heat_pump___coc___instruction_manual_name',
            'heat_pump___coc___instruction_manual_date',
            'heat_pump___coc___instruction_manual_version',
            'heat_pump___coc___instruction_manual_file',
            'heat_pump___coc___instruction_manual_file_link',
            'heat_pump___coc___instruction_manual_file_attachment',
            'heat_pump___coc___means_of_as_nzs_3000_compliance',
            'heat_pump___coc___parts_of_the_installation_to_which_this_certificate_relates_that__are_safe_to_con',
            'heat_pump___coc___the_work_has_been_done_in_accordance_with_a_certified_design',
            'heat_pump___coc___certified_design_name',
            'heat_pump___coc___certified_design_date',
            'heat_pump___coc___certified_design_version',
            'heat_pump___coc___certified_design_file',
            'heat_pump___coc___certified_design_file_link',
            'heat_pump___coc___certified_design_file_attachment',
            'heat_pump___coc___the_work_relies_on_a_supplier_declaration_of_conformity',
            'heat_pump___coc___sdoc_name',
            'heat_pump___coc___sdoc_date',
            'heat_pump___coc___sdoc_version_or_eess_registration',
            'heat_pump___coc___sdoc_file',
            'heat_pump___coc___sdoc_file_link',
            'heat_pump___coc___sdoc_file_attachment',
            'heat_pump___coc___test_results___polarity__independent_earth_',
            'heat_pump___coc___test_results___polarity',
            'heat_pump___coc___test_results___insulation_resistance',
            'heat_pump___coc___test_results___earth_continuity',
            'heat_pump___coc___test_results___bonding',
            'heat_pump___coc___test_results___fault_loop_impedance',
            'heat_pump___coc___test_results___other',
            'heat_pump___coc___test_results___specify_other',
            'pia___h__amp__s_finish___installer_signature',
            'pia___h___s_finish___date',
            'pia___h___s_finish___time',
            'pia___h___s_finish___team_lead',
            'pia___h__amp__s_finish___installer_signature',
            'installation_booked_date',
            'heat_pump___coc___specify_high_risk',
            'installer'
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

        //Convert sigature image to base64
        $installer_signature_url = $deal['properties']['pia___h__amp__s_finish___installer_signature'];
        if(!empty($installer_signature_url)){
            $to_remove = array('[', '"', ']');//to remove not url chars
            $installer_signature_url = str_replace($to_remove, '', $installer_signature_url);
            $signature_header = get_headers($installer_signature_url);
            if(stripos($signature_header[0],"200 OK")){//check if image url exists
                $installer_signature = file_get_contents($installer_signature_url);
                if($installer_signature){
                    $deal['properties']['installer_signature'] = base64_encode($installer_signature);
                }
            }
        }
        // get pia___h___s_finish___team_lead details
        if(isset($deal['properties']['pia___h___s_finish___team_lead'])){
            $id =$deal['properties']['pia___h___s_finish___team_lead'];
            $user = Http::get("https://api.hubapi.com/crm/v3/owners/".$id."?idProperty=id&archived=false&hapikey=" . config('hubspot.api_key'))->json();
           
            
            if(isset($user['firstName'])){
                $deal['properties']['pia___h___s_finish___team_lead'] = $user['firstName'] .' '.$user['lastName'];
            }           
            
        }

        $contact_data = [
            'practicing_licence_number' => '',
            'email' => '',
            'firstname' => '',
            'lastname' => '',
            'phone' => '',
            'mobilephone' => ''
        ];

        if(!empty($deal['properties']['installer'])){
            $installerId = $deal['properties']['installer'];
            $installer = Http::get("https://api.hubapi.com/crm/v3/owners/".$installerId."?idProperty=id&archived=false&hapikey=" . config('hubspot.api_key'))->json();
            $contact_data['firstname'] = $installer['firstName'];
            $contact_data['lastname'] = $installer['lastName'];
        }


        $data = [
            'deal' => $deal['properties'],
            'contact' => $contact_data
        ];

        // $search_data = [
        //     "filterGroups" =>[
        //         [
        //             "filters" =>[
        //                 [
        //                     "propertyName" => "employee_type",
        //                     "operator" => "EQ",
        //                     "value" => "Electrician Team Lead"
        //                 ]
        //             ]
        //         ]
        //     ]
        // ];

        // $contacts_res = Http::post("https://api.hubapi.com/crm/v3/objects/contacts/search?hapikey=" . config('hubspot.api_key'),$search_data)->json();
        
        // $contact_data = [
        //     'practicing_licence_number' => '',
        //     'email' => '',
        //     'firstname' => '',
        //     'lastname' => '',
        //     'phone' => '',
        //     'mobilephone' => ''
        // ];
        // $contacts_results = $contacts_res['results'];
        // if(count($contacts_results) > 0){
        //     //use first id only if more is found
        //     $id = $contacts_results[0]['id'];
        //     $contact = Http::get("https://api.hubapi.com/crm/v3/objects/contacts/{$id}?properties=practicing_licence_number,email,firstname,lastname,phone,mobilephone&hapikey=" . config('hubspot.api_key'))->json();
        //     $contact_data = $contact['properties'];
        
        // }

        // $data = [
        //     'deal' => $deal['properties'],
        //     'contact' => $contact_data
        // ];
        return $data;
    }
}


