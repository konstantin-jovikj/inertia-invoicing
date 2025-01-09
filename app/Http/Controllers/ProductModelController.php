<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Database\Seeders\CategoryDirectiveRegulationSeeder;

class ProductModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productModels = ProductModel::all();
        $productModels->load('category');
        // dd($productModels);

        return inertia('ProductModels/ProductModelsIndex', [
            'productModels' => $productModels,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return inertia('ProductModels/ProductModelAdd', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $data = $request->validate([
            'category_id' => ['required'],
            'model' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
        ]);
        ProductModel::create($data);
        return redirect()->route('productmodels.index')->with('message', 'Моделот е успешно додаден');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductModel $productModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductModel $productModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductModel $productModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductModel $productModel)
    {
        $productModel->delete();
        return redirect()->route('productmodels.index')->with('message', 'Моделот е успешно избришан');
    }
}
