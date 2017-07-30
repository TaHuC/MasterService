<?php

namespace App\Http\Controllers;

use App\ModelBrand;
use Illuminate\Http\Request;

class ModelController extends Controller
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

    public function findModel($model, $brand)
    {

        if(is_numeric($brand))
        {
            $models = ModelBrand::where([
                ['brandId', '=', $brand],
                ['title', 'like', '%'.$model.'%']
            ])->get();

            return response()->json($models);
        }

        return false;
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
        //Valideite data
        $this->validate($request, [
            'brand' => 'required|numeric',
            'model' => 'required|unique:models,brandId,'.$request->brand,
        ]);

        $model = new ModelBrand();
        $model->brandId = $request->brand;
        $model->title = $request->model;
        $model->save();

        return $model->id;
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
