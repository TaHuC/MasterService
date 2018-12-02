<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Client;
use App\ModelBrand;
use App\Product;
use App\Order;
use App\Repair;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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
        //s
        $products = Product::with('client', 'type', 'brand', 'model', 'user')->get();

        return view('product.index', compact('products'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allDevices()
    {
        //s
        $devices = Product::with('client', 'type', 'brand', 'model', 'user')->get();

        $data = null;

        for($i = 0; $i < count($devices); $i++) {
            $data[$i]['data'] = [
                array(
                'idClient' => $devices[$i]['client']['id'], 
                'client' => $devices[$i]['client']['name'], 
                'phone' => $devices[$i]['client']['phone'],
                'devicetype' => $devices[$i]['type']['title'],
                'device' => $devices[$i]['brand']['title'].' '.$devices[$i]['model']['title'],
                'idDevice' => $devices[$i]['id'],
                'serial' =>  $devices[$i]['serial'],
                'comment' =>  $devices[$i]['comment'],
                'url' => '<a class="btn btn-sm btn-outline-light" href="/product/'.$devices[$i]['id'].'" data-toggle="tooltip" data-placement="top" title="Отвори поръчката"><i class="material-icons">assignment</i></a> <a class="btn btn-sm btn-outline-light" href="/client/'.$devices[$i]['client']['id'].'" data-toggle="tooltip" data-placement="top" title="Отвори клиента"><i class="material-icons">assignment_ind</i></a>')
            ];
        }

        //$data['length'] = count($devices);

        return $data;
    }

    public function getSerial($serial)
    {

        $get = Product::where('serial', $serial)->first();

        return $get;
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
            'serial' => 'required|min:3|max:255|unique:products',
            'typeId' => 'required|integer',
            'brandId' => 'required|integer',
            'modelId' => 'required|integer',
            'clientId' => 'required|integer'
        ]);

        $product = new Product();
        $product->clientId = $request->clientId;
        $product->typeId = $request->typeId;
        $product->brandId = $request->brandId;
        $product->modelId = $request->modelId;
        $product->userId = Auth::user()->id;
        $product->serial = $request->serial;
        $product->comment = $request->comment;
        $product->save();

        return $product->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * for ($i = 0; $i < count($product->orders); $i++){
     *$repairs = Repair::where('orderId', '=', $product->orders[$i]->id)->get();
     *$product->orders[$i]->repairs = $repairs;
     *}
     */
    public function show($id)
    {
        //
        $product = Product::with('client', 'type', 'brand', 'model', 'user', 'orders', 'repairs')
        ->find($id);

        for($i = 0; $i < count($product->repairs); $i++)
        {
            $product->repairs[$i]->user = User::where('id', '=', $product->repairs[$i]->userId)->first();
        }

        for ($i = 0; $i < count($product->orders); $i++)
        {
            $product->orders[$i]->user = User::where('id', '=', $product->orders[$i]->userId)->first();
        }

        //dd($product);
        //return view('product.show', compact('product'));

        //return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProduct($id)
    {
        //
        $product = Product::with('client', 'type', 'brand', 'modelBrand', 'user', 'orders', 'repairs')
        ->find($id);

        for($i = 0; $i < count($product->repairs); $i++)
        {
            $product->repairs[$i]->user = User::where('id', '=', $product->repairs[$i]->userId)->first();
        }

        for ($i = 0; $i < count($product->orders); $i++)
        {
            $product->orders[$i]->user = User::where('id', '=', $product->orders[$i]->userId)->first();
            $product->orders[$i]->status = Status::where('id', '=', $product->orders[$i]->statusId)->first();
        }

        //dd($product);
        return $product;
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
        if($request->newOwner) {
            $product = Product::find($id);
            $product->clientId = $request->clientId;
            $product->save();

            return $id;
        }

        return;
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

     /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;
        $products = Product::where('serial', 'like', '%'.$search.'%')->get();

        return $products;
    }
}
