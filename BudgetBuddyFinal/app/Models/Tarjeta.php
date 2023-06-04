<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Tarjeta extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'numero',
        'nombre_titular',
        'fecha_expiracion',
        'cvc',
        'balance',
    ];
    // protected $dispatchesEvents = [
    //     'created' => TarjetaCreated::class,
    // ];
    public function setNumeroAttribute($value)
    {
        $this->attributes['numero'] = Crypt::encryptString($value);
    }

    /**
     * Get the decrypted value of the "numero_cuenta" attribute.
     *
     * @param  string  $value
     * @return string
     */

    public function getNumeroAttribute($value)
    {
       return Crypt::decryptString($value);
    }
    public function setCvcAttribute($value)
    {
        $this->attributes['cvc'] = Crypt::encryptString($value);
    }
    public function getCvcAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}
