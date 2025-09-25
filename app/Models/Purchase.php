<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    public function scopeSearchPurchases($query, $input = null)
    {
        if(!empty($input)){
		return $query->where('session_id', session()->getId());
	}
    }

    protected $fillable = ['id','session_id','item_id','quantity','purchase_status'];
}
