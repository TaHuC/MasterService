<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Client;
use App\ModelBrand;
use App\Order;
use App\Product;
use App\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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
        $order = new Order();
        $this->validate($request, [
            'productId' => 'required|integer',
            'now' => 'required|min:2',
            'problem' => 'required|min:3',
            'price' => 'integer',
            'deposit' => 'integer'
        ]);

        $order->productId = $request->productId;
        $order->statusId = 1;
        $order->userId = Auth::user()->id;
        $order->price = $request->price;
        $order->deposit = $request->deposit;
        $order->now = $request->now;
        $order->problem = $request->problem;
        $order->password = $request->password;
        $order->description = $request->description;
        $order->save();

        return $order->id;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('productId', '=', $id)
            ->orderBy('id', 'desc')
            ->get();
        return $order;
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
        $this->validate($request, [
            'statusId' => 'required|integer'
        ]);

        $active = 1;
        if($request->statusId === 4){
            $active = 0;
        }

        $order = Order::find($id);
        $order->statusId = $request->statusId;
        $order->active = $active;
        $order->save();
        
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
