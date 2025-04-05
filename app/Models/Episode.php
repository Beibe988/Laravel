<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'video_link', 'description', 'language', 'serie_tv_id'];

    public function serie()
    {
        return $this->belongsTo(SerieTv::class, 'serie_tv_id');
    }
}

