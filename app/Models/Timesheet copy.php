<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Timesheet extends Model
{
    use HasFactory;

    protected $table = 'timesheets';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
        'tanggal_awal_hm' => 'date:Y-m-d',
        'tanggal_akhir_hm' => 'date:Y-m-d',
    ];


    protected $fillable = [
        'transaksi_sewa_id',
        'tanggal',
        'jam_baket',
        'jam_breker',
        'hm_awal',
        'hm_akhir',
        'tanggal_awal_hm',
        'tanggal_akhir_hm',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function transaksi()
    {
        return $this->belongsTo(TransaksiSewa::class, 'transaksi_sewa_id');
    }
}
