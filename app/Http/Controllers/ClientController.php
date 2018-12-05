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
        $clients = Client::all();
        return view('client.index', compact('clients'));
    }

    /**
     * Display a listing of the resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function allClients()
    {
        $clients = Client::all();
        return $clients;
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
        if($request->email) {
            $this->validate($request, [
                'email' => 'sometimes|nullable|email'
            ]);

            $client = Client::where('email', '=', $request->email)->first();
            //return $client;
            if(count($client)) {
                return [$client, 'email'];
            }
        }

        if($request->idNumber) {
            $this->validate($request, [
                'idNumber' => 'numeric'
            ]);
            $client = Client::where('idNumber', '=', $request->idNumber)->first();
            //return $client;
            if(count($client)) {
                return [$client, 'idNumber'];
            }
        } else {
            $request->idNumber = 0;
        }

        if($request->phone) {
            $this->validate($request, [
                'phone' => 'required|numeric'
            ]);
                
            $client = Client::where('phone', '=', $request->phone)->first();
            //return $client;
            if(count($client)) {
                return [$client, 'phone'];
            }
        }
        

        $this->validate($request, [
           'name' => 'required|max:255',
            'email' => 'sometimes|nullable|email|unique:clients',
            'phone' => 'required|unique:clients|numeric',
            'idNumber' => 'numeric'
        ]);

        $client = new Client();
        $client->name = $request->name;
        $client->idNumber = $request->idNumber;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->save();

        //return redirect()->route('client.show', ['id' => $client->id]);
        return $client;
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
            $order = Order::where('productId', $products[$i]->id)->orderBy('id', 'DESC')->first();

            if($order != null)
            {
                $status = Status::where('id', $order->statusId)->first();
                $status = $status->status;
            }
            else
            {
                $status = 'No order';
            }

            $finalProducts[$i] = [
                'id' => $products[$i]->id,
                'type' => $type->title,
                'brand' => $brand->title,
                'model' => $model->title,
                'user' => $user->name,
                'status' => $status,
                'created_at' => $products[$i]->created_at,
                'serial' => $products[$i]->serial
            ];
        }
        return $client;
        //return view('client.show', compact('client', 'types', 'finalProducts'));
    }

    /**
     * Show the  client info.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getClient($id) {
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
            $order = Order::where('productId', $products[$i]->id)->orderBy('id', 'DESC')->first();

            if($order != null)
            {
                $status = Status::where('id', $order->statusId)->first();
                $status = $status->status;
            }
            else
            {
                $status = 'No order';
            }

            $finalProducts[$i] = [
                'id' => $products[$i]->id,
                'type' => $type->title,
                'brand' => $brand->title,
                'model' => $model->title,
                'user' => $user->name,
                'status' => $status,
                'created_at' => $products[$i]->created_at,
                'serial' => $products[$i]->serial
            ];
        }

        return [$client, $finalProducts, $types];
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
        //return dd($request);
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'sometimes|nullable|email',
                Rule::unique('client')->ignore($id),
            'phone' => 'required|numeric',
                Rule::unique('client')->ignore($id),
            'idNumber' => 'numeric',
        ]);

        $client = Client::find($id);
        $client->name = $request->name;
        $client->idNumber = $request->idNumber;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->save();

        //return redirect()->route('client.show', ['id' => $client->id]);
        return $client;
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //return $request->search;
        $search = $request->search;
        $clients = Client::where('name', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%')->paginate(10);

        return $clients;
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
