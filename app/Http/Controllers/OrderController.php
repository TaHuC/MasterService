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
        $orders = Order::with(['status', 'product', 'user'])
            ->get();

        for($i = 0; $i < count($orders); $i++)
        {
            $clientName = Client::where('id', $orders[$i]->product->clientId)->get();
            $orders[$i]->product->client = $clientName[0];
        }

        return $orders;
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function paramsOrder(Request $request) {

        if($request->status === 'last'){
            $orders = Order::limit($request->limit)
                ->orderBy('id', 'desc')
                ->get();
            return $orders;
        } else {
            $orders = Order::where('statusId', '=', 3)
                ->get();
            return $orders;
        }
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

        return redirect()->route('product.show', ['id' => $request->productId])->with(['messages' => 'Add new Order']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
     * @param $id
     *
     */
    public function getProductId($id)
    {
        if(is_numeric($id))
        {
            $productId = Order::find($id);

            if(count($productId)){
                return $productId->productId;
            } else {
                return 'orderNull';
            }
        } else {
            return 'orderNull';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $this->validate($request, [
           'status' => 'required|numeric',
           'orderId' => 'required|numeric',
           'productId' => 'required|numeric'
        ]);

        $order = Order::find($request->orderId);
        $order->statusId = $request->status;
        $order->save();

        return redirect()->route('product.show', ['id' => $request->productId])->with('messages', 'Successed.');
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
