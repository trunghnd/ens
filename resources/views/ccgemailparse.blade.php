<?php

include(app_path().'/includes/simple_html_dom.php');

//CCG
$apikey = config('hubspot.api_key');

function init($apikey)
{
    $limit = 50;
    $allengs = getreceng($apikey, $limit);

    /*
    echo"<pre>";
        print_r($allengs);
    echo"</pre>";
    */

    foreach ($allengs['results'] as $e) {
        if (strpos($e['metadata']['subject'], 'UNCLASSIFIED') !== false) {
            echo "Engagement ID: ".$e['engagement']['id']."</br></br>";

            echo $e['metadata']['subject'];

            echo '</br></br>';

            echo $e['metadata']['html'];

            echo '</br></br></br></br></br></br>';


            $emailhtml = $e['metadata']['html'];


            $parsedData = parseHTML($emailhtml);


            echo"<pre>";
            print_r($parsedData);
            echo"</pre>";



            //Continue if veteran number doesn't exist

            if (!isset($parsedData['Veteran Number'])) {
                continue;
            }



            /*Trim all whitespace from Customer Number*/

            $vn_fix1 = str_replace(' ', '', $parsedData['Veteran Number']);

            $veteran_number = str_replace('-', '', $vn_fix1);




            //If veteran exists*/

            $f_veteran = findVeteran($apikey, $veteran_number);


            echo"<pre>";
            print_r($f_veteran);
            echo"</pre>";


            //If contact exists

            if (isset($f_veteran['results'][0]['id'])) {
                $vet_id = $f_contact['results'][0]['id'];


                $eng_id = $e['engagement']['id'];


            //NEED TO ASSOCIATE ENGAGEMENT


       // $associate_engagement = assoc_engage($apikey, $eng_id, $vet_id);
            } else {
                $new_vet = create_vet($apikey, $parsedData, $veteran_number);


                echo"<pre>";
                print_r($new_vet);
                echo"</pre>";


                /*

                        $con_id = $new_vet['id'];


                        $eng_id = $e['engagement']['id'];


                        $associate_engagement = assoc_engage($apikey, $eng_id, $con_id);

                        */
            };
        }//If contains string
    }//foreach



/*

foreach ($allengs['results'] as $e) {

if($e['metadata']['to'][0]['email'] == "warmerkiwihomes@eeca.govt.nz"){

echo "Engagement ID: ".$e['engagement']['id']."</br></br>";

echo $e['metadata']['subject'];

echo '</br></br>';

echo $e['metadata']['html'];

echo '</br></br></br></br></br></br>';




$emailhtml = $e['metadata']['html'];


$parsedData = parseHTML($emailhtml);


echo"<pre>";
    print_r($parsedData);
    echo"</pre>";






if(isset($parsedData['Email:'])){

    $contact_email = $parsedData['Email:'];

    $f_contact = findContact($apikey, $contact_email);


    //If contact exists

    if(isset($f_contact['results'][0]['id'])){

        $con_id = $f_contact['results'][0]['id'];


        $eng_id = $e['engagement']['id'];


        $associate_engagement = assoc_engage($apikey, $eng_id, $con_id);


    }else{

        $new_con = create_con($apikey, $parsedData);


        $con_id = $new_con['id'];


        $eng_id = $e['engagement']['id'];


        $associate_engagement = assoc_engage($apikey, $eng_id, $con_id);


    };


    //If contact doesn't exist


    echo"<pre>";
    print_r($f_contact);
    echo"</pre>";


};




}//if from warmerkiwihomes@eeca.govt.nz





}//allengs loop


*/
};//init

init($apikey);




/*NOTES WITH MATTHEW*/

/*
Need to extrapolate different emails in key value pairs (veteran.email)

associate with case worker contact

Next of kin needs to be out of here


create associate with veteran CONTACT


*/









function create_vet($apikey, $parsedData, $veteran_number)
{


/*


$name_segments = explode(" ", $parsedData['Full Name'], 2);

$firstname = $name_segments[0];

$lastname = "";

if(isset($name_segments[1])){

$lastname = $name_segments[1];

}


*/



    $package = '{
  "properties": {
    "veteran_full_name": "'.$parsedData['Full Name'].'",
    "phone": "'.$parsedData['Phone'].'",
    "veteran_s_email": "'.$parsedData['Email'].'",
    "swn_number": "'.$veteran_number.'"
  }
}';



    $packageArray = json_decode($package, true);


    $response = Http::post('https://api.hubapi.com/crm/v3/objects/2-1709517?hapikey='.$apikey, $packageArray);


    $res = $response->json();

    return $res;
}//create_con()


function assoc_engage($apikey, $eng_id, $vet_id)
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

    return $res;
}//assoc_engage



function findVeteran($apikey, $veteran_number)
{
    $package = '{
    "filterGroups":[
      {
        "filters":[
          {
            "propertyName": "swn_number",
            "operator": "EQ",
            "value": "'.$veteran_number.'"
          }
        ]
      }
    ]
  }';



    $packageArray = json_decode($package, true);


    $response = Http::post('https://api.hubapi.com/crm/v3/objects/2-1709517/search?hapikey='.$apikey, $packageArray);


    $res = $response->json();

    return $res;
};//findContact



function parseHTML($emailhtml)
{
    $html = str_get_html($emailhtml);


    $parseData = array();


    foreach ($html->find('tr') as $elem) {
        if (null !== $elem->children(0)) {
            $key = trim($elem->children(0)->plaintext);

            //Get value condition

            if (null !== $elem->children(1)) {
                $value = $elem->children(1)->plaintext;

                $parseData[$key] = $value;
            }//value if
        };

        //echo $elem->children(0)->plaintext . '<br>';
    }


    return $parseData;
}//parseHTML()




function getreceng($apikey, $limit)
{
    $date = time() - 3600;   //Get the timestamp from an hour ago


    //$date = time() - 43200;   //Get the timestamp from 12 hours ago


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

    return $result;
}
