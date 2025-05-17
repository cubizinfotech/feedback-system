<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'is_mail_sent',
        'total_mail_sent'
    ];

    protected $casts = [
        'is_mail_sent' => 'boolean',
        'total_mail_sent' => 'integer'
    ];

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
