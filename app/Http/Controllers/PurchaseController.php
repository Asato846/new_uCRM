<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Inertia\Inertia;
use lluminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $purchases = Purchase::searchPurchases($request->search)
            ->with('item') // itemテーブルを結合
            ->get(); // get()でコレクションを取得

        // 合計金額を計算するための処理
        $purchases = $purchases->map(function ($purchase) {
            $purchase->subtotal = $purchase->quantity * $purchase->item->price;
            $purchase->item_name = $purchase->item->name;
            return $purchase;
        });

        return Inertia::render('Purchases/Index',[
            'purchases' => $purchases
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseRequest $request)
    {
	Purchase::create([
            'session_id' => session()->getId(),
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
	    'purchase_status' => 0
        ]);
        return to_route('items.index')
        ->with([
            'message' =>'カートに追加しました。',
            'status' =>'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $purchases = Purchase::searchAfterPurchases($request->search)
            ->with('item') // itemテーブルを結合
            ->get(); // get()でコレクションを取得

        // 合計金額を計算するための処理
        $purchases = $purchases->map(function ($purchase) {
            $purchase->subtotal = $purchase->quantity * $purchase->item->price;
            $purchase->item_name = $purchase->item->name;
            return $purchase;
        });

        return Inertia::render('Purchases/Show',[
            'purchases' => $purchases
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePurchaseRequest  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseRequest $request)
    {
        $ids = $request->input('ids');

        // IDが空でないことを確認し、該当するレコードを更新
        if (!empty($ids)) {
            Purchase::whereIn('id', $ids)
                    ->update(['purchase_status' => 1]);
        }

        // 更新後、元のページにリダイレクト
        return to_route('items.index')
            ->with([
                'message' => '商品を購入しました。ありがとうございます。',
                'status' => 'success'
            ]);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
