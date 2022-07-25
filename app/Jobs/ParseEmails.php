<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

// include('../../includes/simple_html_dom.php');

class ParseEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $this->info(app_path());
        $this->info("Parsing emails");
        $apikey = config('hubspot.api_key');
        $limit = 50;
        $allengs = $this->getreceng($apikey, $limit);

        $this->info(count($allengs) . " emails\n");

        foreach ($allengs['results'] as $e) {
            if (!isset($e['metadata']['from']['email'])) {
                continue;
            }
            // Skip emails that have already been associated to a contact besides the sender
            if (count($e['associations']['contactIds']) > 1) {
                continue;
            }

            if ($e['metadata']['from']['email'] == "warmerkiwihomes@eeca.govt.nz") {
                $this->info("Engagement ID: ".$e['engagement']['id']."</br></br>");
                $this->info($e['metadata']['subject']);
                $this->info($e['metadata']['html']);

                $emailhtml = $e['metadata']['html'];
                $parsedData = parseHTML($emailhtml);

                $this->info("parsedData:\n");
                print_r($parsedData);

                if (isset($parsedData['Email:'])) {
                    $contact_email = $parsedData['Email:'];
                    if (!empty($contact_email)) {
                        $f_contact = findContact($apikey, $contact_email);
                    } else {
                        $f_contact = null;
                    }

                    $this->info("Found contact:\n");
                    print_r($f_contact);
                }
            }//if from warmerkiwihomes@eeca.govt.nz
        }//allengs loop
    }

    protected function findContact($apikey, $contact_email)
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
        "lead_status"
        ]
      }';
        $packageArray = json_decode($package, true);
        $response = Http::post('https://api.hubapi.com/crm/v3/objects/contacts/search?hapikey='.$apikey, $packageArray);
        $res = $response->json();

        return $res;
    }//findContact

    protected function parseHTML($emailhtml)
    {
        return [];
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
            };

            // Log::debug($elem->children(0)->plaintext . '<br>');
        }

        return $parseData;
    }//parseHTML()

    protected function getreceng($apikey, $limit)
    {
        $date = time() - 3600 * 24 * 30; //Get the timestamp from an hour ago

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

}
