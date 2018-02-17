<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'email',
        'password',
        'userable_id',
        'userable_type'
    ];

    protected $guarded = [];

    protected $hidden = [
        'password',
        'userable_id'
    ];

    public function userable()
    {
        return $this->morphTo();
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this->save();
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this->save();
    }

    public function getSchedule($day, $isOdd)
    {
        $parity = $isOdd ? 1 : 2;
        $lessons = $this->userable->getLessons($day, $parity);

        return $lessons;
    }
}
