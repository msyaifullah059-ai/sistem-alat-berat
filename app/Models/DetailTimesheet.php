<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class DetailTimesheet extends Model
{
    use HasFactory;

    protected $table = 'detail_timesheets';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'timesheet_id',

        'tanggal_pekerjaan',

        'jam_baket',

        'hm_awal',

        'hm_akhir',

        'jam_breker',

        'gambar'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (empty($model->id)) {

                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke Header Timesheet
     */
    public function timesheet()
    {
        return $this->belongsTo(
            Timesheet::class,
            'timesheet_id'
        );
    }
}