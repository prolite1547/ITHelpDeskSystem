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
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        Ticket::findOrFail($id)->update(['status' => 3]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Resolve  $resolve
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
