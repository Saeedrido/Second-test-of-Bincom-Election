<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncedPuResult extends Model
{
    public $timestamps = false;
    protected $table = 'announced_pu_results';
    protected $primaryKey = 'result_id';

    protected $fillable = [
        'polling_unit_uniqueid',
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

    protected static function booted(): void
    {
        static::saving(function (AnnouncedPuResult $model) {
            if ($model->party_abbreviation === 'LABOUR') {
                $model->party_abbreviation = 'LABO';
            }
        });
    }

    public function pollingUnit()
    {
        return $this->belongsTo(PollingUnit::class, 'polling_unit_uniqueid', 'uniqueid');
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_abbreviation', 'partyid');
    }
}

