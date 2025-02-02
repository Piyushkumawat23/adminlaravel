<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderSetting extends Model
{
    use HasFactory;

    protected $table = 'slider_settings';

    protected $fillable = ['autoplay', 'speed', 'loop'];
}
