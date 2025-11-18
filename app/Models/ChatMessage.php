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

    // ==========================================================
    // === YEH NAYA CODE ADD HUA HAI ===
    // ==========================================================

    /**
     * यह sender की डिटेल्स (नाम, img) लाता है
     */
    public function sender()
    {
        // हम ChatUser मॉडल को 'outgoing_msg_id' (foreign key) 
        // से 'unique_id' (owner key) पर जोड़ रहे हैं
        return $this->belongsTo(ChatUser::class, 'outgoing_msg_id', 'unique_id');
    }

    /**
     * यह रिप्लाई किए गए मैसेज को लाता है
     */
    public function repliedTo()
    {
        // यह खुद ChatMessage मॉडल को 'reply_to_message_id' (foreign key)
        // से 'msg_id' (owner key) पर जोड़ रहा है
        return $this->belongsTo(ChatMessage::class, 'reply_to_message_id', 'msg_id');
    }
}