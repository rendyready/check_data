<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @property int $id
 * @property int $users_id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $waroeng_id
 * @property string|null $waroeng_akses
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property Carbon|null $verified
 * @property string $users_status_sync
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $table = 'users';

    protected $primaryKey = 'users_id';

    public $incrementing = false;

    protected $casts = [
        'email_verified_at' => 'datetime',
        'waroeng_id' => 'int',
        'waroeng_akses' => 'binary',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_by' => 'int',
        'verified' => 'datetime',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
		'users_id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'waroeng_id',
        'waroeng_akses',
        'created_by',
        'updated_by',
        'deleted_by',
        'verified',
        'users_status_sync',
    ];
    public function hasVerifiedAccount()
    {
        return $this->verified;
    }
}
