<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Key;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class LettersController extends Controller {
    public function index() {
        $page = 'Letters Library';
        $letters = Letter::with('user')->where('user_id', Auth::user()->id)->orWhereHas('user', function ($q) {
            $q->where('type', 1);
        })->get();
        return view('client.letters.index', compact('page', 'letters'));
    }

    public function create() {
        $page = 'Letters Library';
        $page = 'Letters Library';
        $keys = Key::orderby('type','asc')->whereStatus('created')->get();
        return view('client.letters.create', compact('page','keys'));
    }

    public function store(Request $request) {
        $request->validate(['title' => ['required', 'string', 'max:255'], 'letter_type' => ['required'], 'status' => ['required'],'letter' => ['required','min:10']]);
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            $data['letter_type'] = ucfirst($request->letter_type);
            if($request->has('bulk_letters')){
                $data['bulk_letters'] = 1;
            }
            Letter::create($data);
            DB::commit();
            return back()->with('success', 'Letter Added Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }

    public function show($id) {
        $letter = Letter::find($id);
        $page = 'Letters Library';
        return view('client.letters.show', compact('page', 'letter'));
    }

    public function edit($id) {
        $letter = Letter::find($id);
        $keys = Key::orderby('type','asc')->whereStatus('created')->get();
        $page = 'Letters Library';
        return view('client.letters.edit', compact('page','keys', 'letter'));
    }

    public function update(Request $request) {
        $request->validate(['title' => ['required', 'string', 'max:255'], 'status' => ['required'],'letter' => ['required','min:10']]);
        try {
            DB::beginTransaction();
            $letter = Letter::where('id',$request->id)->where('user_id',\auth()->user()->id)->whereLetterStatus('Created')->first();
            if(!is_null($letter)){
                $data = $request->except('letter_type');
                $data['user_id'] = Auth::user()->id;
                if($request->has('bulk_letters')){
                    $data['bulk_letters'] = 1;
                }else{
                    $data['bulk_letters'] = 0;
                }
                $letter->update($data);
                DB::commit();
                return back()->with('success', 'Letter Updated Successfully');
            }else{
                return back()->with('error', 'Something Went Wrong');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }

    public function destroy($id) {
        try {
            DB::beginTransaction();
            $letter = Letter::find($id);
            $letter->delete();
            DB::commit();
            return back()->with('success', 'Letter Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }
}
