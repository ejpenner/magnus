<?php
namespace Magnus\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Magnus\Helpers\Helpers;
use Magnus\Http\Requests;
use Carbon\Carbon;

use Magnus\Opus;
use Magnus\Gallery;
use Magnus\Tag;
use Magnus\Comment;
use Magnus\User;
use Magnus\Notification;

class OpusController extends Controller
{
    /**
     * OpusController constructor.
     */
    public function __construct()
    {
        $this->middleware('opus', ['except'  => [
            'show', 'index', 'galleryShow',
            'create', 'newSubmission', 'submit',
            'download', 'store'
        ]]);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return abort(404);
    }

    /**
     * Send the download file to the requesting browser
     * @param $opus_id
     */
    public function download(Opus $opus)
    {
        //$opus = Opus::findOrFail($opus_id);
        return response()->download($opus->image_path, $opus->user->username.'-'.$opus->title.'-'.date('mdY').'.jpg', ['Content-Type: application/jpeg']);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('opus.create');
    }

    /**
     * Multipurpose opus create page, allows selection of 0 to many
     * galleries to add the new Opus to
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newSubmission()
    {
        $user = Auth::user();
        $galleries = Gallery::where('user_id', $user->id)->get();
        return view('opus.submit', compact('galleries'));

    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\OpusCreateRequest $request)
    {
        $user = Auth::user();
        $opus = Opus::make($request, $user);
        Notification::notifyWatchersNewOpus($opus, $user);
        Tag::make($opus, $request->input('tags'));
        Gallery::place($request, $opus);

        return redirect()->route('opus.show', $opus->slug)->with('success', 'Your work been added!');
    }

    /**
     * Show an opus
     * @param Request $request
     * @param Opus $opus
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Opus $opus)
    {
        $opus->pageview($request);
        $comments = $opus->comments()->orderBy('created_at', 'asc')->get();
        $metadata = $opus->metadata();
        $favoriteCount = $opus->favorite->users->count();
        $navigator = Helpers::navigator($opus->user->opera, $opus);

        return view('opus.show', compact('opus', 'comments', 'metadata', 'navigator', 'favoriteCount'));
    }

    /**
     *  Show an opus that is a part of a gallery with the gallery URI scheme
     * @param $gallery_id
     * @param $opus_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function galleryShow(Request $request, $gallery_id, Opus $opus)
    {
        $gallery = Gallery::findOrFail($gallery_id);
        $opus->pageview($request);
        $comments = $opus->comments()->orderBy('created_at', 'asc')->get();
        $metadata = $opus->metadata();
        $favoriteCount = $opus->favorite->users->count();
        $navigator = Helpers::galleryNavigator($gallery, $opus);

        return view('opus.show', compact('opus', 'gallery', 'comments', 'metadata', 'navigator', 'favoriteCount'));
    }
    
    /**
     * Show the form for editing the specified resource.
     * @param Opus $opus
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Opus $opus)
    {
        $galleries = $opus->user->galleries;
        $tagString = $opus->stringifyTags();
        return view('opus.edit', compact('opus', 'galleries', 'tagString'));
    }

    /**
     * Update the opus
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Opus $opus)
    {
        $updatedSlug = false;
        $newSlug = "";
        
        $opus->updateImage($opus->user, $request);
        if ($request->input('title') != $opus->title) {
            $newSlug = $opus->setSlug($opus->title);
            $updatedSlug = true;
        }
        $opus->update($request->except('image', 'published_at'));
        Tag::make($opus, $request->input('tags'));
        Gallery::place($request, $opus);

        if ($updatedSlug) {
            return redirect()->route('opus.show', [$newSlug])->with('success', 'Updated opus successfully!');
        } else {
            return redirect()->route('opus.show', [$opus->slug])->with('success', 'Updated opus successfully!');
        }

    }

    /**
     * Delete an opus and its files
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Opus $opus)
    {
        $isOwner = Auth::user()->isOwner($opus);
        $opus->deleteDirectory();
        $opus->delete();
        $redirect = app('url')->previous();

        if (strpos($redirect, 'opus') !== false and $isOwner) { // the deletion was from opus.show
            return redirect()->route('profile.opera', Auth::user()->slug)->with('success', 'The opus has been deleted!');
        } elseif (strpos($redirect, 'opus') !== false and !$isOwner) {
            return redirect()->route('home')->with('success', 'The opus has been deleted!');
        }
        return redirect()->to($redirect)->with('success', 'The opus has been deleted!');
    }
}
