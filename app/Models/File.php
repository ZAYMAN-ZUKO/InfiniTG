<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Folder;

class File extends Model
{
    use SoftDeletes;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'user_id',
        'original_name',
        'stored_name',
        'file_path',
        'telegram_file_id',
        'telegram_message_id',
        'telegram_chat_id',
        'storage_driver',
        'mime_type',
        'file_size',
        'checksum',
        'is_favorite',
    
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'file_size' => 'integer',
        'telegram_message_id' => 'integer',
        'telegram_chat_id' => 'integer',
        'is_favorite' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    /**
     * File owner.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
 * Folder
 */
public function folder()
{
    return $this->belongsTo(Folder::class);
}
}