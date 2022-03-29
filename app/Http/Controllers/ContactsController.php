<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use App\Http\Requests\StoreContactsRequest;
use App\Http\Requests\UpdateContactsRequest;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return contacts::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactsRequest $request)
    {
//            return $request->name;
        return Contacts::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'title'=>$request->title,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Contacts::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactsRequest  $request
     * @param  \App\Models\Contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactsRequest $request, $id)
    {
        $contacts = Contacts::find($id);
//        $contacts->update([
//            'name'=>$request->name,
//            'email'=>$request->email,
//            'phone'=>$request->phone,
//            'title'=>$request->title,
//
        $contacts->update($request->all());
        return $contacts;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Contacts::destroy($id);
    }

    /**
     * Search the specified resource from storage.
     *
     * @param  \App\Models\Contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Contacts::where('name','like','%'.$name.'%')->get();
    }
}
