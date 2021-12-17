<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'My Clients';
        $clients = User::where('type', 3)->get();
        return view('admin.client.index', compact('page', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $page = 'My Clients';
//        return view('admin.client.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $request->validate(
//            [
//                'first_name' => ['required', 'string', 'max:255'],
//                'last_name' => ['required', 'string', 'max:255'],
//                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//                'password' => ['required', 'string', 'min:8', 'confirmed'],
//            ]
//        );
//        try {
//            DB::beginTransaction();
//            $data = $request->all();
//            $data['no_email_check'] = ($request->no_email_check) ? 1 : 0;
//            $data['password'] = Hash::make($request->password);
//            $data['type'] = 3;
//            User::create($data);
//            DB::commit();
//            return back()->with('success', 'Client Added Successfully');
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return back()->with('error', 'Something Went Wrong');
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = User::find($id);
        $page = 'My Clients';
        return view('admin.client.show', compact('page', 'client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        $client = User::find($id);
//        $page = 'My Clients';
//        return view('admin.client.edit', compact('page', 'client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
//        $id = $request->id;
//        $request->validate(
//            [
//                'first_name' => ['required', 'string', 'max:255'],
//                'last_name' => ['required', 'string', 'max:255'],
//                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id . ',id'],
//                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
//            ]
//        );
//        try {
//            DB::beginTransaction();
//            $data = $request->all();
//            $client = User::find($id);
//            $data['no_email_check'] = ($request->no_email_check) ? 1 : 0;
//            $data['password'] = ($request->password) ? Hash::make($request->password) : $client->password;
//            $client->update($data);
//            DB::commit();
//            return back()->with('success', 'Client Updated Successfully');
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return back()->with('error', 'Something Went Wrong');
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return back()->with('error', 'Something Went Wrong');
//        try {
//            DB::beginTransaction();
//            $client = User::find($id);
//            $client->delete();
//            DB::commit();
//            return back()->with('success', 'Client Deleted Successfully');
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return back()->with('error', 'Something Went Wrong');
//        }
    }
}
