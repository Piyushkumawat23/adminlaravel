<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'website_settings';

    // Define the fillable columns
    protected $fillable = [
        'site_name', 
        'site_url', 
        'contact_email', 
        'support_email', 
        'phone_number', 
        'address', 
        'footer_text',
        'site_logo', 
        'active_theme',   
    ];
}
