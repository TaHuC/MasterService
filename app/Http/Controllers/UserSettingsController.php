<?php

namespace App\Http\Controllers;

use App\UserSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{
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
        $userSettings = new UserSettings();
        $userSettings->user_color = $request->color;
        $userSettings->user_id = Auth::user()->id;
        $userSettings->save();

        return [$userSettings, Auth::user()];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return $id;
        $userSettings = UserSettings::where('user_id', $id)->get();

        return $userSettings[0];

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserSettings  $userSetings
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSetings $userSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $userSettings = UserSettings::find($id);
        $userSettings->user_color = $request->user_color;
        $userSettings->save();

        return $userSettings->user_color;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserSettings  $userSetings
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSetings $userSettings)
    {
        //
    }
}
