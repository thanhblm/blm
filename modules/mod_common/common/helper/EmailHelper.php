<?php

namespace common\helper;
class EmailHelper
{
    public static function isValidEmailMx($email)
    {

        return true;
        /*list ($user, $domain) = split('@', $email);
        return checkdnsrr($domain, 'MX');*/
    }

    public static function isValidEmailAcc($email)
    {
        return true;
        /*$verifyEmail = new VerifyEmail ();
        $verifyEmail->Debug = TRUE;
        $verifyEmail->Debugoutput = 'html';
		return $verifyEmail->check ( $email );*/
    }
}