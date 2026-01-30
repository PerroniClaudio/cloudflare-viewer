<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class R2Connection extends Model
{
    /** @use HasFactory<\Database\Factories\R2ConnectionFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'access_key_id',
        'secret_access_key',
        'endpoint',
        'bucket',
    ];

    protected function casts(): array
    {
        return [
            'access_key_id' => 'encrypted',
            'secret_access_key' => 'encrypted',
        ];
    }
}
