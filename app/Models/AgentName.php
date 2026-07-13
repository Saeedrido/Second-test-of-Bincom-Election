<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentName extends Model
{
    public $timestamps = false;
    protected $table = 'agentname';
    protected $primaryKey = 'name_id';

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'pollingunit_uniqueid',
    ];

    public function pollingUnit()
    {
        return $this->belongsTo(PollingUnit::class, 'pollingunit_uniqueid', 'uniqueid');
    }
}
