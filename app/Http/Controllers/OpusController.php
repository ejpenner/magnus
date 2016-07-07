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
        $this->middleware('opus', ['except'  => ['show','index','galleryShow','create','newSubmission','submit']]);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index($gallery_id)
    {
        $gallery = Gallery::findOrFail($gallery_id);

        return view('gallery.show', compact('gallery'));
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
     * Multipurpose opus POST method that allows storage in galleries.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function submit(Requests\OpusCreateRequest $request)
    {
        $user = Auth::user();
        $opus = Opus::make($request, $user);
        Notification::notifyWatchersNewOpus($opus, $user);
        Tag::make($opus, $request->input('tags'));
        if ($request->has('gallery_ids[]')) {
            Gallery::place($request, $opus);
        }

        return redirect()->route('opus.show', $opus->slug)->with('success', 'Your work been added!');
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
        if ($request->has('gallery_ids[]')) {
            Gallery::place($request, $opus);
        }

        return redirect()->route('opus.show', $opus->slug)->with('success', 'Your work been added!');
    }

    /**
     *  Show an opus
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Opus $opus)
    {
        $opus->pageview($request);
        $comments = Comment::where('opus_id', $opus->id)->orderBy('created_at', 'asc')->get();
        $metadata = $opus->metadata();
        $galleryNav = Helpers::navigator($opus->user->opera, $opus);
        return view('opus.show', compact('opus', 'comments', 'metadata', 'galleryNav'));
    }

    /**
     *  Show an opus that is a part of a gallery
     * @param $gallery_id
     * @param $opus_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function galleryShow(Request $request, $gallery_id, Opus $opus)
    {
        $gallery = Gallery::findOrFail($gallery_id);
        $opus->pageview($request);
        $comments = Comment::where('opus_id', $opus->id)->orderBy('created_at', 'asc')->get();
        $metadata = $opus->metadata();
        $galleryNav = Helpers::galleryNavigator($gallery, $opus);

        return view('opus.galleryShow', compact('opus', 'gallery', 'comments', 'metadata', 'galleryNav'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Opus $opus)
    {
        //$opus = Opus::findOrFail($id);
        $galleries = Gallery::where('user_id', $opus->user_id)->get();
        $tagString = $opus->stringifyTags();
        return view('opus.edit', compact('opus','galleries','tagString'));
    }

    /**
     * Update the opus
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Opus $opus)
    {
        if ($request->file('image') !== null) {
            $imageStatus = $opus->updateImage($opus->user, $request);
        }

        // update everything except the image and published at
        $request->has('title') ? $opus->setSlug() : null;
        $opus->update($request->except('image', 'published_at'));

        // check if tags have changed
        if ($request->has('tags')) {
            Tag::make($opus, $request->input('tags'));
        }

        if ($request->has('gallery_ids[]')) {
            Gallery::place($request, $opus);
        }

        return redirect()->route('opus.show', [$opus->slug])->with('success', 'Updated opus successfully!');
    }

    /**
     *  Update an opus that is a part of a gallery
     *
     * @param Request $request
     * @param $gallery_id
     * @param $piece_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function galleryUpdate(Requests\OpusEditRequest $request, $gallery_id, Opus $opus)
    {
        if ($request->file('image') !== null) {
            $imageStatus = $opus->updateImage($opus->user, $request);
        }

        // update everything except the image and published at
        $request->has('title') ? $opus->setSlug() : null;
        $opus->update($request->except('image', 'published_at'));

        // check if tags have changed
        if ($request->has('tags')) {
            Tag::make($opus, $request->input('tags'));
        }

        return redirect()->route('opus.show', [$opus->slug])->with('success', 'Updated opus successfully!');
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

        if(strpos($redirect, 'opus') !== false and $isOwner) { // the deletion was from opus.show
            return redirect()->route('profile.opera', Auth::user()->slug)->with('success', 'The opus has been deleted!');
        } elseif (strpos($redirect, 'opus') !== false and !$isOwner) {
            return redirect()->route('home')->with('success', 'The opus has been deleted!');
        }
        return redirect()->to($redirect)->with('success', 'The opus has been deleted!');
    }

    /**
     * Delete an opus that is inside a gallery and its files
     *
     * @param $gallery_id
     * @param $opus_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function galleryDestroy($gallery_id, $opus_id)
    {
        $opus = Opus::findOrFail($opus_id);
        $gallery = Gallery::findOrFail($gallery_id);
        $gallery->opera()->detach($opus->id);
        $opus->delete();

        return redirect()->route('gallery.show', $gallery_id)->with('success', 'The piece has been deleted!');
    }
}
