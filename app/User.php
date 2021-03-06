<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'username', 'password',
                           'usergroup_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    /*
     * user belongs to usergroup
     */
    public function usergroup()
    {
        return $this->belongsTo('\App\Usergroup');
    }

    /**
     * Generate User Associate Array
     *
     * @return Array
     */
    static public function all_select() {
        $_ret = array();

        $_ret[''] = '-- user --';

        $users = \App\User::orderBy('username')->get();

        foreach ($users as $user) {
            $_ret[$user->id] = $user->username;
        }

        return $_ret;
    }

//    /**
//     * user belongs to many roles
//     */
//    public function roles() {
//        return $this->belongsToMany('\App\Role', 'roles');
//    }
}
