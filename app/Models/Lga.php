<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lga extends Model
{
    public $timestamps = false;
    protected $table = 'lga';
    protected $primaryKey = 'uniqueid';

    protected $fillable = ['lga_id', 'lga_name', 'state_id'];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function wards()
    {
        return $this->hasMany(Ward::class, 'lga_id');
    }
}
