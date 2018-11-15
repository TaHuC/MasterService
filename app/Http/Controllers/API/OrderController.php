<?php

namespace App\Http\Controllers\API;

use App\Brand;
use App\Client;
use App\ModelBrand;
use App\Order;
use App\Product;
use App\Type;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $orders = Order::where('id', '=', $id)
            ->orderBy('id', 'desc')
            ->with('status', 'product', 'user')
            ->get();

        for($i = 0; $i < count($orders); $i++)
        {
            $clientName = Client::where('id', $orders[$i]->product->clientId)->get();
            $orders[$i]->product->client = $clientName[0];
        }

        for($i = 0; $i < count($orders); $i++)
        {
            $typeName = Type::where('id', $orders[$i]->product->typeId)->get();
            $orders[$i]->product->type = $typeName[0];
        }

        for($i = 0; $i < count($orders); $i++)
        {
            $brandName = Brand::where('id', $orders[$i]->product->brandId)->get();
            $orders[$i]->product->brand = $brandName[0];
        }
    
        for($i = 0; $i < count($orders); $i++)
        {
            $modelName = ModelBrand::where('id', $orders[$i]->product->modelId)->get();
            $orders[$i]->product->model_brand = $modelName[0];
        }

        return $orders;
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
