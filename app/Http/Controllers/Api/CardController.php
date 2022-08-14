<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function index(Request $request){
        $query = Card::query();
        $query->with(["user","product"]);
        $query->where("user_id",auth('api')->id());
        if($request->has("product_id")){
            $query->where("product_id",$request->get("product_id"));
        }
        $cards = $query->paginate(15);
        return response()->json(['status' => 1, "data" => $cards]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => ['required','exists:products,id']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=>true,
                'message' =>  $validator->errors(),
            ] , Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $product = Product::where("id",$request->get("product_id"))->first();
        $card = new Card;
        $card->product_id = $request->get("product_id");
        $card->user_id = auth('api')->id();
        $card->quantity = $request->get("quantity", 1);
        $card->total_price = $request->get("quantity", 1) * ($product->price);
        $card->save();
        return response()->json(['status' => 1, "data" => $card]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'product_id' => ['required','exists:products,id']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'=>true,
                'message' =>  $validator->errors(),
            ] , Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $card = Card::where("id",$id)->first();
        if(!$card){
            return response()->json([
                'error'=>true,
                'message' =>  $validator->errors(),
            ] , Response::HTTP_NOT_FOUND);
        }
        if($card->user_id != auth('api')->id()){
            return response()->json([
                'error'=>true,
                'message' => "Other user card"
            ] , Response::HTTP_NOT_FOUND);
        }
        $product = Product::where("id",$request->get("product_id"))->first();

        $card->product_id = $request->get("product_id");
        if($request->has("quantity")){
            $card->quantity = $request->get("quantity");
            $card->total_price = $request->get("quantity") * ($product->price);
        }
        $card->save();
        return response()->json(['status' => 1, "data" => $card]);
    }

    public function destroy(Request $request, $id){
        $card = Card::where("id",$id)->first();
        if($card){
            $card->delete();
        }
        if($card->user_id != auth('api')->id()){
            return response()->json([
                'error'=>true,
                'message' => "Other user card"
            ] , Response::HTTP_NOT_FOUND);
        }
        return response()->json(['status' => 1]);
    }

    public function quantity_update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'quantity' => ['required']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=>true,
                'message' =>  $validator->errors(),
            ] , Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $card = Card::where("id",$id)->first();
        if(!$card){
            return response()->json([
                'error'=>true,
                'message' =>  $validator->errors(),
            ] , Response::HTTP_NOT_FOUND);
        }
        if($card->user_id != auth('api')->id()){
            return response()->json([
                'error'=>true,
                'message' => "Other user card"
            ] , Response::HTTP_NOT_FOUND);
        }
        $product = Product::where("id",$card->product_id)->first();
        if($product){
            $card->quantity = $request->get("quantity");
            $card->total_price = $request->get("quantity") * ($product->price);
        }
        $card->save();
        return response()->json(['status' => 1, "data" => $card]);
    }
}
