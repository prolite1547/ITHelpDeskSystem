<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResolve;
use App\Resolve;
use App\Ticket;
use Illuminate\Http\Request;

class ResolveController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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
    public function create(StoreResolve $request,$id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->status = 13;

        $ticket->save();

        /*GET ID OF THE USER WHO RESOLVED THE TICKE*/
        $request->request->add(['resolved_by' =>$request->user()->id]);

        $resolve = $ticket->resolve()->create($request->except('_token'));


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
     * @param  \App\Resolve  $resolve
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resolve = Ticket::findOrFail($id)->resolve;

        return view('modal.resolve_lookup')->with(['resolve' => $resolve]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resolve  $resolve
     * @return \Illuminate\Http\Response
     */
    public function edit(Resolve $resolve)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resolve  $resolve
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resolve $resolve)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resolve  $resolve
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resolve $resolve)
    {
        //
    }
}
