<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    use HasFactory;

    /**
     * Conexión a utilizar
     *
     * @var string
     */
    protected $connection = 'EV_SUMAPP';

    /**
     * Nombre de la tabla a utilizar.
     *
     * @var string
     */
    protected $table = 'password_resets';

    /**
     * Llave primaria a utilizar.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'token'
    ];
}
