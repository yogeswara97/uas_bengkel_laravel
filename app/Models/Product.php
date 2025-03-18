<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','category_id','images','price','stock','description','on_sale'];

    public function getImagesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}
