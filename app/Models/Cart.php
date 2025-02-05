<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'quantity', 'price','total_price','order_id','email','phone','streetaddress','pin','city'];

    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
