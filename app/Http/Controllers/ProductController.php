<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.dashboard', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        //dd($request->all());

        $product = new Product();

        // insert image
        if ($request->hasFile('image')) {
            // store image
            $image = $request->file('image');
            $fileName = $image->getClientOriginalName();
            $path = $image->move(public_path('uploads'), $fileName);
            // $fileName = $image->store('', 'public');
            $filePath = 'uploads/' . $fileName;
            $product->image = $filePath;
        }


        $product->name = $request->name;
        $product->price = $request->price;
        $product->short_description = $request->short_description;
        $product->qty = $request->qty;
        $product->sku = $request->sku;
        $product->description = $request->description;

        $product->save();

        // insert colors
        if ($request->has('colors') && $request->filled('colors')) {
            foreach ($request->colors as $color) {

                ProductColor::create([
                    'product_id' => $product->id,
                    'name' => $color
                ]);
            }
        }

        //insert multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // store multiple image
                $fileName = $image->getClientOriginalName();
                //$fileName = $image->store('', 'public');
                $path = $image->move(public_path('uploads'), $fileName);
                $filePath = 'uploads/' . $fileName;
                $product->image = $filePath;
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $filePath
                ]);
            }
        }
        notyf('Product Created successfully');

        return redirect()->back();
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with(['colors','images'])->findOrFail($id);
        //dd($product);
        $colors = $product->colors->pluck('name')->toArray();
        // زايده تخدم من غيرها
        $images = $product->colors->pluck('path')->toArray();
        //
        return view('admin.product.edit', compact('product','colors','images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        //dd($request->all());

        $product = Product::findOrFail($id);

        // update image
        if ($request->hasFile('image')) {
            // delete old image
            File::delete(public_path($product->image));
            // store image updating
            $image = $request->file('image');
            $fileName = $image->getClientOriginalName();
            $path = $image->move(public_path('uploads'), $fileName);
            // $fileName = $image->store('', 'public');
            $filePath = 'uploads/' . $fileName;
            $product->image = $filePath;
        }


        $product->name = $request->name;
        $product->price = $request->price;
        $product->short_description = $request->short_description;
        $product->qty = $request->qty;
        $product->sku = $request->sku;
        $product->description = $request->description;

        $product->save();

        // update colors
        if ($request->has('colors') && $request->filled('colors')) {
            // delete old colors
            foreach ($product->colors as $color) {
                $color->delete();
            }

            // insert new colors
            foreach ($request->colors as $color) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'name' => $color
                ]);
            }
        }

        // multiple images
        if ($request->hasFile('images')) {
            // delete old path multiple images
            foreach ($product->images as $image) {
                File::delete(public_path($image->path));
            }
            // delete old multiple images
            $product->images()->delete();


            // update multiple images
            foreach ($request->file('images') as $image) {
                // store multiple image
                $fileName = $image->getClientOriginalName();
                //$fileName = $image->store('', 'public');
                $path = $image->move(public_path('uploads'), $fileName);
                $filePath = 'uploads/' . $fileName;
                $product->image = $filePath;
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $filePath
                ]);
            }
        }
        notyf('Product Updated successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->colors()->delete();
        File::delete(public_path($product->image));
        foreach ($product->images as $image) {
            File::delete(public_path($image->path));
        }
        $product->delete();

        notyf('Product Deleted successfully');
        return redirect()->back();
    }
}
