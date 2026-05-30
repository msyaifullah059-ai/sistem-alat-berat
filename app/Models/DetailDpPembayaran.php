<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class DetailDpPembayaran extends Model
{
    use HasFactory;

    protected $table = 'detail_dp_pembayarans';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'tanggal_bayar' => 'date:Y-m-d'
    ];

    protected $fillable = [
        'dp_pembayaran_id',
        'tanggal_bayar',
        'jumlah',
        'keterangan',
        'gambar'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function pembayaran()
    {
        return $this->belongsTo(
            DpPembayaran::class,
            'dp_pembayaran_id'
        );
    }
}