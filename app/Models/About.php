<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class About extends Model
{
    use HasFactory;

    protected $table = 'abouts';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'deskripsi',
        'gambar'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }
}
