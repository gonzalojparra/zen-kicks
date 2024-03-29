<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Team;
use App\Models\Graduacion;
use Illuminate\Http\Request;


use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'apellido', 'email', 'password',
        'fecha_nac', 'id_escuela', 'gal', 'du',
        'clasificacion', 'id_graduacion', 'id_categoria', 'genero', 'rolRequerido'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function team()
    {
        return $this->hasOne(Team::class, 'id', 'id_escuela');
    }
    public function teamNombre()
    {
        return $this->belongsTo(Team::class, 'id_escuela');
    }
    public function getNombreEscuela()
    {
        return $this->team->name;
    }

    public function graduacion()
    {
        return $this->belongsTo(Graduacion::class, 'id_graduacion');
    }
    public function graduacionNombre()
    {
        return $this->belongsTo(Graduacion::class, 'id_graduacion');
    }
    public function getNombreGraduacion()
    {
        return $this->graduacion->nombre;
    }

    public function updatePerfil(Request $request, User $user)
    {
   
        if ($user->hasRole('Juez')) {
            $user->updateJuez($request->all());
        } else {
            $user->update($request->all());
        }
       
    }

}
