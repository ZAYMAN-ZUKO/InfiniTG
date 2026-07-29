<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'file_name',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
        'is_favorite',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}