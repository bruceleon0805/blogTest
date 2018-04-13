<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**邮箱验证回调
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verify($token)
    {
        $user = User::where('confirmation_token',$token)->first();  //验证带回的token 值是否和数据库中的一样
        if (is_null($user)){
            // TODO 增添提示
            flash(trans('verify fail'),'danger');

            return redirect('/');  //跳转
        }

        $user->is_active = 1;
        $user->confirmation_token = str_random(40);
        $user->save();
        Auth::login($user); //登陆操作
        flash(trans('verify success'),'success');
        return redirect('/home'); //跳转
    }


}
