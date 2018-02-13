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

    public function getSerial($serial)
    {

        $get = Product::where('serial', 'LIKE', '%'.$serial.'%')->get();

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

        //dd($product);
        return view('product.show', compact('product'));
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
