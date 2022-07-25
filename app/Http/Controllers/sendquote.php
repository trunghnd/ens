<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Mailgun\Mailgun;

class sendquote extends Controller
{
    public function send_quote(Request $request)
    {
        function get_attachment($uri) {
            $handle = curl_init();

            curl_setopt($handle, CURLOPT_URL, $uri);
            curl_setopt($handle, CURLOPT_POST, false);
            curl_setopt($handle, CURLOPT_BINARYTRANSFER, false);
            curl_setopt($handle, CURLOPT_HEADER, true);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36');

            $response = curl_exec($handle);
            $hlength  = curl_getinfo($handle, CURLINFO_HEADER_SIZE);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            $body     = substr($response, $hlength);

            // If HTTP response is not 200, throw exception
            if ($httpCode != 200) {
                throw new \Exception($httpCode);
            }

            return $body;
        }



        function sendTestEmail()
        {
            echo 'Starting Email send<br>';
            //ens api
            $apiKey = env('MAILGUN_API_KEY');
            $base_url = 'app.kiwi.energysmart.co.nz';

            $mg = Mailgun::create($apiKey);
            $domain = $base_url;

            $path = \url('/');
            //$file_path = $path.'/'.$file_name;

            $file_path = "https://kiwi.energysmart.co.nz/hubfs/app/assets/7199633532/quotes/Insulation_Quote-804635-1639696350.pdf";

            $file_name = "filename.pdf";
            //echo $file_path;
            /*
            $email_body = view('tilehausemail', compact('data'))->render();
            */

            $email_body = 'This is the email body';
            $to_array = array('jonathan.brake@hypeanddexter.nz');
            $to_string = join(",", $to_array);
            $mg->messages()->send($domain, [
  'from'    => 'ENS APP <hello@app.kiwi.energysmart.co.nz>',
  'to'      => $to_string,
  'subject' => 'TEST EMAIL FROM ENS',
  'html'    => $email_body,
  'attachment' => array(array('filename' => $file_name, 'filePath' => $file_path))
]);
        }//sendEmail()



        function sendEmail(Request $request) {

            $jsonbody = json_decode($request->getContent(), true);

            $assessmentID = $jsonbody['assessmentID'];
            $quote_url = $jsonbody['quote'];
            $jobnumber =  $jsonbody['jobnumber'];
            $filename = "Energy_Smart_Quote.pdf";
            if ($quote_url) {
                $quote = get_attachment($quote_url);
            } else {
                $quote = false;
            }
            $brochures_array = $jsonbody['brochures'];

           //Get associated address from HS
            $address = Http::get("https://api.hubapi.com/crm/v3/objects/0-3/{$assessmentID}/associations/2-1185166?hapikey=" . config('hubspot.api_key'))->json();

            //Get all address' associated contacts
            if (isset($address['results']) && count($address['results'])) {
                Log::debug('quote:address', $address['results']);
                $contacts = Http::get("https://api.hubapi.com/crm/v3/objects/2-1185166/{$address['results'][0]['id']}/associations/0-1?hapikey=" . config('hubspot.api_key'))->json();

                if (!count($contacts['results'])) {
                    Log::error("quote {$jobnumber}: no contacts for address {$address['results'][0]['id']}");
                    throw new Exception("GenQuote: no contacts for address {$address['results'][0]['id']} (quote {$jobnumber}");
                }

                //Email attached quote to Contacts that have the Owner Type field set
                $logo_url = asset('images/energysmart-signature.jpg');
                $mg = Mailgun::create(config('mailgun.api_key'));
                foreach ($contacts['results'] as $c) {
                    $contact = Http::get("https://api.hubapi.com/crm/v3/objects/contacts/{$c['id']}?properties=ownership_status,type_of_owner,email,firstname,lastname&hapikey=" . config('hubspot.api_key'))->json();

                    if (!in_array($contact['properties']['ownership_status'], ['Owner Occupier', 'Landlord', 'Property Manager'])) {
                        Log::debug("quote {$jobnumber}: contact {$contact['id']} ({$contact['properties']['ownership_status']}) skipped");
                        continue;
                    }
                    if (empty($contact['properties']['email'])) {
                        Log::debug("quote {$jobnumber}: contact {$contact['id']} ({$contact['properties']['ownership_status']}) skipped");
                        continue;
                    }
                    //Send email via mailgun
                    Log::debug("quote {$jobnumber}: contact {$contact['id']} ({$contact['properties']['ownership_status']}) emailed");
                    $customer_name = "{$contact['properties']['firstname']} {$contact['properties']['lastname']}";
                    $to = $contact['properties']['email'];
                    //$to = 'jonathan.brake@hypeanddexter.nz';
                    $brochure_text = "";
                    $html = "
                    <p>Dear ".$customer_name.",<br>
                    <br>
                    Thank you for the opportunity to assess your home and to provide you a quotation for our recommended solutions.<br>";
                    if(count($brochures_array) > 0){
                        $html .= "<br>
                        Brochures:";
                        $brochure_text = "Brochures:
";
                        foreach ($brochures_array as $brochure){
                            $html .= "<br><a href='".$brochure["url"]."' target='_blank'>".$brochure["name"]."</a>";
                            $brochure_text .= $brochure["name"].": ". $brochure["url"]."
";
                        }
                        $html .= "<br>";
                    }
                    $html .= "<br>
                    In order for you to proceed with our proposed solution you will need to:<br>
                    1. Read the attached PDF Quotation document.<br>
                    2. Pay the deposit. Once the deposit has been paid, our team shall be in contact with you to arrange a suitable date for installation.<br>
                    <br>
                    To pay a deposit by:<br>
                    Internet Banking: pay to account ANZ 06 0821 0259765 05 and reference the Quote Number in the attached PDF Quotation.<br>
                    Credit Card: Phone 0800 777 111 and speak to your local office.<br>
                    Cheque: Post to EnergySmart, P O Box 19755, Christchurch 8241<br>
                    <br>
                    Kind regards,<br>
                    The EnergySmart Team<br>
                    <br>
                    55 Francella Street &middot; PO Box 19755, Christchurch 8241<br>
                    <a href='tel:0800777111'>0800 777 111</a> &middot; <a href='https://www.energysmart.co.nz/'>energysmart.co.nz</a><br>
                    <br>
                    EnergySmart Auckland ph: <a href='tel:0800777111'>0800 777 111</a><br>
                    <a href='mailto:support@energysmart.co.nz/'>support@energysmart.co.nz</a></p>";

                    $mg_res = $mg->messages()->send('app.kiwi.energysmart.co.nz', [
                        'from'    => 'noreply@app.kiwi.energysmart.co.nz',
                        'to'      => $to,
                        'bcc'     => ['7882545@bcc.hubspot.com'],
                        'subject' => 'EnergySmart Quotation',
                        'attachment' => [['fileContent' => $quote, 'filename' => $filename]],
                        'text'    => "Dear ${customer_name},

Thank you for the opportunity to assess your home and to provide you a quotation for our recommended solutions.
${brochure_text}
In order for you to proceed with our proposed solution you will need to:
1. Read the attached PDF Quotation document.
2. Pay the deposit. Once the deposit has been paid, our team shall be in contact with you to arrange a suitable date for installation.

To pay a deposit by:
Internet Banking: pay to account ANZ 06 0821 0259765 05 and reference the Quote Number in the attached PDF Quotation.
Credit Card: Phone 0800 777 111 and speak to your local office.
Cheque: Post to EnergySmart, P O Box 19755, Christchurch 8241

Kind regards,
The EnergySmart Team

55 Francella Street • PO Box 19755, Christchurch 8241
0800 777 111 • energysmart.co.nz

EnergySmart Auckland ph: 0800777111
support@energysmart.co.nz",
                        'html' => $html
                    ]);
                    Log::debug("quote {$jobnumber} email sent", [$mg_res]);
                }

            } else {
                throw new Exception("GenQuote: ".$assessmentID." assessment not found");
            }
            
        }//sendEmail()


        sendEmail($request);
/*
        function init()
        {
            echo 'hi there okay';

            //sendTestEmail();
            sendEmail();
        }//init()


        init();
*/

    }//send_quote()
}//sendquote()
