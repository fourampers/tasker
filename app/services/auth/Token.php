<?php


namespace App\Services\Auth;


class Token
{
    public static function generate() 
    {
        return Session::put(config('session.token'), md5(uniqid()));
    }
    
    public static function check($token) 
    {
        $tokenName = config('session.token');
        
        if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }
        
        return false;
    }
}