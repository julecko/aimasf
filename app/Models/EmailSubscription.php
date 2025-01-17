<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSubscription extends Model
{
    protected $table = 'email_subscriptions';
    protected $fillable = ['email', 'token'];
}
