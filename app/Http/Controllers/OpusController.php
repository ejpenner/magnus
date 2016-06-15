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
        //
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
        $galleryNav = $this->makeNavigator($gallery, $opus);

        return view('opus.show', compact('opus','gallery','comments','metadata','galleryNav'));
    }

    public function galleryShow($gallery_id, $opus_id) {

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
