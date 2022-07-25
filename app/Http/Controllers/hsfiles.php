<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class hsfiles extends Controller
{
    public function genfile(Request $request)
    {
        $jsonbody = json_decode($request->getContent(), true);


        $fileContents = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $jsonbody['b64']));



        $response = Http::attach(
            'file',
            $fileContents,
            "howdy.jpg"
        )->post('https://api.hubapi.com/files/v3/files?hapikey=' . config('hubspot.api_key'), [
    'fileName' => 'mob-copy.jpg',
    'charsetHunch' => 'UTF-8',
    'options' => '{
    	"access":  "PUBLIC_NOT_INDEXABLE",
    	"ttl": "P2W",
    	"overwrite": false,
    	"duplicateValidationStrategy": "NONE",
    	"duplicateValidationScope": "EXACT_FOLDER"
	}',
    'folderPath' => '/App Files/images/'
]);



        $res = $response->json();

        echo json_encode($res);







        /*

        $response = Http::attach(
            'file', file_get_contents(base_path("public/images/logo-quote.jpg")), "howdy.jpg"
        )->post('https://api.hubapi.com/files/v3/files?hapikey=' . config('hubspot.api_key'),[
            'fileName' => 'mob-copy.jpg',
            'charsetHunch' => 'UTF-8',
            'options' => '{
                "access":  "PUBLIC_NOT_INDEXABLE",
                "ttl": "P2W",
                "overwrite": false,
                "duplicateValidationStrategy": "NONE",
                "duplicateValidationScope": "EXACT_FOLDER"
            }',
            'folderPath' => '/testmigrate222'
        ]);

        */
    }//genfile
}//hsfiles
