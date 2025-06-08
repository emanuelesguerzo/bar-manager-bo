<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            "table_number" => "required|integer|min:1|max:50",
            "sellables" => "required|array",
            "sellables.*.id" => "required|exists:sellables,id",
            "sellables.*.quantity" => "required|integer|min:1",
        ]);

        $data = $request->all();

        $newOrder = new Order();
        $newOrder->table_number = $data["table_number"];
        $newOrder->status = "inviato";
        $newOrder->save();

        $orderItems = [];

        foreach ($data["sellables"] as $sellable) {
            $orderItems[$sellable["id"]] = ["quantity" => $sellable["quantity"]];
        }

        $newOrder->sellables()->attach($orderItems);

        return response()->json([
            "success" => true,
            "message" => "Ordine creato con successo!",
            "order_id" => $newOrder->id,
        ], 201);
    }
}
