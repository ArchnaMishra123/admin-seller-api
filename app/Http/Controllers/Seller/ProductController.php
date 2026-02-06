<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ProductController extends Controller
{
   
    public function store(Request $request)
    {
        $request->validate([
            'product_name'        => 'required|string|max:255',
            'product_description' => 'required|string',

            'brands'                    => 'required|array|min:1',
            'brands.*.brand_name'       => 'required|string|max:255',
            'brands.*.detail'           => 'required|string',
            'brands.*.price'            => 'required|numeric|min:0',
            'brands.*.image'            => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            /** Create Product */
            $product = Product::create([
                'seller_id'           => auth()->id(),
                'product_name'        => $request->product_name,
                'product_description' => $request->product_description,
            ]);

            /** Save Brands */
            foreach ($request->brands as $index => $brand) {

                $imagePath = $request
                    ->file("brands.$index.image")
                    ->store('brands', 'public');

                $product->brands()->create([
                    'brand_name' => $brand['brand_name'],
                    'detail'     => $brand['detail'],
                    'price'      => $brand['price'],
                    'image'      => $imagePath,
                ]);
            }

            DB::commit();

            return response()->json([
                'status'     => true,
                'message'    => 'Product added successfully',
                'product_id' => $product->id
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Product creation failed',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * PRODUCT LIST (AUTH SELLER ONLY)
     */
    public function index()
    {
        return Product::where('seller_id', auth()->id())
            ->with('brands')
            ->paginate(10);
    }

    /**
     * VIEW PRODUCT PDF
     */
    public function viewPdf($id)
    {
        $product = Product::where('seller_id', auth()->id())
            ->with('brands')
            ->findOrFail($id);

        $total = $product->brands->sum('price');

        $pdf = PDF::loadView('pdf.product', compact('product', 'total'));

        return $pdf->stream('product.pdf');
    }

    /**
     * DELETE PRODUCT
     */
    public function destroy($id)
    {
        $product = Product::where('seller_id', auth()->id())
            ->findOrFail($id);

        $product->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}
