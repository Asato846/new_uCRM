<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::searchItems($request->search)
                 ->select('id','name','author','price','is_selling','image_id')
                 ->paginate(8);

        $processedItems = $items->through(function ($item) {
             return [
                'id' => $item->id,
                'name' => $item->name,
                'author' => $item->author,
                'price' => $item->price,
                'is_selling' => $item->is_selling,
                'image_id' => $item->image_id, 
                'image_url' => asset('images/' . $item->image_id), 
             ];
         });

        $welcomeData = [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ];

        return Inertia::render('Welcome',[
            'items' => $processedItems, // 修正したデータを使用
            ...$welcomeData
        ]);
    }
}
