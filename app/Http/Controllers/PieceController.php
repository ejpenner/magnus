<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

use App\Piece;
use App\Gallery;
use App\Feature;
use App\Tag;
use App\Comment;

class PieceController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($gallery)
    {

        $gallery = Gallery::findOrFail($gallery);

        if(Auth::user()->isOwner($gallery) or Auth::user()->hasRole('admin')) {
            return view('piece.create', compact('gallery'));
        } else {
            return redirect()->back()->withErrors('You cannot add to this gallery');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($gallery_id, Request $request)
    {

        $gallery = Gallery::findOrFail($gallery_id);
        $gallery->updated_at = Carbon::now();
        $gallery->save();

        $piece = new Piece($request->all());
        $piece->setImage($request);
        $piece->setThumbnail($request);
        $piece->published_at = Carbon::now();
        $piece = Auth::user()->pieces()->save($piece);

        $feature = new Feature(['piece_id'=>$piece->id, 'gallery_id'=>$gallery->id]);
        $feature->save();


        if($request->input('tags') !== null) {

            $tags = explode(' ', trim($request->input('tags')));
            // for each tag, check if it exists, if it doesn't create it
            $this->makeTags($tags);
            // get tag IDs
            $tagIds = $this->getTagIds($tags);
            //attach the tags to this piece
            $piece->tags()->attach($tagIds);
        }

        return redirect()->route('gallery.show', $gallery->id)->with('success', 'Piece has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($gallery_id, $piece_id)
    {

        $gallery = Gallery::findOrFail($gallery_id);
        $piece = Piece::findOrFail($piece_id);
        $comments = Comment::where('piece_id', $piece->id)->get();
        $metadata = $piece->metadata();
        $galleryNav = $this->makeNavigator($gallery, $piece);

        return view('piece.show', compact('piece','gallery','comments','metadata','galleryNav'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($gallery_id, $piece_id)
    {
        $gallery = Gallery::findOrFail($gallery_id);
        $piece = Piece::findOrFail($piece_id);

        return view('piece.edit', compact('piece','gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $gallery_id, $piece_id)
    {
        $gallery = Gallery::findOrFail($gallery_id);
        $gallery->updated_at = Carbon::now();
        $gallery->save();

        $piece = Piece::findOrFail($piece_id);

        // if the user wants to change the image file

        if($request->file('image') !== null) {
            $imageStatus = $piece->updateImage($request);
        }

        // update everything except the image and published at
        $piece->update($request->except('image','published_at'));

        // check if tags have changed
        if($request->input('tags') === null) {
            $tags = [];
        } else {
            $tags = explode(' ', trim($request->input('tags')));
            $this->makeTags($tags);
            $tags = $this->getTagIds($tags);
        }

        $piece->tags()->sync($tags);

        return redirect()->route('gallery.piece.show', [$gallery->id, $piece->id])->with('success', 'Updated piece successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($gallery_id, $piece_id)
    {
        $piece = Piece::findOrFail($piece_id);
        $piece->delete();

        return redirect()->route('gallery.show', $gallery_id)->with('success', 'The piece has been deleted!');
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

    private function makeNavigator($gallery, $piece) {
        $pieceNav = [];
        $galleryNav = [
            'next' => null,
            'current' => $piece->id,
            'previous' => null
        ];
        $foundMax = false;
        $foundMin = false;

        foreach ($gallery->featured as $feature) {
            array_push($pieceNav, $feature->id);
        }

        if(count($pieceNav) < 3) {
            $galleryNav['next'] = max($pieceNav);
            $galleryNav['current'] = $piece->id;
            $galleryNav['previous'] = min($pieceNav);
        }

        foreach ($pieceNav as $i => $id) {
            if($piece->id == max($pieceNav) and $foundMax == false) {
                $foundMinMax = true;
                if($galleryNav['next'] == null) {
                    $galleryNav['next'] = min($pieceNav);
                }
            } elseif($id > $piece->id) {
                if ($galleryNav['next'] == null) {
                    $galleryNav['next'] = $pieceNav[$i];
                }
            }elseif($piece->id == min($pieceNav) and $foundMin == false) {
                $foundMaxMin = true;
                $galleryNav['previous'] = max($pieceNav);
            } elseif($id < $piece->id) {
                $galleryNav['previous'] = $pieceNav[$i];
            }
        }

        return $galleryNav;
    }
}
