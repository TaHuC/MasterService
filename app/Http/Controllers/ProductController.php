<?php

namespace App\Http\Controllers;

use App\Product;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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

    public function getSerial($serial)
    {
        $get = Product::where('serial', 'LIKE', '%'.$serial.'%')->get();

        return response()->json($get);
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
        $this->validate($request, [
            'serial' => 'required|min:5|max:255|unique:products',
            'type' => 'required|integer',
            'brand' => 'required|integer',
            'model' => 'required|integer',
            'client' => 'required|integer',
            'now' => 'required|min:2',
            'problem' => 'required|min:2',
            'price' => 'integer',
        ]);


        $product = new Product();
        $product->clientId = $request->client;
        $product->typeId = $request->type;
        $product->brandId = $request->brand;
        $product->modelId = $request->model;
        $product->userId = Auth::user()->id;
        $product->serial = $request->serial;
        $product->save();

        $order = new Order();
        $order->productId = $product->id;
        $order->statusId = 1;
        $order->userId = Auth::user()->id;
        $order->now = $request->now;
        $order->problem = $request->problem;
        $order->password = $request->password;
        $order->description = $request->description;
        $order->price = $request->price;
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
        //
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
