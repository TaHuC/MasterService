<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
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
        $this->validate($request, [
            'note' => 'required'
        ]);

        $note = new Note();

        if($request->orderId){
            $note->note = $request->note;
            $note->orderId = $request->orderId;
            $note->userId = Auth::user()->id;
            @$note->save();

            //return redirect()->route('product.show', ['id' => $request->productId])->with('messages', 'Add successed!');
            return $note;
        } elseif ($request->clientId){
            $note->note = $request->note;
            $note->userId = Auth::user()->id;
            $note->clientId = $request->clientId;
            $note->save();

            return redirect()->route('client.show', ['id' => $request->clientId])->with('messages', 'Add successed!');
        }
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $param
     * @return \Illuminate\Http\Response
     */
    public function showNotes($id, $param)
    {
        switch ($param){
            case 'order':
                return Note::with('user')
                    ->where('orderId', '=', $id)
                    ->get();
                break;
            case 'client':
                return Note::where('clientId', '=', $id)->get();
                break;
            case 'user':
                return Note::where('userId', '=', $id)->get();
                break;
        }
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
