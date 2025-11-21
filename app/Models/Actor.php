<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'email',
        'description',
        'first_name',
        'last_name',
        'address',
        'height',
        'weight',
        'gender',
        'age',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'age' => 'integer',
    ];
}
