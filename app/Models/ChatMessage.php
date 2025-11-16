<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    /**
     * Database table ka naam.
     */
    protected $table = 'chat_messages';

    /**
     * Table ka Primary Key.
     */
    protected $primaryKey = 'msg_id';

    /**
     * created_at aur updated_at columns nahi hain.
     */
    public $timestamps = false;

    /**
     * Mass assignment ke liye fields.
     */
    protected $fillable = [
        'incoming_msg_id',
        'outgoing_msg_id',
        'msg',
        'is_read',
        'msg_type',
        'file_path',
        'reply_to_message_id'
    ];
}