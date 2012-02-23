<?php
/********************************************
*                                           *
* Name    : MyEmail                         *
* Modifier: Windy2000                        *
* Time    : 2011-12-26                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT PLEASE HOLD THIS ITEM.      *
*                                           *
********************************************/

/*
How to use:
	$mail = new MyEmail();
	$mail->init($from, $charset, $log_file);
	$mail->setFrom("from@mailserver.com", "name");
	$mail->setSubject("mail subject");
	$mail->setContent("mail content", true);
	$mail->addEmail("anymail@server.com", "recipient name", "to");
	$mail->addEmail("anymail1@server.com", "recipient name", "cc");
	$mail->addFile($file_at_server, $filename, $filetype, $embed);
	$mail->addHeader("Disposition-Notification-To", "anymail@server.com");
	$mail->send(array("mode"=>"smtp", "host"=>"mailserver", "port"=>25, "user"=>"username", "password"=>"pswd"), true);
	  or
	$mail->send(array("mode"=>"ssl", "host"=>"smtp.gmail.com", "port"=>465, "user"=>"username@gmail.com", "password"=>"password"));
*/

Class MyEmail extends class_common {
	private
		$isHtml = true,
		$charset = "UTF-8",
		$from = "",
		$to = array(),
		$reply = array(),
		$cc = array(),
		$bcc = array(),
		$headers = "",
		$subject = "",
		$body = "",
		$content = "",
		$files = array(),
		$file_count = 0,
		$boundary = array(),
		$log_fp = null;
	
	public function init($from="", $charset="UTF-8", $log_file="") {
		if(!empty($from)) $this->setFrom($from);
		if(!empty($charset)) $this->charset = $charset;
		if(!empty($log_file)) $this->log_fp = @fopen($log_file, "wb");
		$boundary_str = "mystep_".Chop("b".md5(uniqid(time())))."_mystep";
		$this->boundary["body"] = "===Body_".$boundary_str."===";
		$this->boundary["attach"] = "===Attach_".$boundary_str."===";
		$this->boundary["embed"] = "===Embed_".$boundary_str."===";
	}
	
	public function setSubject($subject) {
		$subject = str_replace("\r", '', $subject);
		$subject = str_replace("\n", '', $subject);
		$subject = trim($subject);
		$this->subject = "=?".$this->charset."?b?".base64_encode($subject)."?=";
		return;
	}
	
	public function setFrom($email, $name="", $auto=true) {
		$email = trim($email);
		if(!preg_match('/^[\w\-\.]+@(([\w\-]+)[.])+[a-z]{2,4}$/i', $email)) return false;
		$name = trim(preg_replace('/[\r\n]+/', '', $name));
		if (empty($name)) {
			$this->from = $email;
		} else {
			$name = "=?".$this->charset."?b?".base64_encode($name)."?=";
			$this->from = $name . " <" . $email . ">";
		}
		ini_set('sendmail_from', $email);
		if ($auto) {
			$this->addEmail($email, $name, "reply");
		}
		return true;
	}
	
	public function setContent($content, $isHtml=true, $body_alt="") {
		$this->body = "";
		$boundary = $this->boundary["body"];
		$this->isHtml = $isHtml;
		if($isHtml) {
			$this->body = "
--{$boundary}
Content-Type: text/plain; charset=\"".$this->charset."\"
Content-Transfer-Encoding: base64

";
			if(empty($body_alt)) $body_alt = chunk_split(base64_encode(trim(strip_tags(preg_replace('/<(head|title|style|script)[^>]*>.*?<\/\\1>/s', '', str_replace("&#160;", "  ", str_replace("&nbsp;", " ", $content)))))));
			if(trim($body_alt)=="") $body_alt = chunk_split(base64_encode("This mail is created by MyEmail(windy2006@gmail.com). \n\nTo view this email message, open it in a program that understands HTML!"));
			$this->body .= $body_alt."\n";
			$this->content = $content;
			$this->body .= "
--{$boundary}
Content-Type: text/html; charset=\"".$this->charset."\"
Content-Transfer-Encoding: base64

<!--content-->
";
		} else {
			$content = chunk_split(base64_encode($content));
			$this->body = "
--{$boundary}
Content-Type: text/plain; charset=\"".$this->charset."\"
Content-Transfer-Encoding: base64

{$content}
";
		}
		$this->body .= "\n--{$boundary}--\n\n";
		$this->body = str_replace("\r", "", $this->body);
		return;
	}
	
	public function addEmail($email, $name="", $type="to") {
		if (!preg_match('/^(to|cc|bcc|reply)$/', $type)) return false;
		$email = trim($email);
		$name = trim(preg_replace('/[\r\n]+/', '', $name));
		if(!preg_match('/^[\w\-\.]+@(([\w\-]+)[.])+[a-z]{2,4}$/i', $email)) return false;
		$name = "=?".$this->charset."?b?".base64_encode($name)."?=";
		array_push($this->$type, array($email, $name));
		return true;
	}
	
	public function addHeader($name, $value) {
		$name = str_replace("\r", '', $name);
		$name = str_replace("\n", '', $name);
		$name = trim($name);
		$value = str_replace("\r", '', $value);
		$value = str_replace("\n", '', $value);
		$value = trim($value);
		$this->headers[] = $name . ': ' . $value;
		return true;
	}

	public function addAttachment($filecontent, $filename = "", $filetype = "application/octet-stream", $embed = false) {
		$this->file_count++;
		if($filename=="") {
			$filename = "attachment_".$this->file_count;
		}
		if(!$embed){
			$this->files["attach"][] = array(
																			"type" => $filetype,
																			"content" => $filecontent,
																			"name" => $filename,
																		);
		}else{
			$this->files["embed"][] = array(
																			"type" => $filetype,
																			"content" => $filecontent,
																			"name" => $filename,
																		); 		
		}
		return;
	}

	public function addFile($file, $filename="", $filetype = "application/octet-stream", $embed=false) {
		$filecontent = file_get_contents($file);
		if(empty($filename)) $filename = basename($file);
		$this->addAttachment($filecontent, $filename, $filetype, $embed);
	}

	public function send($para=array(), $single=false, $priority=3, $extHeader = "") {
		if($this->from=='') $this->from = ini_get('sendmail_from');
		$this->addHeader("Return-Path", $this->from);
		$mail_list = array_merge($this->to, $this->cc, $this->bcc);
		if($single==false) {
			if(count($this->to)>0) $this->addHeader("To", implode(', ', $this->formatEmail($this->to)));
			if(count($this->cc)>0) $this->addHeader("Cc", implode(', ', $this->formatEmail($this->cc)));
			if(count($this->bcc)>0) $this->addHeader("Bcc", implode(', ', $this->formatEmail($this->bcc)));
		}
		$this->addHeader("From", $this->from);
		if(count($this->reply)>0) $this->addHeader("Reply-To", implode(', ', $this->formatEmail($this->reply)));
		$this->addHeader("Subject", $this->subject);
		$this->addHeader("Message-ID",  sprintf("<%s@%s>", md5(uniqid(time())), $_SERVER["HTTP_HOST"]));
		if(!preg_match("/[1-5]/", $priority)) $priority = 3;
		$this->addHeader("X-Priority", $priority);
		$this->addHeader("X-Mailer", "MyStep_CMS");
		$this->addHeader("MIME-Version", "1.0");
		
		$mail_content = implode("\r\n", $this->headers)."\r\n";
		if(!empty($extHeader)) $mail_content .= $extHeader."\r\n";
		$mail_content .= $this->buildMail();
		$info = "";

		if(!empty($para['mode'])) {
			require("class.smtp.php");
			$smtp = new SMTP();
			if(!$smtp->Connect((($para['mode']=="ssl" || $para['mode']=="ssl/tls")?"ssl://":"").$para['host'], $para['port'], 10)) {
				$this->Error("Cannot connect to the mail server!");
				return false;
			}
			if(!$smtp->Hello($_SERVER["HTTP_HOST"])) {
				$this->Error("Cannot send messege to the mail server!");
				return false;
			}
			if($para['mode']=="tls" || $para['mode']=="ssl/tls") {
				if(!$smtp->StartTLS()) {
					$this->Error("TLS error!");
					return false;
				}
				$smtp->Hello($_SERVER["HTTP_HOST"]);
			}
			if(isset($para['user'])) {
				if(!$smtp->Authenticate($para['user'], $para['password'])) {
					$this->Error("Authenticate Failed!");
					return false;
				}
			}
	    if(!$smtp->Mail(ini_get('sendmail_from'))) {
	      $this->Error("Bad sender email");
				return false;
	    }

			for($i=0,$m=count($mail_list); $i<$m; $i++) {
				if($smtp->Recipient($mail_list[$i][0])) {
					$info = " sended!";
				} else {
					$info = " error!";
				}
				if($this->log_fp) fwrite($this->log_fp, $mail_list[$i][0].$info."\n");
			}
			if(!$smtp->Data($mail_content)) {
				$this->Error("Mail send Failed!");
			}
			$smtp->Reset();
			if($smtp->Connected()) {
				$smtp->Quit();
				$smtp->Close();
			}
		} else {
			for($i=0,$m=count($mail_list); $i<$m; $i++) {
				if(!@mail(formatEmail($mail_list[$i]), $this->subject, "", $mail_content)) {
					$info = " sended!";
				} else {
					$info = " error!";
				}
				if($this->log_fp) fwrite($this->log_fp, $mail_list[$i][0].$info."\n");
			}
		}
		if($this->log_fp) fclose($this->log_fp);
		return;
	}

	public function setFile($file, $embed = false) {
		$content = $file["content"];
		$content = chunk_split(base64_encode($content));
		$return = "Content-Type: ".$file["type"].";\n";
		$return .= "    name = \"".$file["name"]."\"\n";
		$return .= "Content-Transfer-Encoding: base64\n";
		if($embed){
			$cid="__".$file["name"]."@mystep__";
			$return .= "Content-ID: <$cid>\n\n";
			$this->content=str_replace($file["name"], "cid:".$cid, $this->content);
		}else{
			$return .= "Content-Disposition: attachment;\n filename=\"".$file["name"]."\"\n\n";
		}
		$return .= $content."\n";
		return $return;
	}

	public function buildMail() {
		$multipart = "Content-Type: multipart/mixed;
  boundary = \"".$this->boundary["attach"]."\"

  This is a multi-part message in MIME format created by Windy2000(windy2006@gmail.com).

--".$this->boundary["attach"]."
Content-Type: multipart/related;
      boundary=\"".$this->boundary["embed"]."\";
      type=\"multipart/alternative\"

--".$this->boundary["embed"]."
Content-Type: multipart/alternative;
      boundary=\"".$this->boundary["body"]."\"


		";
		if(!$this->isHtml) {
			$this->files["attach"] += $this->files["embed"];
			$this->files["embed"] = array();
		}
		$attachmentCount = count($this->files["attach"]);
		$attachmentContent = "";
		$embedCount = count($this->files["embed"]);
		$embedContent = "";
		
		if($attachmentCount!=0) {
			for($i = $attachmentCount-1;$i>=0;$i--){
				$attachmentContent .= "\n--".$this->boundary["attach"]."\n".$this->setFile($this->files["attach"][$i],false);
			}
			$attachmentContent .= "\n--".$this->boundary["attach"]."--\n";
		}

		if($embedCount!=0) {
			for($i = $embedCount-1;$i>=0;$i--){
				$embedContent .= "\n--".$this->boundary["embed"]."\n".$this->setFile($this->files["embed"][$i],true);
			}
			$embedContent .= "\n--".$this->boundary["embed"]."--\n";
		}
		$this->body = str_replace("<!--content-->", chunk_split(base64_encode($this->content)), $this->body);
		$multipart.= $this->body;
		$multipart.= $embedContent;
		$multipart.= $attachmentContent;
		$multipart = rtrim($multipart);
		return $multipart;
	}
	
	public function formatEmail($email_list) {
		if(!is_array($email_list[0])) {
			$result = "";
			if(empty($email_list[1])) {
				$result = $email_list[0];
			} else {
				$result = '"' . $email_list[1] . '" <'. $email_list[0] . '>';
			}
		} else {
			$result = array();
			foreach($email_list as $email) {
				if (empty($email[1])) {
					$result[] = $email[0];
				} else {
					$result[] = '"' . $email[1] . '" <' . $email[0] . '>';
				}
			}
		}
		return $result;
	}
}
?>