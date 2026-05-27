<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class PricingAlat extends Model
{
    use HasFactory;

    protected $table = 'pricing_alats';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'alat_berat_id',

        // JSON ARRAY
        'jenis_pekerjaan',

        // BAKET
        // 'harga_sewa_hari_baket',
        'harga_sewa_jam_baket',

        // BREKER
        // 'harga_sewa_hari_breker',
        'harga_sewa_jam_breker',

        'berlaku_mulai',
        'berlaku_selesai'
    ];

    protected $casts = [
        'jenis_pekerjaan' => 'array',
        'berlaku_mulai'   => 'date',
        'berlaku_selesai' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    // RELASI
    public function alat()
    {
        return $this->belongsTo(
            AlatBerat::class,
            'alat_berat_id'
        );
    }
}