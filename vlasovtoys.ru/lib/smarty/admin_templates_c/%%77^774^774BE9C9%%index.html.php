<?php /* Smarty version 2.6.11, created on 2014-07-30 11:05:57
         compiled from index.html */ ?>
<html>
<head>
<title>Администраторская панель</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="templates/style.css">
</head>

<SCRIPT language=JavaScript>

var js_base_url = "<?php echo $this->_tpl_vars['base_url']; ?>
";

<?php echo '
function show_menu(name,image)
{
if(document.getElementById(name).style.display!="none") {
		document.getElementById(name).style.display="none";
	}
	else {
		document.getElementById(name).style.display="";
	}
}

</SCRIPT>
<script src="';  echo $this->_tpl_vars['base_url'];  echo '/javascript/common.js"></script>
<script src="';  echo $this->_tpl_vars['base_url'];  echo '/javascript/jquery-1.5.min.js"></script>
<SCRIPT language=JavaScript type="text/javascript" src="';  echo $this->_tpl_vars['base_url'];  echo '/javascript/stroka.js"></SCRIPT>
'; ?>

<script src="<?php echo $this->_tpl_vars['base_url']; ?>
/javascript/insert_text/insert_text_<?php echo $this->_tpl_vars['browser']; ?>
.js"></script>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
	<tr>
		<td height="170" width="100%" bgcolor="#4384C5" background="#3396D7" class="repeatx" valign="top">
			<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
				<tr>
					<td width="259" rowspan="2" valign="top" style="padding: 13px 0px 0px 40px"></td>
					<td align="right" style="padding: 0px 20px 0px 10px" height="90">
						<table cellpadding="0" cellspacing="0" border="0" width="400">
							<tr>
								<td style="border-bottom: 1px solid #83B8E7" height="50">
									<table width="100%" height="50" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td>
												<table cellpadding="0" cellspacing="0" border="0" width="95%">
													<tr>
														<td width="25"><img src="templates/img/li1.gif" width="25" height="25" alt="Пользователь в системе"></td>
														<td bgcolor="#69A0E2"><b class="white" style="margin: 8px"><?php echo $this->_tpl_vars['user_login']; ?>
 (<?php echo $this->_tpl_vars['user_priv']; ?>
)</b></td>
														<td width="12"><img src="templates/img/li2.gif" width="12" height="25" alt=""></td>
													</tr>
												</table>
											</td>
											<td style="background: url(templates/img/li3.gif) no-repeat 0px 6px" align="right" width="100">
												<table cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td bgcolor="#69A0E2"><a href="login.php?action=logout" class="white">Выход</a></td>
														<td><img src="templates/img/li2.gif" width="12" height="25" alt=""></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td align="right" height="30"><img src="templates/img/li4.gif" width="13" height="13" hspace="5" align="absmiddle" alt="Перейти к справочному руководству"><a href="http://fastweb.ru/?cms_help" class="white" target="_blank">Помощь</a>&nbsp;&nbsp;&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="bottom">
					<?php if ($this->_tpl_vars['rss_news']['title']): ?>
						<div class="info_box">
							<div class="info_header"><?php echo $this->_tpl_vars['rss_news']['title']; ?>
</div>
							<div class="info_body">
								<?php echo $this->_tpl_vars['rss_news']['description']; ?>

							</div>
						</div>
					<?php endif; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="border-bottom: 40px solid #FFFFFF">
			<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
				<tr bgcolor="#E2EFEE">
					<td height="41" width="230" style="border-top: 1px solid #FFFFFF; border-bottom: 11px solid #FFFFFF; padding: 0px 8px 0px 8px" align="center"><b>Доступные модули</b></td>
					<td style="border-top: 1px solid #FFFFFF; border-bottom: 11px solid #FFFFFF;" class="menu">
						<img src="templates/img/li5.gif" width="14" height="14" hspace="5" align="absmiddle" alt="Путь">
						<?php $_from = $this->_tpl_vars['navigation']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['nav_loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['nav']):
        $this->_foreach['nav_loop']['iteration']++;
?>
						<?php $this->assign('temp', $this->_tpl_vars['nav']['title']); ?>
							  <?php $this->assign('ntitle', $this->_tpl_vars['temp']); ?>
						      <?php if (($this->_foreach['nav_loop']['iteration'] == $this->_foreach['nav_loop']['total'])): ?>
						      <?php if (! ($this->_foreach['nav_loop']['iteration'] <= 1)): ?>/<?php endif; ?> <?php echo $this->_tpl_vars['ntitle']; ?>

						      <?php else: ?>
						        <?php if (! ($this->_foreach['nav_loop']['iteration'] <= 1)): ?>/<?php endif; ?> <a href="<?php echo $this->_tpl_vars['nav']['url']; ?>
" class=menu><?php echo $this->_tpl_vars['ntitle']; ?>
</a>
						      <?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</td>
				</tr>
				<tr>
					<td width="250" height="100%" style="border-right: 1px solid #3C68D9" valign="top">
						<table width="250" cellpadding="0" cellspacing="0" border="0" >
						<?php $_from = $this->_tpl_vars['main_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
							<tr>
								<td class="left_img_act"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
/modules/<?php echo $this->_tpl_vars['entry']['name']; ?>
/admin/ico.gif" alt="<?php echo $this->_tpl_vars['entry']['title']; ?>
"></td>
								<td class="left_menu_act" width="190"><a href="javascript:show_menu('<?php echo $this->_tpl_vars['entry']['name']; ?>
','image_<?php echo $this->_tpl_vars['entry']['name']; ?>
');" class="menu"><?php echo $this->_tpl_vars['entry']['title']; ?>
</a></td>
							</tr>
							<?php if ($this->_tpl_vars['entry']['sub']): ?>
							<tr id=<?php echo $this->_tpl_vars['entry']['name']; ?>
 <?php if ($this->_tpl_vars['current_module'] != $this->_tpl_vars['entry']['name']): ?>style="display: none;"<?php endif; ?>>
								<td colspan="2" class="mini">
									<div class="left_pod">
										<?php $_from = $this->_tpl_vars['entry']['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sub']):
?>
											<div class=submenu><img src=templates/img/li5.gif> <a href="<?php echo $this->_tpl_vars['sub']['link']; ?>
" class="podmenu"><?php echo $this->_tpl_vars['sub']['name']; ?>
</a></div>
										<?php endforeach; endif; unset($_from); ?>
									</div>
								</td>
							</tr>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
						</table>
					</td>
					<td valign="top" style="padding: 5px;">
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="100" background="#3396D7" align="right">
		</td>
	</tr>
	<tr>
		<td height="24" style="border-top: 1px solid #3396D7; border-bottom: 1px solid #3396D7" bgcolor="#3C68D9" align="right" >&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
</table>
</body>
</html>