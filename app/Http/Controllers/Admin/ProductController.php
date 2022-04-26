<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
    public function addProduct()
    {
        $categories = Category::latest()->get();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {

        $image = $request->file('thumbnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(917, 1000)->save('uploads/products/thumbnail/' . $name_gen);
        $save_url = 'uploads/products/thumbnail/' . $name_gen;

        $product_id =  Product::insertGetId([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'title' => $request->title,
            'price' => $request->price,
            'thumbnail' => $save_url,
            'description' => $request->description,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Product Added Success!',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }

    //===============Manage Products=================//
    public function manageProduct()
    {
        $products = Product::latest()->get();
        return view('admin.product.index', compact('products'));
    }

    //================Product Edit==============//
    public function edit($product_id)
    {
        $product = Product::findOrFail($product_id);
        $categories = Category::latest()->get();
        $subcategories = Subcategory::latest()->get();
        return view('admin.product.edit', compact('product', 'categories', 'subcategories'));
    }

    //===========Product Data Update==============//
    public function productDataUpdate(Request $request)
    {
        $product_id = $request->product_id;
        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
        ]);

        Product::findOrFail($product_id)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Product Updated Success!',
            'alert-type' => 'success'
        );
        return Redirect()->route('manage-product')->with($notification);
    }

    //===================Product Thumbnail Update================//
    public function thumbnailUpdate(Request $request)
    {
        $pro_id = $request->product_id;
        $oldImage = $request->old_img;
        // unlink($oldImage);
        $image = $request->file('thumbnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(917, 1000)->save('uploads/products/thumbnail/' . $name_gen);
        $save_url = 'uploads/products/thumbnail/' . $name_gen;

        Product::findOrFail($pro_id)->update([

            'thumbnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Product Thumbnail Update Success!',
            'alert-type' => 'success'
        );
        return Redirect()->route('manage-product')->with($notification);
    }

    public function delete($product_id)
    {
        $product = Product::findOrFail($product_id);
        unlink($product->thumbnail);
        Product::findOrFail($product_id)->delete();
        $notification = array(
            'message' => 'Product Delete Success!',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }

    public function search()
    {
        $search_text = $_GET['query'];

        // $products = DB::table('products')
        //     ->select('products.*', 'categories.*', 'subcategories.*')
        //     ->join('categories', 'categories.id', '=', 'products.category_id')
        //     ->join('subcategories', 'subcategories.id', '=', 'products.subcategory_id')
        //     ->where("products.title", "LIKE", "%" . $search_text . "%")
        //     ->orWhere("products.price", "LIKE", "%" . $search_text . "%")
        //     ->orWhere("products.categories.title", "LIKE", "%" . $search_text . "%")
        //     ->orWhere("products.subcategories.title", "LIKE", "%" . $search_text . "%")
        //     ->get();
        $products = Product::with('Category')->with('Subcategory')->where("title", "LIKE", "%" . $search_text . "%")
            ->orWhere("price", "LIKE", "%" . $search_text . "%")
            ->orWhereHas('category', function ($q) use ($search_text) {
                $q->where(function ($q) use ($search_text) {
                    $q->where('title', 'LIKE', '%' . $search_text . '%');
                });
            })
            ->orWhereHas('subcategory', function ($q) use ($search_text) {
                $q->where(function ($q) use ($search_text) {
                    $q->where('title', 'LIKE', '%' . $search_text . '%');
                });
            })
            ->orWhere('title', "LIKE", "%" . $search_text . "%")
            ->orWhere("subcategory_id", "LIKE", "%" . $search_text . "%")
            ->get();


        return view('admin.product.index', compact('products'));
    }
}