<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['model', 'year', 'user_id', 'manufacturer_id'];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
