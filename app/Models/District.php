<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = [
        'district',
        'region_id',
        'category',
        'capital',
        'established'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }
}
