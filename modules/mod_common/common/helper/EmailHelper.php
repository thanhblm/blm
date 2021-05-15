<?php
namespace common\helper;
class EmailHelper{
	public static function isValidEmailMx($email) {
		list ( $user, $domain ) = split ( '@', $email );
		return checkdnsrr ( $domain, 'MX' );
	}
	public static function isValidEmailAcc($email) {
		$verifyEmail = new VerifyEmail ();
		$verifyEmail->Debug = TRUE;
		$verifyEmail->Debugoutput = 'html';
		return $verifyEmail->check ( $email );
	}
}