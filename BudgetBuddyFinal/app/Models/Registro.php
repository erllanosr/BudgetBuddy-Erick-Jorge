<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;
    protected $table = 'registro';

    protected $fillable = [
        'id',
        'email',
        'password',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
