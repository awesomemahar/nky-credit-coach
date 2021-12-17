<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DisputeLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DisputeEditorController extends Controller
{
    public function getDisputesEditor($id){
        $page = 'Disputes';

        $letters = DisputeLetter::where('dispute_uid',$id)->where('client_id',auth()->user()->id)->get();
        if(count($letters) > 0){
            return view('client.disputes.disputes_editor', compact('page','letters'));
        }else{
            return redirect()->route('client.disputes')->with('error', 'No dispute found.');
        }
    }

    public function editDisputeEditorLetterPost (Request  $request, $id){
        $resp = [];
        $resp['error'] = true;
        $resp['redirect'] = false;
        $letter = DisputeLetter::where('id', $id)->where('client_id', auth()->user()->id)->first();
        if(!is_null($letter)){

            $validator = Validator::make($request->all(), [
                'letter' => 'required'
            ]);

            if ($validator->fails()) {
                $resp['msg'] = 'Letter cannot be empty.';
                return response()->json($resp, 200);
            }
            $letter->letter = $request->letter;
            $letter->save();
            if($request->has('task') && $request->task == '1'){
                $resp['redirect'] = true;
            }
            $resp['error'] = false;
            $resp['msg'] = 'Letter saved successfully.';
        }else{
            $resp['msg'] = 'Something went wrong, Please try later.';
        }

        return response()->json($resp, 200);
    }
}
