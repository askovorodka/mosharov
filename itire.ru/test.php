<?php
if(isset($_POST['submit']) && $_POST['submit']) {
	        $title = substr(htmlspecialchars(trim($_POST['title'])), 0, 1000);
		        $mess =  substr(htmlspecialchars(trim($_POST['mess'])), 0, 1000000);
		        //$to = 'fly@me.ispvds.com';
		        $to = 'alex@mosharov.com';
			        if (mail($to, $title, $mess, "Content-Type: text/html; charset=windows-1251")) echo "mail sent :)<br><a target=_blank href=\"http://mailinator.com/maildir.jsp?email=isptest\">link to watch</a>"; else echo "mail not sent :(";
}
?>
<form action="" method=post>
subj <input type="text" name="title" size="40"><br>
<textarea name="mess" rows="10" cols="40"></textarea><br>
<input type="submit" name="submit">
</form>
