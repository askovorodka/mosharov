<?php /* Smarty version 2.6.11, created on 2012-02-06 13:10:21
         compiled from login.html */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Вход в систему</title>
<meta http-equiv="Content-type" content="text/html; charset=windows-1251">
<?php echo '
<style type="text/css">
body,div {
	font-size: 9pt;
	font-family: Verdana;
	color: #3399CC;
}
input {
	height: 20px;
	font-size: 9pt;
	font-weight: bold;
	font-family: Verdana;
	color: #3399CC;
}
button {
	border: none;
	background: none;
	cursor: pointer;
}
INPUT.btn{
border:none;
background:background-color:#FFFFFF;
cursor:hand;
cursor:pointer;
}
</style>
'; ?>

</head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
	<tr>
		<td align="center" valign="middle">
			<form method="post" action="">
				<input type="hidden" name="submit_login_form" value="">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="399" height="190" valign="top">
							<div style="margin-left: 80px; margin-top: 70px">
								<div style="margin-bottom: 10px; margin-left: -20px; margin-right: 90px" align="center">
									<div style="margin-bottom: 5px"><b>Идентифицируйте себя</b></div>
									<font size="-2" color="#FF0000">
										<b>
											<?php if ($this->_tpl_vars['login_message']):  echo $this->_tpl_vars['login_message'];  else: ?><br><?php endif; ?>
										</b>
									</font>
								</div>
								<div style="margin-bottom: 7px"><input type="text" name="login" style="width: 200px" value="<?php echo $this->_tpl_vars['temp_login']; ?>
"></div>
								<div><input type="password" name="password" style="width: 200px"></div>
							</div>
						</td>
					</tr>
					<tr>
						<td width="399" height="100" align="center" valign="top">
							<input type="submit" value="войти" class="btn"></div>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>
</body>
</html>