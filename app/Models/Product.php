<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Product extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'category_id',
        'stock',
    ];
 
    protected $casts = [
        'price' => 'decimal:2',
    ];
 
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
 
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
 
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return asset('images/no-image.png');
    }
 
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }
}