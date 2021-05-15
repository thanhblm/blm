<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\EmailTemplateLangExtendVo;
use core\database\SqlStatementInfo;

class EmailTemplateLangExtendMapping {
	public function getLangsByTemplateId(EmailTemplateLangExtendVo $filter){
		try {
			$query = "SELECT l.code, l.name, l.flag, r.* FROM language l 
					LEFT JOIN
						(SELECT * FROM email_template_lang
					    WHERE email_template_id = #{emailTemplateId}
					    ) r ON r.language_code = l.code
					ORDER BY l.name ASC";
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $query, EmailTemplateLangExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getEmailTemplateLangById(EmailTemplateLangExtendVo $filter){
		try {
			$query = "SELECT l.code, l.name, l.flag, r.* FROM language l
					LEFT JOIN
						(SELECT * FROM email_template_lang
					    WHERE email_template_id = #{emailTemplateId}
					    ) r ON r.language_code = l.code
					WHERE r.language_code = #{languageCode}
					LIMIT 1";
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $query, EmailTemplateLangExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getEmailTemplate2Send(EmailTemplateLangExtendVo $filter){
		try {
			$query = "SELECT 
				    l.code, 
				    l.name, 
				    l.flag, 
				    if (trim(r.title)='' OR r.title IS NULL, e.title, r.title) AS `title`,
				    if (trim(r.title)='' OR r.subject IS NULL, e.subject, r.subject) AS `subject`,
				    if (trim(r.title)='' OR r.body IS NULL, e.body, r.body) AS `body`,
				    if (trim(r.title)='' OR r.from IS NULL, e.from, r.from) AS `from`,
				    if (trim(r.title)='' OR r.reply IS NULL, e.reply, r.reply) AS `reply`,
				    if (trim(r.title)='' OR r.cc IS NULL, e.cc, r.cc) AS `cc`,
				    if (trim(r.title)='' OR r.bcc IS NULL, e.bcc, r.bcc) AS `bcc`
				FROM
				    language l
				        LEFT JOIN
				    (SELECT 
				        *
				    FROM
				        email_template_lang
				    WHERE
				        email_template_id = #{emailTemplateId}) r ON r.language_code = l.code
				        LEFT JOIN
					email_template AS e ON e.id = r.email_template_id
				WHERE
				    r.language_code = #{languageCode}
				LIMIT 1";
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $query, EmailTemplateLangExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}
}