<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::where('quantity', '>', 0);
            $query = json_decode($request->get('query'));
            $price = json_decode($request->get('price'));
            $gender = json_decode($request->get('gender'));
            $brand = json_decode($request->get('brand'));

            if (!empty($query)) {
                $products = $products->where('name', 'like', '%' . $query . '%');
            }
            if (!empty($price)) {
                $products = $products->where('price', '<=', $price);
            }
            if (!empty($gender)) {
                $products = $products->whereIn('gender', $gender);
            }
            if (!empty($brand)) {
                $products = $products->whereIn('brand', $brand);
            }
            $products = $products->get();


            $total_row = $products->count();
            if ($total_row > 0) {
                $output = '';
                foreach ($products as $product) {
                    $output .= '
                    <div class="col-lg-4 col-md-6 col-sm-12 pt-3">
                        <div class="card">
                            <a href="product/' . $product->id . '">
                                <div class="card-body ">
                                    <div class="product-info">

                                    <div class="info-1"><img src="' . asset('/storage/' . $product->image) . '" alt=""></div>
                                    <div class="info-4"><h5>' . $product->brand . '</h5></div>
                                    <div class="info-2"><h4>' . $product->name . '</h4></div>
                                    <div class="info-3"><h5>RM ' . $product->price . '</h5></div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    ';
                }
            } else {
                $output = '
                <div class="col-lg-4 col-md-6 col-sm-6 pt-3">
                    <h4>No Data Found</h4>
                </div>
                ';
            }
            $data = array(
                'table_data'    => $output
            );
            echo json_encode($data);
        }
    }
}
