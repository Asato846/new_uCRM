<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    public function scopeSearchPurchases($query)
    {
	    
	    return $query->where('session_id', session()->getId())
	                 ->where('purchase_status','0');
    }
    public function scopeSearchAfterPurchases($query)
    {

            return $query->where('session_id', session()->getId())
                         ->where('purchase_status','1');
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    protected $fillable = ['id','session_id','item_id','quantity','purchase_status'];
}
