<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = ['name','email', 'phone', 'streetaddress', 'pin', 'city', 'product_id', 'price'];

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

}
