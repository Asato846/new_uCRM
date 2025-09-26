<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Item;

class Item extends Model
{
    use HasFactory;
    protected $fillable =[
	'name',
	'author',
	'memo',
	'price',
	'is_selling',
	'image_id',
    ];

    public function purchases()
    {
       return $this->belongsToMany(Purchase::class)
       ->withPivot('quantity');
    }

    public function scopeSearchItems($query, $input = null)
    {
        if(!empty($input)){
            if(Item::where('name', 'like', '%' .  $input . '%' )
            ->orWhere('author', 'like', $input . '%')->exists())
                {
                return $query->where('name', 'like', '%' . $input . '%' )
                ->orWhere('author', 'like', $input . '%');
                }
        }
    }
}
