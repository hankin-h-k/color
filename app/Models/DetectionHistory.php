<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetectionHistory extends Model
{
    protected $fillable = [];
    protected $guarded = [];

    public function user()
    {
    	return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function example()
    {
    	return $this->hasOne(Example::class, 'id', 'example_id');
    }
}
