<?php

// 1. Galti Fix: Namespace ko 'App\Models' karein
namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory; // 2. Galti Fix: Hyphen (-) hata diya
use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    use HasFactory;

    protected $table = 'users_chat';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    /**
     * Yeh sabhi fields 'fillable' mein hone zaroori hain.
     * Aapka yeh array bilkul sahi hai!
     */
    protected $fillable = [
        'unique_id',
        'fname',
        'lname',
        'email',
        'password',
        'img',
        'status'
    ];
}