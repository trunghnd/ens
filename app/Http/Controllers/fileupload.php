<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class fileupload extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileup(Request $request)
    {
        $jsonbody = json_decode($request->getContent(), true);


        //dd($data);  //to check all the datas dumped from the form

        echo"<pre>";
        print_r($jsonbody);
        echo"</pre>";
    }
}
