<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $items = Item::select('id','name','author','price','is_selling','image_id')->paginate(8)->through(function ($item) {
//            return [
//                'id' => $item->id,
//                'name' => $item->name,
//                'author' => $item->author,
//                'price' => $item->price,
//                'is_selling' => $item->is_selling,
//                'image_id' => $item->image_id, // 元のimage_idも残しておく
//                'image_url' => asset('images/' . $item->image_id), // asset()を使ってURLを生成
//            ];
//        });
	
	$items = Item::searchItems($request->search)
		->select('id','name','author','price','is_selling','image_id')->paginate(8)->through(function ($item) {
                    return [
                       'id' => $item->id,
                       'name' => $item->name,
                       'author' => $item->author,
                       'price' => $item->price,
                       'is_selling' => $item->is_selling,
                       'image_id' => $item->image_id, // 元のimage_idも残しておく
                       'image_url' => asset('images/' . $item->image_id), // asset()を使ってURLを生成
                    ];
                  });
	
	return Inertia::render('Items/Index',[
	    'items' => $items
	]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Items/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request)
    {
	$validatedData = $request->validated(); 
        if ($request->hasFile('file')) {
           $disk = Storage::build([
               'driver' => 'local',
               'root' => public_path('images'),
           ]);

           $hoge = date('YmdHis') . '.png';
           $disk->putFileAs('', $request->file('file'), $hoge);

           // ファイル名（$hoge）をDBに保存
           Item::create([
               'name' => $request->name,
               'author' => $request->author,
               'memo' => $request->memo,
               'price' => $request->price,
               'image_id' => $hoge // ここにファイル名をセット
           ]);
       } else {
           // ファイルが存在しない場合は、'image_id'をnullとしてDBに保存
           Item::create([
               'name' => $request->name,
               'author' => $request->author,
               'memo' => $request->memo,
               'price' => $request->price,
               'image_id' => null
           ]);
       }

       return to_route('items.index')
           ->with([
               'message' => '登録が完了しました。',
               'status' => 'success'
           ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
	$item->image_url = asset('images/' . $item->image_id);
        return Inertia::render('Items/Show', [
	    'item' => $item,
	    'currentUserName' => auth()->user()->name
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $item->image_url = asset('images/' . $item->image_id);
        return Inertia::render('Items/Edit', [
            'item' => $item, 
	    'currentUserName' => auth()->user()->name
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    
public function update(UpdateItemRequest $request, Item $item)
{
    $disk = Storage::build([
        'driver' => 'local',
        'root' => public_path('images'),
    ]);

    // 新しい画像がアップロードされた場合のみ処理
    if ($request->hasFile('file')) {
        // 古い画像を削除（存在する場合）
        if ($item->image_id && file_exists(public_path('images/' . $item->image_id))) {
            unlink(public_path('images/' . $item->image_id));
        }

        // 新しい画像を保存
        $filename = date('YmdHis') . '.png';
        $disk->putFileAs('', $request->file('file'), $filename);

        // 新しいファイル名を保存
        $item->image_id = $filename;
    }

    $item->name = $request->name;
    $item->author = $request->author;
    $item->memo = $request->memo;
    $item->price = $request->price;
    $item->is_selling = $request->is_selling;
    $item->save();

    return to_route('items.index')->with([
        'message' => '更新しました。',
        'status' => 'success'
    ]);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
	if ($item->image_id && file_exists(public_path('images/' . $item->image_id))) {
            unlink(public_path('images/' . $item->image_id));
        }
	$item->delete();
        return to_route('items.index')
        ->with([
            'message' => '削除しました。',
            'status' => 'danger'
        ]);        
    }
}
