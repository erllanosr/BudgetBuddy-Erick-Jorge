<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CuentaBancaria;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class Transaccion extends Model
{
    protected $table = 'transacciones';
    use HasFactory;
    protected $fillable= [
        'cb_origen_id',
        'monto',
        'descripcion',
        'fecha',
        'titular_cb_destino',
        'numero_cb_destino',
        'usuario_id',
    ];
    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class, 'cb_origen_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
