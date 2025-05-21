<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessContactUsJob;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    
    public function sendmail(Request $request){

        $request->validate([
            "name"=> "required|min:3, max:256",
            "email"=> "required|email" ,
            "subject"=>"required",
            "message"=>"required"
        ]);

        $data = $request->only(["name", "email", "subject", "message"]);

        ProcessContactUsJob::dispatch($data);

        return response()->json($request,200);

    }


}
