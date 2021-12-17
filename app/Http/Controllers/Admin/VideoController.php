<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class VideoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $page = 'Training Videos';
        $videos = Video::all();
        return view('admin.video.index', compact('page', 'videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $page = 'Training Videos';
        return view('admin.video.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
//            'thumbnail' => ['required','image','mimes:jpg,png,jpeg,gif','max:2048'],
            'description' => ['required'],
            'category' => ['required', 'string', 'max:255'],
            'path' => ['required'],
            'status' => ['required'],
            ]);
        try {
            DB::beginTransaction();
            $data = $request->except('thumbnail');
            $data['owner_id'] = auth()->user()->id;
            $video = Video::create($data);

//            if($request->has('thumbnail')){
//                $image=$request->file('thumbnail');
//
//                $image_name='_DP_'.time();
//                $ext=strtolower($image->getClientOriginalExtension());
//                $image_full_name=$image_name.'.'.$ext;
//                $upload_path='assets/admin/img/thumbnails/';
//                $image_url=$upload_path.$image_full_name;
//                $success=$image->move($upload_path,$image_full_name);
//                if ($success) {
//
//                    $video->thumbnail = $image_url;
//                    $video->save();
//                }
//            }
            DB::commit();
            return back()->with('success', 'Video Added Successfully');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video) {
        $page = 'Training Videos';
        return view('admin.video.show', compact('page', 'video'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video) {
        $page = 'Training Videos';
        return view('admin.video.edit', compact('page', 'video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video) {
        $request->validate(['title' => ['required', 'string', 'max:255'], 'category' => ['required', 'string', 'max:255'], 'path' => ['required'], 'status' => ['required'],    'description' => ['required'],]);
        try {
            DB::beginTransaction();
            $data = $request->except('thumbnail');
            //            $path = $video->path;
            //            if ($request->hasFile('video')) {
            //                if (Storage::disk('public')->delete($video->path)) {
            //                    Storage::disk('public')->delete($video->path);
            //                }
            //                $storagePath = Storage::disk('public')->put('/videos/', $request->file('video'));
            //                $path = basename($storagePath);
            //                $path = '/videos/' . $path;
            //            }
            //            $data['path'] = $path;
            $video->update($data);
            if($request->has('thumbnail')){
                $image=$request->file('thumbnail');

                $image_name='_DP_'.time();
                $ext=strtolower($image->getClientOriginalExtension());
                $image_full_name=$image_name.'.'.$ext;
                $upload_path='assets/admin/img/thumbnails/';
                $image_url=$upload_path.$image_full_name;
                $success=$image->move($upload_path,$image_full_name);
                if ($success) {

                    $video->thumbnail = $image_url;
                    $video->save();
                }
            }
            DB::commit();
            return back()->with('success', 'Video Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            DB::beginTransaction();
            $video = Video::find($id);
            //            if (Storage::disk('public')->delete($video->path)) {
            //                Storage::disk('public')->delete($video->path);
            //            }
            $video->delete();
            DB::commit();
            return back()->with('success', 'Video Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something Went Wrong');
        }
    }
}
