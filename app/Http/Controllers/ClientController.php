<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Client;
use App\ModelBrand;
use App\Order;
use App\Product;
use App\Status;
use App\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use function Sodium\compare;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return 'All client';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // View create form
        return view('client.create');
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
           'name' => 'required|max:255',
            'email' => 'min:3|max:255|unique:clients',
            'phone' => 'required|unique:clients|numeric'
        ]);

        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->save();

        return redirect()->route('client.show', ['id' => $client->id]);
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
        $client = Client::find($id);
        $types = Type::all();

        $products = Product::where('clientId', $client->id)->get();
        $finalProducts = null;

        for ($i = 0; $i < count($products); $i++)
        {
            $type = Type::where('id', $products[$i]->typeId)->first();
            $brand = Brand::where('id', $products[$i]->brandId)->first();
            $model = ModelBrand::where('id', $products[$i]->modelId)->first();
            $user = User::where('id', $products[$i]->userId)->first();
            $order = Order::where('productId', $products[$i]->id)->first();
            if($order != null)
            {
                $status = Status::where('id', $order->statusId)->first();
            }

            $finalProducts[$i] = [
                'id' => $products[$i]->id,
                'type' => $type->title,
                'brand' => $brand->title,
                'model' => $model->title,
                'user' => $user->name,
                'serial' => $products[$i]->serial,
                'status' => $status->status,
                'orderId' => $order->id,
                'created' => $products[$i]->created_at
            ];
        }

        return view('client.show', compact('client', 'types', 'finalProducts'));
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
        $client = Client::find($id);

        return view('client.edit', compact('client'));
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
        $client = Client::find($id);
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'min:3|max:255',
                Rule::unique('client')->ignore($client->id),
            'phone' => 'required|numeric',
                Rule::unique('client')->ignore($client->id),
        ]);
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->save();

        return view('client.show', compact('client'));
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
