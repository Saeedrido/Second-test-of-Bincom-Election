<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    public $timestamps = false;
    protected $table = 'party';
    protected $primaryKey = 'id';
    protected $fillable = ['partyid', 'partyname'];
}
