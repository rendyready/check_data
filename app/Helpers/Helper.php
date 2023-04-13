<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;
use Illuminate\Encryption\Encrypter;


Class Helper
{
    public static function customCrypt($vWord){
        $jangkrikKey = base64_decode("CccMZ15qMHXk47PEnC/lCk3Woq2rpjmxahQIFUZ3tMI=");
        $newEncrypter = new Encrypter($jangkrikKey,Config::get('app.cipher'));
        return $newEncrypter->encrypt($vWord);
    }
    
    public static function customDecrypt($vWord){
        $jangkrikKey = base64_decode("CccMZ15qMHXk47PEnC/lCk3Woq2rpjmxahQIFUZ3tMI=");
        $newEncrypter = new Encrypter($jangkrikKey,Config::get('app.cipher') );
        return $newEncrypter->decrypt($vWord);
    }
}