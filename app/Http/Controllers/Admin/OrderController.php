<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input("status", "inviato");

        $query = Order::with(["sellables"]);

        if ($status) {
            $query->where("status", $status);
        }

        $orders = $query->orderByDesc("created_at")->paginate(6);

        return view("admin.orders.index", compact("orders", "status"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            "status" => "required|in:inviato,preparazione,servito,chiuso"
        ]);

        $data = $request->all();

        $order->status = $data["status"];

        $order->save();

        return redirect()->route("admin.orders.index")->with("success", "Stato ordine Tavolo $order->table_number aggiornato.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
