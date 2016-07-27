<?php

namespace Magnus\Http\Controllers;

use Magnus\User;
use Magnus\Journal;
use Illuminate\Http\Request;
use Magnus\Http\Requests\JournalRequest;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        //$journals = $user->journals->with('commentCount');
        $journals = Journal::where('user_id', $user->id)->with('commentCount')->get();

        //dd($journals->first()->commentCount);
        $profile = $user->profile;

        return view('journal.index', compact('user', 'journals', 'profile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $journals = $request->user()->journals;

        return view('journal.create', compact('journals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JournalRequest $request)
    {
        $journal = new Journal($request->all());
        $journal->parsedBody = $request->input('rawBody');
        $journal->slug = $request->input('title');
        $journal = $request->user()->journals()->save($journal);

        return redirect()->route('journal.show', [$request->user()->slug, $journal->slug])->with('success', 'Your journal entry has been posted!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Journal $journal)
    {
        $profile = $user->profile;
        return view('journal.show', compact('user', 'journal', 'profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
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
    public function update(JournalRequest $request, Journal $journal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        //
    }
}
