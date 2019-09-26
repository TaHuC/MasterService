<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Instantly;
use App\User;


class InstantlyController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $instantaneous = Instantly::with('user', 'order')->where('answer', null)->get();
        return $instantaneous;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function instantlyOut()
    {
        //
        $instantaneous = Instantly::where([
            ['user_id', '=', Auth::user()->id],
            ['active', '=', 1]
        ])
        ->with('answerUser', 'order')
        ->get();
        return $instantaneous;
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
        $instantly = new Instantly();
        $instantly->order_id = $request->order_id;
        $instantly->quest = $request->quest;
        $instantly->user_id = Auth::user()->id;
        $instantly->save();

        return $instantly;
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
        $instantly = Instantly::where('order_id', $id)->orderBy('id', 'desc')->with('user', 'order', 'answerUser')->get();
        return $instantly;
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
        //return print($request->active);
        $instantly = Instantly::find($id);
        if(!$request->answer) {
            if ($instantly->user_id == Auth::user()->id) {
                $instantly->active = 0;
                $instantly->save();
            }
        } else {
            $instantly->answer = $request->answer;
            $instantly->answer_user_id = Auth::user()->id;
            $instantly->answerTime = date('Y-m-d H:i:s');
            $instantly->active = 1;
            $instantly->save();
        }

        return $instantly;
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
