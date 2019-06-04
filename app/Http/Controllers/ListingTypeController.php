<?php

namespace App\Http\Controllers;

use App\ListingType;
use Illuminate\Http\Request;

class ListingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ListingType::all();
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
     * @param  \App\ListingType  $listingType
     * @return \Illuminate\Http\Response
     */
    public function show(ListingType $listingType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ListingType  $listingType
     * @return \Illuminate\Http\Response
     */
    public function edit(ListingType $listingType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ListingType  $listingType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListingType $listingType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ListingType  $listingType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListingType $listingType)
    {
        //
    }
}
