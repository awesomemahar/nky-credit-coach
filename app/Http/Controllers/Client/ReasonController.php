<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $page = 'Disputes';
        $ids = array();
        array_push($ids,1);
        array_push($ids, auth()->user()->id);
        $reasons = Reason::with('user')->whereIn('user_id',$ids)->orderBy('title','asc')->get();
        return view('client.disputes.reason.index',compact('reasons','page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:reasons,title,'.\auth()->user()->id . ',user_id',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $reason = new Reason();
        $reason->user_id = auth()->user()->id;
        $reason->title = ucfirst($request->title);
        $reason->content = $request->get('content');
        $reason->save();

        return back()->with('success', 'Reason added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reason = Reason::where('user_id', auth()->user()->id)->where('id', $id)->first();
        if(!is_null($reason)){
            if(!$request->has('active_switch')){
                $reason->status = 0;
            }else{
                $reason->status = 1;
            }
            $reason->content = $request->get('content');
            $reason->save();
            return back()->with('success', 'Reason updated successfully.');
        }else{
            return back()->with('error', 'Invalid reason change request.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
