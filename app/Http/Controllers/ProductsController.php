<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    // menampilkan seluruh data
     public function index()
    {
        $products = Products::all();
        return response()->json($products);
    }
    
    // membuat data baru
     public function create(Request $request)
    {
        //validate products name. nama produk tidak boleh sama
        $this->validate($request, [
            "name" => "required|unique:products",
            "price" => "required",
            "category" => "required"
        ]);

        // $products = new Products();
        // $products->name = $request->name;
        // $products->price = $request->price;
        // $products->category = $request->category;

        $data = $request->all();
        $products = Products::create($data);

        return response()->json($products);
    }

    // menampilkan detail salah satu data
    public function show($id)
    {     
        $products = Products::find($id);

        if(!$products){
            return response()->json(['message' => 'Product Not Found!'], 404);
        }

        return response()->json($products);
    }

    // mengubah/update data by id
    public function update(Request $request, $id)
    {
        $products = Products::find($id);

        if(!$products){
            return response()->json(['message' => 'Data Not Found!'], 404);
        }

        // validasi data
        $this->validate($request, [
            "name" => "required|unique:products",
            "price" => "required",
            "category" => "required"
        ]);

        $products->name = $request->input('name');
        $products->price = $request->input('price');
        $products->category = $request->input('category');
        $products->save();

        // $data = $request->all();
        // $products->fill($data);
        // $products->save();

        return response()->json($products);
    }

    public function destroy($id)
    {
        $products = Products::find($id);
        
        if (!$products) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $products->delete();

        return response()->json(['message' => 'Data deleted successfully'], 200);
    }

    //
}
