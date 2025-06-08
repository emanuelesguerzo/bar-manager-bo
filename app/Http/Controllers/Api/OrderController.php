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

        foreach ($newOrder->sellables as $sellable) {

            $orderedQuantity = $sellable->pivot->quantity;

            foreach ($sellable->products as $product) {

                $perUnitQuantity = $product->pivot->quantity;
                $unit = $product->pivot->unit;

                $totalToSubtract = $perUnitQuantity * $orderedQuantity;

                // Sottraggo il totale dagli stock ml e g del magazzino
                if ($unit === 'ml') {
                    $product->stock_ml -= $totalToSubtract;
                } elseif ($unit === 'g') {
                    $product->stock_g -= $totalToSubtract;
                }

                // Aggiorno unita' stoccate in magazzino
                if ($unit === 'ml' && $product->unit_size_ml) {
                    $product->units_in_stock = floor($product->stock_ml / $product->unit_size_ml);
                } elseif ($unit === 'g' && $product->unit_size_g) {
                    $product->units_in_stock = floor($product->stock_g / $product->unit_size_g);
                }

                $product->save();
            }
        }

        return response()->json([
            "success" => true,
            "message" => "Ordine creato con successo!",
        ], 201);
    }
}
