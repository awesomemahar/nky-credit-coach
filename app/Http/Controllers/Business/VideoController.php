<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Training Videos';
        $videos = Video::whereStatus(1)->orderBy('id', 'desc')->get();
        return view('business.video.index', compact('page', 'videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort(404);
//        $page = 'Training Videos';
//        return view('business.video.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['title' => ['required', 'string', 'max:255'], 'category' => ['required', 'string', 'max:255'], 'path' => ['required'], 'status' => ['required'],]);
        try {
            DB::beginTransaction();
            $data = $request->all();
            //            $path = '';
            //            if ($request->hasFile('video')) {
            //                $storagePath = Storage::disk('public')->put('/videos/', $request->file('video'));
            //                $path = basename($storagePath);
            //                $path = '/videos/' . $path;
            //            }
            //            $data['path'] = $path;
            $data['owner_id'] = auth()->user()->id;
            Video::create($data);
            DB::commit();
            return back()->with('success', 'Video Added Successfully');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = Video::whereStatus(1)->where('id',$id)->first();
        if(!is_null($video)){
            $page = 'Training Videos';
            return view('business.video.show', compact('page', 'video'));
        }else{
            return back()->with('error', 'Something Went Wrong');
        }
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
        //
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
