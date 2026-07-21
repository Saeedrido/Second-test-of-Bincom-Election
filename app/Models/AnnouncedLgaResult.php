<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncedLgaResult extends Model
{
    public $timestamps = false;
    protected $table = 'announced_lga_results';
    protected $primaryKey = 'result_id';

    protected $fillable = [
        'lga_name',
        'party_abbreviation',
        'party_score',
        'entered_by_user',
        'date_entered',
        'user_ip_address',
    ];

    protected $casts = [
        'party_score' => 'integer',
        'date_entered' => 'datetime',
    ];
}

