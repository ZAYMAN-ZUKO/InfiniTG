<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_id',
        'name',
    ];

    /**
     * Owner
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Parent Folder
     */
    public function parent()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    /**
     * Child Folders
     */
    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    /**
     * Files inside this folder
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }
}