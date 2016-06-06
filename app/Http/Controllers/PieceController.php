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

        return redirect()->route('gallery.show', $gallery->id)->with('success', 'Piece has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $gallery_id, $piece_id)
    {
        $gallery = Gallery::findOrFail($gallery_id);
        $gallery->updated_at = Carbon::now();
        $gallery->save();

        $piece = Piece::findOrFail($piece_id);
        $piece->update($request->except('image','published_at'));

        $imageStatus = $piece->updateImage($request);

        return redirect()->route('gallery.piece.show', [$gallery->id, $piece->id])->with('message', 'Updated piece successfully!');
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
