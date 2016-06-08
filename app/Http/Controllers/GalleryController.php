<?php

namespace App\Http\Controllers;

use App\Feature;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Gallery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Permission;

class GalleryController extends Controller
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
        // index of galleries is user profile

        $galleries = Gallery::orderBy('updated_at', 'desc')->paginate('12');

        return view('gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\GalleryRequest $request)
    {
        $gallery = new Gallery(['name'=>$request->name,'description'=>$request->description]);
        Auth::user()->galleries()->save($gallery);

        return redirect()->route('profile.show', [Auth::user()->slug])->with('success', $gallery->name.' has been created!');
    }

    /**
     * Display the specified resource.
     *
     * Show the pieces in the gallery
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);

        $features = Feature::where('gallery_id', $gallery->id)->orderBy('created_at', 'desc')->paginate(12);
        
        return view('gallery.show', compact('gallery', 'features'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //return dd(Permission::findOrFail(1)->users);
        //return
          // dd(Auth::user()->permission['read_all']);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\GalleryRequest $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->update($request->all());

        return redirect()->route('gallery.index')->with('success', 'Gallery successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gallery successfully deleted!');
    }
}
