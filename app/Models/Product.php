<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'price',
    ];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function reduceStock($quantity)
    {
        $this->quantity -= $quantity;
        $this->save();
    }

    public function increaseStock($quantity)
    {
        $this->quantity += $quantity;
        $this->save();
    }
}
