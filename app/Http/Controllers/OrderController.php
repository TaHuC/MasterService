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
        $this->validate($request, [
            'productId' => 'required|integer',
            'now' => 'required|min:2',
            'problem' => 'required|min:3',
        ]);

        $order = new Order();
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
        //
        $order = Order::find($id);

        $product = Product::where('id', $order->productId)->first();
        $client = Client::where('id', $product->clientId)->first();
        $type = Type::where('id', $product->typeId)->first();
        $brand = Brand::where('id', $product->brandId)->first();
        $model = ModelBrand::where('id', $product->modelId)->first();
        $userName = User::where('id', $order->userId)->first();

        $order = [
            'id' => $order->id,
            'type' => $type->title,
            'brand' => $brand->title,
            'model' => $model->title,
            'clientId' => $client->id,
            'client' => $client->name,
            'clientPhone' => $client->phone,
            'clientEmail' => $client->email,
            'serial' => $product->serial,
            'userName' => $userName->name,
            'password' => $order->password,
            'now' => $order->now,
            'problem' => $order->problem,
            'created_at' => $order->created_at,
            'description' => $order->description,
            'active' => $order->active
        ];

        return view('order.show', compact('order'));

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
