<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','product']);
    }

    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->has("type_id")) {
            $query->where("type_id", $request->get("type_id"));
        }
        if ($request->has("size_id")) {
            $query->where("size_id", $request->get("size_id"));
        }
        if($request->has("name") and strlen($request->get("name"))>3){
            $query->where("name","liken", "%".$request->get("name")."%");
        }
        $products = $query->paginate(15);

        return response()->json(['status' => 1, "data" => $products]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'type_id' => ['required'],
            'color_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'=>true,
                'message' =>  $validator->errors(),
            ] , Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $product = new Product;
        $product->color_id = $request->color_id;
        $product->type_id = $request->type_id;
        $product->name = $request->name;
        $product->save();
        return response()->json(['status' => 1, "data" => $product]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'type_id' => ['required'],
            'color_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'=>true,
                'message' =>  $validator->errors(),
            ] , Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $product = Product::where("id",$id)->first();
        if(!$product){
            return response()->json([
                'error'=>true,
                'message' =>  $validator->errors(),
            ] , Response::HTTP_NOT_FOUND);
        }
        $product->color_id = $request->color_id;
        $product->type_id = $request->type_id;
        $product->name = $request->name;
        $product->save();
        return response()->json(['status' => 1, "data" => $product]);
    }

    public function destroy(Request $request, $id){
        $product = Product::where("id",$id)->first();
        if($product){
            $product->delete();
        }
        return response()->json(['status' => 1]);
    }
}
