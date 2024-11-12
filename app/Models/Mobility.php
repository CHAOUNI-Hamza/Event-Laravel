<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Mobility extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name_benefit',
        'last_name_benefit',
        'date_go',
        'date_return',
        'destination',
        'laboratory',
        'department',
        'user_id',
        'status',
        //'slug',
        'type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
