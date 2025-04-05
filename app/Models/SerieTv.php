<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerieTv extends Model
{
    use HasFactory;

    protected $table = 'serie_tv';

    protected $fillable = ['title', 'year', 'description', 'category', 'language'];

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function getEpisodesCountAttribute()
    {
        return $this->episodes()->count();
    }
}


