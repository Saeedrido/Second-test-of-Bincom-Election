<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    public $timestamps = false;
    protected $table = 'ward';
    protected $primaryKey = 'uniqueid';

    protected $fillable = ['ward_id', 'ward_name', 'lga_id'];

    public function lga()
    {
        return $this->belongsTo(Lga::class, 'lga_id');
    }

    public function pollingUnits()
    {
        return $this->hasMany(PollingUnit::class, 'uniquewardid');
    }
}
