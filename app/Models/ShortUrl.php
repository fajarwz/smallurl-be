<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use DateTimeInterface;

class ShortUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'original_url',
        'short_url',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->name = $model->name ?? $model->original_url;
        });
    }
}
