<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $fillable = ['message', 'sender', 'direction', 'action'];
}
