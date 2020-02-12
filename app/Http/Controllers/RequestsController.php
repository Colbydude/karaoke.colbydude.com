<?php

namespace App\Http\Controllers;

use App\SongRequest;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(SongRequest::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('requests');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'youtube_link' => 'required|string|max:255',
            'video_name' => 'required|string|max:255',
        ]);

        $song_request = SongRequest::create($request->only(['name', 'video_name', 'youtube_link']));

        return response()->json($song_request, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SongRequest  $song_request
     * @return \Illuminate\Http\Response
     */
    public function show(SongRequest $song_request)
    {
        return response()->json($song_request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SongRequest  $song_request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SongRequest $song_request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'youtube_link' => 'required|string|max:255',
            'video_name' => 'required|string|max:255',
        ]);

        $song_request->name = $request->input('name');
        $song_request->video_name = $request->input('video_name');
        $song_request->youtube_link = $request->input('youtube_link');
        $song_request->save();

        return response()->json($song_request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SongRequest  $song_request
     * @return \Illuminate\Http\Response
     */
    public function destroy(SongRequest $song_request)
    {
        $song_request->delete();

        return response()->json([]);
    }
}
