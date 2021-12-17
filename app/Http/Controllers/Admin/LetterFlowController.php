<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\LetterFlow;
use App\Models\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LetterFlowController extends Controller
{
    //
    public function flows(){
        $page = 'Letters Flow';

        $flows = LetterFlow::where('user_id', auth()->user()->id)->with('reason','bureauLetter','furnisherLetter')->get();
        return view('admin.letters.flow.flows',compact('page','flows'));
    }

    public function flowCreate(){
        $user = auth()->user();
        $page = 'Letters Flow';
        $reasons= Reason::where('user_id',$user->id)->where('status',1)->pluck('title', 'id');
        $bureau_letters = Letter::where('user_id',$user->id)->where('letter_type','Bureau')->where('status',1)->where('letter_status','Created')->pluck('title','id');
        $furnisher_letters = Letter::where('user_id',$user->id)->where('letter_type','Furnisher')->where('status',1)->where('letter_status','Created')->pluck('title','id');
        $agency_letters = Letter::where('user_id',$user->id)->where('letter_type','Collection Agency')->where('status',1)->where('letter_status','Created')->pluck('title','id');

        if(count($reasons) < 1){
            return redirect()->route('admin.reason.index')->with('error', 'Need to have at least one active reason to create dispute.');
        }
        return view('admin.letters.flow.create',compact('page','reasons','bureau_letters','furnisher_letters','agency_letters'));
    }

    public function flowCreatePost(Request  $request){
        $validator = Validator::make($request->all(), [
            'flow_name' => 'required',
            'dispute_reason'=>'required',
            'bureau_flow' => 'required_without_all:furnisher_flow,collection_agency_flow',
            'furnisher_flow' => 'required_without_all:bureau_flow,collection_agency_flow',
            'collection_agency_flow' => 'required_without_all:furnisher_flow,bureau_flow',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = auth()->user();
        try{
            $flow = LetterFlow::where('user_id', $user->id)->where('reason_id', $request->dispute_reason)->first();

            if(is_null($flow)){
                $flow  = new LetterFlow();
                $flow->user_id = $user->id;
                $flow->reason_id = $request->dispute_reason;
                $flow->by_admin = 1;
            }

            $flow->name = $request->flow_name;
            $flow->bureau_letter_id = $request->bureau_flow;
            $flow->furnisher_letter_id = $request->furnisher_flow;
            $flow->collection_agency_letter_id = $request->collection_agency_flow;
            $flow->save();

            return redirect()->route('admin.letter.flows')->with('success', 'Flow created successfully.');

        }catch (\Exception $exception){
            return back()->with('error', 'Something Went Wrong');
        }


    }
}
