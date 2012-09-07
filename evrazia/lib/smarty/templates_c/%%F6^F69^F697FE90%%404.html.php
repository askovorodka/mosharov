<?php /* Smarty version 2.6.11, created on 2012-02-06 13:09:35
         compiled from /home/alex/data/www/shop-toy.mosharov.com/templates/404.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/home/alex/data/www/shop-toy.mosharov.com/templates/404.html', 43, false),array('modifier', 'strip_tags', '/home/alex/data/www/shop-toy.mosharov.com/templates/404.html', 44, false),)), $this); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Странице не найдена</title>
<meta name="Keywords" content="<?php echo $this->_tpl_vars['meta_keywords']; ?>
">
<meta name="Description" content="<?php echo $this->_tpl_vars['meta_description']; ?>
">
<?php $_from = $this->_tpl_vars['css']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['css']):
?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['css']; ?>
">
<?php endforeach; endif; unset($_from); ?>

<?php $_from = $this->_tpl_vars['js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['js']):
?>
<script src="<?php echo $this->_tpl_vars['js']; ?>
" type="text/javascript"></script>
<?php endforeach; endif; unset($_from); ?>

</head>
<body>
<table class="mtbl" cellspacing="0" cellpadding="0">
  <tr height="234">
    <td width="271"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
"><img src="<?php echo $this->_tpl_vars['template_image']; ?>
logo.png" width="271" height="234"></a></td>
    <td colspan="2" class="rtbg"><div class="toptel" align="center"><?php echo @PHONE1; ?>
<br><?php echo @PHONE2; ?>
</div></td>
  </tr>
  <tr height="36">
    <td colspan="3" class="gline"><?php echo @HEADER_TITLE; ?>
</td>
  </tr>
  <tr height="100%">
    <td class="leftside">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../templates/left_menu_block.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<br><br>
	<center><div class="bann"><br><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/insertfiles/price_list_2011_3k.xls">Скачать прайс-лист<br> с нашей продукцией</a></div></center>
	<img src="<?php echo $this->_tpl_vars['template_image']; ?>
clear.png" width="271" height="1"><br>
	</td>
    <td class="txt">
    
		<center>Запрашиваемая вами страница не найдена.</center>    
    
	</td>
	
    <td class="rightside"><img src="<?php echo $this->_tpl_vars['template_image']; ?>
clear.png" width="231" height="1"><br>
    
	<a href="<?php echo $this->_tpl_vars['base_url']; ?>
/news/" id="news">Новости и акции</a><br><br>
	
	<?php $_from = $this->_tpl_vars['news_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['news'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['news']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['news']):
        $this->_foreach['news']['iteration']++;
?>
		<span class="ndate"><?php echo ((is_array($_tmp=$this->_tpl_vars['news']['publish_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</span><br>
		<a href="<?php echo $this->_tpl_vars['base_url']; ?>
/news/archive/<?php echo $this->_tpl_vars['news']['id']; ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['news']['title'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</a><br><br>
	<?php endforeach; endif; unset($_from); ?>
	
	</td>
  </tr>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../templates/footer_block.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</table>
</body>
</html>