<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public $timestamps = false;
    protected $table = 'states';
    protected $primaryKey = 'state_id';

    protected $fillable = ['state_name'];

    public function lgas()
    {
        return $this->hasMany(Lga::class, 'state_id');
    }
}

