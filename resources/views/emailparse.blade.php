<?php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

include(app_path().'/includes/simple_html_dom.php');

//ENS
$apikey = config('hubspot.api_key');

function init($apikey)
{
    $limit = 50;
    $allengs = getreceng($apikey, $limit);

    foreach ($allengs['results'] as $e) {
        if (!isset($e['metadata']['from']['email'])) {
            continue;
        }
        // Skip emails that have already been associated to a contact besides the sender
        if (count($e['associations']['contactIds']) > 0) {
            continue;
        }

        if ($e['metadata']['from']['email'] == "warmerkiwihomes@eeca.govt.nz") {
            $emailhtml = $e['metadata']['html'];
            $parsedData = parseHTML($emailhtml);

            Log::debug("email: Engagement ID: ".$e['engagement']['id'], [$parsedData]);

            if (isset($parsedData['Email:'])) {
                $contact_email = $parsedData['Email:'];
                if (!empty($contact_email)) {
                    $f_contact = findContact($apikey, $contact_email);
                } else {
                    $f_contact = null;
                }

                Log::debug("email: Found contact", [$f_contact]);

                //If contact exists
                if (isset($f_contact['results'][0]['id'])) {
                    echo"<pre>Contact exists</pre>";
                    create_con($apikey, $parsedData, $f_contact['results'][0]['id']);
                    /*
                    if ($f_contact['results'][0]['properties']['customer_services_owner']=='') {
                        //update if no contact services owner to enroll in workflow
                        $type = "enroll";
                        $con_id = $f_contact['results'][0]['id'];
                        update_con($apikey, $con_id, $type);
                    } else {
                        //update the lead source to "Repeat Contact"
                        if (isset($f_contact['results'][0]['properties']['lead_status'])) {
                            if ($f_contact['results'][0]['properties']['lead_status']=='Completed') {
                                $con_id = $f_contact['results'][0]['id'];
                                $type = "repeat";

                                update_con($apikey, $con_id, $type);
                            }//If contact
                        }
                    }
                    */
                    $con_id = $f_contact['results'][0]['id'];
                    $eng_id = $e['engagement']['id'];
                    $associate_engagement = assoc_engage($apikey, $eng_id, $con_id);
                } else {
                    Log::debug("email: Contact does not exist");
                    echo"<pre>Contact does not exist</pre>";
                    $new_con = create_con($apikey, $parsedData);
                    if (!empty($new_con['id'])) {
                        $con_id = $new_con['id'];
                        $eng_id = $e['engagement']['id'];
                        $associate_engagement = assoc_engage($apikey, $eng_id, $con_id);
                    }
                }
            }
        }//if from warmerkiwihomes@eeca.govt.nz
    }//allengs loop
}//init

init($apikey);

function update_con($apikey, $con_id, $type, $parsedData)
{
    if ($type == "enroll") {
        $package = '{
          "properties": {
            "cs_email_parse": "true"
          }
        }';
    }

    if ($type = "") {
        $package = '{
          "properties": {
            "lead_status": "true"
          }
        }';
    }

    $packageArray = json_decode($package, true);
    $response = Http::patch('https://api.hubapi.com/crm/v3/objects/contacts/'.$con_id.'?hapikey='.$apikey, $packageArray);

    $res = $response->json();

    return $res;
}

function create_con($apikey, $parsedData, $contactId = null)
{
    $name_segments = explode(" ", $parsedData['Name:'], 2);
    $firstname = $name_segments[0];
    $lastname = "";

    if (isset($name_segments[1])) {
        $lastname = $name_segments[1];
    }
    $address = str_replace(' - This address has been verified in EECA’s claims system.', '', $parsedData['Address:']);

    $package = '{
      "properties": {
        "firstname": "'.$firstname.'",
        "lastname": "'.$lastname.'",
        "phone": "'.$parsedData['Phone:'].'",
        "email": "'.$parsedData['Email:'].'",
        "address": "'.$address.'",
        "lead_source": "Online Enquiry | WKH Tool"
      }
    }';

    $packageArray = json_decode($package, true);
    if ($contactId) {
        $response = Http::patch("https://api.hubapi.com/crm/v3/objects/contacts/{$contactId}/?hapikey={$apikey}", $packageArray);
    } else {
        $response = Http::post("https://api.hubapi.com/crm/v3/objects/contacts?hapikey={$apikey}", $packageArray);
    }
    $res = $response->json();

    echo"<pre>Created contact:\n";
    print_r($packageArray);
    print_r($res);
    echo"<pre>";
    Log::debug("email: Created contact", $packageArray);

    return $res;
}//create_con()

function assoc_engage($apikey, $eng_id, $con_id)
{
    $package = '{
      "fromObjectId": '.$con_id.',
      "toObjectId": '.$eng_id.',
      "category": "HUBSPOT_DEFINED",
      "definitionId": 9
    }';
    $packageArray = json_decode($package, true);
    $response = Http::put('https://api.hubapi.com/crm-associations/v1/associations?hapikey='.$apikey, $packageArray);
    $res = $response->json();
    echo"<pre>Assoc engagement:\n";
    print_r($packageArray);
    print_r($res);
    echo"<pre>";
    Log::debug("email: Assoc engagement", $packageArray);


    return $res;
}//assoc_engage

function findContact($apikey, $contact_email)
{
    $package = '{
    "filterGroups":[
      {
        "filters":[
          {
            "propertyName": "email",
            "operator": "EQ",
            "value": "'.$contact_email.'"
          }
        ]
      }
    ],
    "properties": [
    "id",
    "customer_services_owner",
    "hs_lead_status"
    ]
  }';
    $packageArray = json_decode($package, true);
    $response = Http::post('https://api.hubapi.com/crm/v3/objects/contacts/search?hapikey='.$apikey, $packageArray);
    $res = $response->json();

    return $res;
}//findContact

function parseHTML($emailhtml)
{
    $html = str_get_html($emailhtml);
    $parseData = array();
    foreach ($html->find('tr') as $elem) {
        if (null !== $elem->children(0)) {
            $key = $elem->children(0)->plaintext;

            //Get value condition

            if (null !== $elem->children(1)) {
                $value = $elem->children(1)->plaintext;

                $parseData[$key] = $value;
            }//value if
        }

        //echo $elem->children(0)->plaintext . '<br>';
    }

    return $parseData;
}//parseHTML()

function getreceng($apikey, $limit)
{
    $date = time() - 1800;    //Get the timestamp from an hour ago

    $hsdate = $date."000";

    $curl = curl_init();
    curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.hubapi.com/engagements/v1/engagements/recent/modified?hapikey=".$apikey."&count=".$limit."&since=".$hsdate,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Cookie: __cfduid=d888ce1e3573590fe5efe78f1b129907b1604277370"
  ),
));
    $response = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($response, true);

    return $result ?? [];
}
