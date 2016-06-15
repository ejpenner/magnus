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

class OpusController extends Controller
{

    public function __construct()
    {
        $this->middleware(
            'auth',
            [
                'only' => ['create','store','edit','update','destroy']
            ]
        );
        $this->middleware('gallery', ['except'=>['show','index']]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $opus = new Opus($request->all());
        $opus->setImage($request);
        $opus->setThumbnail($request);
        $opus->published_at = Carbon::now();
        $opus = Auth::user()->opera()->save($opus);

//        $gallery = Gallery::findOrFail($gallery_id);
//        $gallery->updated_at = Carbon::now();
//        $gallery->save();

        if($request->input('tags') !== null) {

            $tags = explode(' ', trim($request->input('tags')));
            // for each tag, check if it exists, if it doesn't create it
            $this->makeTags($tags);
            // get tag IDs
            $tagIds = $this->getTagIds($tags);
            //attach the tags to this piece
            $opus->tags()->attach($tagIds);
        }

        return redirect()->route('opus.show', $opus->id)->with('success', 'Piece has been added!');
    }
    
    public function galleryStore(Request $request, $gallery_id) {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($opus_id)
    {
        $opus = Opus::findOrFail($opus_id);
        $query = Gallery::query();
        $query->join('gallery_opus', 'galleries.id', '=', 'gallery_opus.gallery_id')
                ->where('gallery_opus.opus_id', $opus->id);
        $gallery = $query->first();
        $this->viewPiece($opus);
        $comments = Comment::where('opus_id', $opus->id)->orderBy('created_at', 'asc')->get();
        $metadata = $opus->metadata();
        // check to see if this opus is part of a gallery
        if(isset($gallery)) {
            $galleryNav = $this->makeNavigator($gallery, $opus);
        }
        return view('opus.show', compact('opus','gallery','comments','metadata','galleryNav'));
    }

    public function galleryShow($gallery_id, $opus_id) {
        $opus = Opus::findOrFail($opus_id);
        $query = Gallery::query();
        $query->join('gallery_opus', 'galleries.id', '=', 'gallery_opus.gallery_id')
            ->where('gallery_opus.opus_id', $opus->id);
        $gallery = $query->first();
        $this->viewPiece($opus);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $opus = Opus::findOrFail($id);

        // if the user wants to change the image file

        if($request->file('image') !== null) {
            $imageStatus = $opus->updateImage($request);
        }

        // update everything except the image and published at
        $opus->update($request->except('image','published_at'));

        // check if tags have changed
        if($request->input('tags') === null) {
            $tags = [];
        } else {
            $tags = explode(' ', trim($request->input('tags')));
            $this->makeTags($tags);
            $tags = $this->getTagIds($tags);
        }

        $opus->tags()->sync($tags);

        return redirect()->route('opus.show', [$opus->id])->with('success', 'Updated piece successfully!');
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

    /**
     *  for a list of tags, if the tag doesn't already exist in tags table
     *  create a new entry for it
     *
     * @param $tags
     */
    private function makeTags($tags) {
        foreach($tags as $tag) {
            if(Tag::where('name', $tag)->first() === null) {
                Tag::create(['name'=>$tag]);
            }
        }
    }

    /**
     *  For a list of tags, return the IDs of those tags
     *
     * @param $tags
     * @return array
     */
    private function getTagIds($tags) {
        $tagIds = [];
        foreach($tags as $tag) {
            $id = Tag::where('name', $tag)->value('id');
            array_push($tagIds, $id);
        }
        return $tagIds;
    }

    private function makeNavigator($gallery, $opus) {
        $pieceNav = [];
        $galleryNav = [
            'next' => null,
            'current' => $opus->id,
            'previous' => null
        ];
        $foundMax = false;
        $foundMin = false;

        foreach ($gallery->opera as $currentOpus) {
            array_push($pieceNav, $currentOpus->id);
        }

        if(count($pieceNav) < 2) {
            $galleryNav['next'] = $pieceNav[0];
            $galleryNav['previous'] = $pieceNav[0];

            return $galleryNav;
        }

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

    private function viewPiece($piece) {
        if(Auth::check() and !Auth::user()->isOwner($piece)) {
            $piece->views = $piece->views + 1;
            $piece->save();
        }
    }
}
