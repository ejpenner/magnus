<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

use App\Opus;
use App\Gallery;
use App\Tag;
use App\Comment;
use App\User;
use App\Notification;

class OpusController extends Controller
{
    /**
     * OpusController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth',    ['except'  => ['show','index','galleryShow']]);
        $this->middleware('gallery', ['except'  => ['show','index','galleryShow']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($gallery_id)
    {
        $gallery = Gallery::findOrFail($gallery_id);

        return view('gallery.show', compact('gallery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('opus.create');
    }

    public function newSubmission(){
        return dd(Auth::user()->watchedUsers);

    }
    
    public function submit(Requests\OpusCreateRequest $request) {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\OpusCreateRequest $request)
    {
        //dd($request->all());
//        $opus = new Opus($request->all());
//        $opus->published_at = Carbon::now();
//        $opus = Auth::user()->opera()->save($opus);
//        $user = User::where('id', $opus->user_id)->first();
//        $opus->setImage($user, $request);
//        $opus->setThumbnail($user, $request);
        $user = Auth::user();
        $opus = Opus::make($request, $user);
        Notification::notifyWatchersNewOpus($opus, $user);
        Tag::makeTags($opus, $request->input('tags'));
     

        return redirect()->route('opus.show', $opus->id)->with('success', 'Your work been added!');
    }

    /**
     * Controller method for showing /gallery/{gallery}/{opus} routes
     *
     * @param Requests\OpusCreateRequest $request
     * @param $gallery_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function galleryStore(Requests\OpusCreateRequest $request, $gallery_id) {
        $opus = new Opus($request->all());
        $opus->published_at = Carbon::now();
        $opus = Auth::user()->opera()->save($opus);
        $user = User::where('id', $opus->user_id)->first();
        $opus->setImage($user, $request);
        $opus->setThumbnail($user, $request);
        Notification::notifyWatchersNewOpus($user, $opus);

        $gallery = Gallery::findOrFail($gallery_id);
        $gallery->addOpus($opus);
        
        if($request->input('tags') !== null) {
            Tag::makeTags($opus, $request->input('tags'));
        }

        return redirect()->route('opus.show', $opus->id)->with('success', 'Your work been added!');
    }

    /**
     *  Show an opus
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $opus_id)
    {
        $opus = Opus::findOrFail($opus_id);
        $query = Gallery::query();
        $query->join('gallery_opus', 'galleries.id', '=', 'gallery_opus.gallery_id')
            ->where('gallery_opus.opus_id', $opus->id);
        $gallery = $query->first();
        $opus->pageview($request);
        $comments = Comment::where('opus_id', $opus->id)->orderBy('created_at', 'asc')->get();
        $metadata = $opus->metadata();
        if(isset($gallery)) {
            $galleryNav = $this->makeNavigator($gallery, $opus);
        }
        return view('opus.show', compact('opus','gallery','comments','metadata','galleryNav'));
    }

    /**
     *  Show an opus that is a part of a gallery
     *
     * @param $gallery_id
     * @param $opus_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function galleryShow(Request $request, $gallery_id, $opus_id) {
        $opus = Opus::findOrFail($opus_id);
        $query = Gallery::query();
        $query->join('gallery_opus', 'galleries.id', '=', 'gallery_opus.gallery_id')
            ->where('gallery_opus.opus_id', $opus->id);
        $gallery = $query->first();
        $opus->pageview($request);
        $comments = Comment::where('opus_id', $opus->id)->orderBy('created_at', 'asc')->get();
        $metadata = $opus->metadata();
        $galleryNav = $this->makeNavigator($gallery, $opus);

        return view('opus.galleryShow', compact('opus','gallery','comments','metadata','galleryNav'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $opus = Opus::findOrFail($id);
        return view('opus.edit', compact('opus'));
    }

    /**
     * Update the opus
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $opus = Opus::findOrFail($id);
        $user = User::findOrFail($opus->user_id);
        // if the user wants to change the image file

        if($request->file('image') !== null) {
            $imageStatus = $opus->updateImage($user, $request);
        }

        // update everything except the image and published at
        $opus->update($request->except('image','published_at'));

        // check if tags have changed
        if($request->input('tags') !== null) {
            Tag::makeTags($opus, $request->input('tags'));
        }

        return redirect()->route('opus.show', [$opus->id])->with('success', 'Updated opus successfully!');
    }

    /**
     *  Update an opus that is a part of a gallery
     *
     * @param Request $request
     * @param $gallery_id
     * @param $piece_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function galleryUpdate(Requests\OpusEditRequest $request, $gallery_id, $opus_id)
    {
        $gallery = Gallery::findOrFail($gallery_id);
        $gallery->updated_at = Carbon::now();
        $gallery->save();

        $opus = Opus::findOrFail($opus_id);
        $user = User::findOrFail($opus->user_id);
        
        // if the user wants to change the image file

        if($request->file('image') !== null) {
            $imageStatus = $opus->updateImage($user, $request);
        }

        // update everything except the image and published at
        $opus->update($request->except('image','published_at'));

        // check if tags have changed
        if($request->input('tags') !== null) {
            Tag::makeTags($opus, $request->input('tags'));
        }

        return redirect()->route('opus.show', [$opus->id])->with('success', 'Updated opus successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $opus = Opus::findOrFail($id);
        $opus->deleteImages();
        $opus->delete();

        return redirect()->to(app('url')->previous())->with('success', 'The opus has been deleted!');
    }

    public function galleryDestroy($gallery_id, $opus_id) {
        $opus = Opus::findOrFail($opus_id);
        $gallery = Gallery::findOrFail($gallery_id);
        $gallery->opera()->detach($opus->id);
        $opus->delete();

        return redirect()->route('gallery.show', $gallery_id)->with('success', 'The piece has been deleted!');
    }

    /**
     *  Make a navigator array with the id of the next and previous
     *  opus in a gallery
     *
     * @param $gallery
     * @param $opus
     * @return array
     */
    private function makeNavigator(Gallery $gallery, Opus $opus) {
        $pieceNav = [];
        $galleryNav = [
            'next' => null,
            'current' => $opus->id,
            'previous' => null
        ];
        $foundMax = false;
        $foundMin = false;
        
        // get all the Opus ID in the gallery into an array
        foreach ($gallery->opera as $currentOpus) {
            array_push($pieceNav, $currentOpus->id);
        }

        // if there are only two opera in a gallery, the next and previous
        // links should be the opus it is not
        if(count($pieceNav) < 2) {
            $galleryNav['next'] = $pieceNav[0];
            $galleryNav['previous'] = $pieceNav[0];

            return $galleryNav;
        }
        
        // logic for a gallery with only three opera
        if(count($pieceNav) < 3) {
            if($pieceNav[0] == $opus->id) {
                $galleryNav['next'] = $pieceNav[1];
                $galleryNav['previous'] = $pieceNav[1];
            } else {
                $galleryNav['next'] = $pieceNav[0];
                $galleryNav['previous'] = $pieceNav[0];
            }
            $galleryNav['current'] = $opus->id;

            return $galleryNav;
        }

        // logic for a gallery with more than three opera in it
        foreach ($pieceNav as $i => $id) {
            if($opus->id == max($pieceNav) and $foundMax == false) {
                $foundMinMax = true;
                if($galleryNav['next'] == null) {
                    $galleryNav['next'] = min($pieceNav);
                }
            } elseif($id > $opus->id) {
                if ($galleryNav['next'] == null) {
                    $galleryNav['next'] = $pieceNav[$i];
                }
            }elseif($opus->id == min($pieceNav) and $foundMin == false) {
                $foundMaxMin = true;
                $galleryNav['previous'] = max($pieceNav);
            } elseif($id < $opus->id) {
                $galleryNav['previous'] = $pieceNav[$i];
            }
        }
        return $galleryNav;
    }
}
