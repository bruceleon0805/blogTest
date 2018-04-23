<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Naux\Mail\SendCloudTemplate;
use Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        // 模板变量
        $data = [
            'url' =>url('password/reset',$token)
        ];
        $template = new SendCloudTemplate('zhihu_app_register', $data);

        Mail::raw($template, function ($message) {
            $message->from('2503348792@qq.com', 'Laravel');

            $message->to($this->email);
        });


    }
}
