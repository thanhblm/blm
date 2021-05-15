<?php

namespace core\utils;

use common\helper\SettingHelper;
use common\persistence\base\dao\SendEmailTaskBaseDao;
use common\persistence\base\vo\SendEmailTaskVo;
use core\config\ApplicationConfig;

class EmailUtil {
	/**
	 * Send email with SMTP
	 *
	 * @param string $subject
	 *            required
	 * @param string $body
	 *            required
	 * @param mixed $toEmail
	 *            required
	 * @param mixed $cc
	 *            optional
	 * @param mixed $bcc
	 *            optional
	 * @param mixed $attachment
	 *            optional
	 *
	 * @return int send result
	 */
	public static function sendMail($subject, $body, $toEmail = array(), $cc = array(), $bcc = array(), $attachment = array(), $fromAddress = null, $fromName = null){
		if (AppUtil::isEmptyString($fromAddress)) {
			$fromAddress = ApplicationConfig::get("email.from.address");
		}
		$async = ApplicationConfig::get("email.send.async");
		if ($async) {
			self::insertToQueue("pending", $subject, $body, $toEmail, $cc, $bcc, $attachment, $fromName);
			return count($toEmail);
		} else {
			$host = !AppUtil::isEmptyString(SettingHelper::getSettingValue("Smtp Host")) ? SettingHelper::getSettingValue("Smtp Host") : ApplicationConfig::get('email.host');
			$port = !AppUtil::isEmptyString(SettingHelper::getSettingValue("Smtp Port")) ? SettingHelper::getSettingValue("Smtp Port") : ApplicationConfig::get('email.port');
			$authMode = !AppUtil::isEmptyString(SettingHelper::getSettingValue("Smtp Secure")) ? SettingHelper::getSettingValue("Smtp Secure") : ApplicationConfig::get('email.auth.mode');
			$username = !AppUtil::isEmptyString(SettingHelper::getSettingValue("Smtp User")) ? SettingHelper::getSettingValue("Smtp User") : ApplicationConfig::get('email.username');
			$password = !AppUtil::isEmptyString(SettingHelper::getSettingValue("Smtp Password")) ? SettingHelper::getSettingValue("Smtp Password") : ApplicationConfig::get('email.password');

			$devMail = ApplicationConfig::get('email.dev.mail');

			if (ApplicationConfig::get('production.mode') != 'production') {
				$subject .= " testing send to ";
				foreach ($toEmail as $email) {
					$subject .= "$email, ";
				}
			}

			$message = \Swift_Message::newInstance($subject);
			$message->setBody($body, 'text/html');
			$message->setFrom($fromAddress, $fromName);
			if (ApplicationConfig::get('production.mode') == 'production') {
				$message->setTo($toEmail);
			} else {
				$message->setTo($devMail);
			}
			if (isset ($cc)) {
				$message->setCc($cc);
			}
			if (isset ($bcc)) {
				$message->setBcc($bcc);
			}
			if (isset ($attachment)) {
				if (!is_array($attachment)) {
					$message->attach(\Swift_Attachment::fromPath($attachment));
				} else {
					foreach ($attachment as $key => $value) {
						if (!is_numeric($key)) {
							$message->attach(\Swift_Attachment::fromPath($key)->setFilename($value));
						} else {
							$message->attach(\Swift_Attachment::fromPath($value));
						}
					}
				}
			}
			if (!AppUtil::isEmptyString(SettingHelper::getSettingValue("Smtp Authenticate")) && SettingHelper::getSettingValue("Smtp Authenticate") == 'no') {
				$transport = \Swift_SmtpTransport::newInstance($host, $port)->setUsername($username)->setPassword($password);
			} else {
				$transport = \Swift_SmtpTransport::newInstance($host, $port, $authMode)->setUsername($username)->setPassword($password);
			}
			$mailer = \Swift_Mailer::newInstance($transport);
			$retVal = $mailer->send($message);
			self::insertToQueue("sent", $subject, $body, $toEmail, $cc, $bcc, $attachment, $fromName);
			return $retVal;
		}
	}

	private static function insertToQueue($status, $subject, $body, $toEmail = array(), $cc = array(), $bcc = array(), $attachment = array(), $fromName = null){
		// Create send email task info vo.
		$sendEmailTaskVo = new SendEmailTaskVo ();
		$sendEmailTaskVo->subject = $subject;
		$sendEmailTaskVo->body = $body;
		$sendEmailTaskVo->to = JsonUtil::encode($toEmail);
		$sendEmailTaskVo->cc = JsonUtil::encode($cc);
		$sendEmailTaskVo->bcc = JsonUtil::encode($bcc);
		$sendEmailTaskVo->attachments = JsonUtil::encode($attachment);
		$sendEmailTaskVo->fromName = $fromName;
		$sendEmailTaskVo->status = $status;
		// Add task to the queue.
		$sendEmailTaskDao = new SendEmailTaskBaseDao ();
		$sendEmailTaskDao->insertDynamic($sendEmailTaskVo);
	}
}