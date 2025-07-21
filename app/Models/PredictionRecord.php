<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredictionRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'anak_id', 'antropometry_record_id', 'status_stunting', 'status_underweight', 'status_wasting', 'recommendation'
    ];

    public function anak()
    {
        return $this->belongsTo(Anak::class);
    }

    public function antropometryRecord()
    {
        return $this->belongsTo(AntropometryRecord::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
