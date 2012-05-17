<?php

class Mail {
	function send_mail($mail_address,$mail_from,$subject,$msg,$attach_file,$type,$send_type,$encoding)
	{
	
		$headers = "From: $mail_from\n";
		$headers .= "Reply-To: $mail_from\n";
		$headers .= "Return-Path: $mail_from\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "X-Mailer: Fastweb\n";
		$headers .= "Content-Type: multipart/mixed; boundary=MailBoundary\n";
	
		if($type=="text") {
			$message="--MailBoundary\n";
			$message.="Content-Type: text/plain;charset=$encoding\n";
			$message.="Content-Transfer-Encoding: quoted-printable\n\n";
	
			$message.=$msg."\n\n";
		}
		else {
			$message="--MailBoundary\n";
			$message.="Content-Type: text/html;charset=$encoding\n";
			$message.="Content-Transfer-Encoding: base64\n\n";
	
			$message.=chunk_split(base64_encode($msg))."\n\n";
		}
	
		if(!empty($attach_file)) {
			foreach($attach_file as $attach_file) {
				$file_name=$attach_file;
				$attach_file="uploads/".$attach_file;
				$message.= "--MailBoundary\n";
				$message.="Content-Type: application/octetstream; name=$file_name\n";
				$message.="Content-Transfer-Encoding: base64\n";
				$message.="Content-Disposition: attachment; filename=$file_name\n\n";
	
				$file=fopen ($attach_file, "r");
				$content=fread($file,filesize($attach_file));
				fclose ($file);
				$encoded_file=chunk_split(base64_encode($content));
				$message.=$encoded_file."\n\n";
			}
		}
		$message.="--MailBoundary--\n";
	
		if ($send_type=="standard") {
			if (!mail($mail_address,$subject,$message,$headers)) {return false;}
			else {return true;}
		}
		if ($send_type=="sendmail") {
			//socket
			$socket = "/usr/sbin/sendmail -t -f $mail_from"; 
	
			if (!$fd = popen($socket,"w")) {return false;}
			fputs($fd, "To: $mail_address\n");
			fputs($fd, $headers);
			fputs($fd, "Subject: $subject\n");
			fputs($fd, $message); 
			pclose($fd);
		}
	
	}
}


?>