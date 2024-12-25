<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'genre_id',
        'name',
        'image',
        'outline',
        'avg_rating'
    ];
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'shop_id');
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'shop_id');
    }
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
    public function representative()
    {
        return $this->hasOne(Representative::class, 'shop_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'shop_id');
    }
}
