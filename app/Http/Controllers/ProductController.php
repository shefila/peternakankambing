<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'summary' => 'required',
            'description' => 'required',
        ]);

        $product = new Product;
        $product['name'] = $request['name'];
        $product['summary'] = $request['summary'];
        $product['description'] = $request['description'];

        $product->save();

        return redirect()->back()->withMessage('Product created');
    }

    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    public function addVariant(Product $product, Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'detail'=>'required|string',
            'stock'=>'required|integer',
            'price'=>'required|integer',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:1000'

        ]);

        $productDetails = $product->productDetails()->where('name',$request['name'])->firstOrNew();
        $productDetails['name'] = $request['name'];
        $productDetails['detail'] = $request['detail'];
        $productDetails['stock'] = $request['stock'];
        $productDetails['price'] = $request['price'];
        $image_path = null;
        if ($request->file('image') != '') {
            $main_image = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/images/profile'), $main_image);
            $image_path = '/storage/images/profile/' . $main_image;
        }
        $productDetails['image'] = $image_path;
        $productDetails->save();

        return redirect()->back()->withMessage('Product Variant created');
    }

    public function removeVariant(ProductDetail $productDetail)
    {
        if($productDetail->orderDetails()->count() == 0) {
            $productDetail->delete();
            return redirect()->back()->withMessage('Product Variant deleted');
        }
        return redirect()->back()->withMessage('Product Variant has in order details, can\'t deleted');
    }

    public function updateVariant(Request $request, ProductDetail $productDetail)
    {
        $request->validate([
            'stock'=>'required|integer|min:1',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:1000'
        ]);

        if ($request->file('image') != '') {
            $main_image = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/images/profile'), $main_image);
            $image_path = '/storage/images/profile/' . $main_image;
            $productDetail['image'] = $image_path;
        }
        $productDetail['stock'] = $request['stock'];
        $productDetail->save();

        return redirect()->back()->withMessage('Product Variant updated');
    }
}
