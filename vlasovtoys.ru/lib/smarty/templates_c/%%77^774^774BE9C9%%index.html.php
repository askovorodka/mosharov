<?php /* Smarty version 2.6.11, created on 2011-07-28 15:37:23
         compiled from index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'fetch', 'index.html', 51, false),array('function', 'eval', 'index.html', 53, false),)), $this); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title><?php echo $this->_tpl_vars['page_title']; ?>
</title>
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
<table class="mtbl" cellspacing="0" cellpadding="0" align="center">
  <tr height="253">
  	<td colspan="3" id="toper"><img src="<?php echo $this->_tpl_vars['template_image']; ?>
main.png" width="549" height="253"><div><img src="<?php echo $this->_tpl_vars['template_image']; ?>
t_font.png" width="250" height="118" id="bearbot"><div></td>
  </tr>
  <tr>
    <td id="tlt"></td>
    <td id="tt">
    <!---- ZAKLADKI ---->
    <table class="zaklt" cellspacing="0" cellpadding="0" align="left">
      <tr>

      <?php $_from = $this->_tpl_vars['main_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menu']):
?>
			<td id="<?php if ($this->_tpl_vars['current_url'] == $this->_tpl_vars['menu']['url']): ?>ils<?php else: ?>nls<?php endif; ?>">&nbsp;</td>
			<td id="<?php if ($this->_tpl_vars['current_url'] == $this->_tpl_vars['menu']['url']): ?>ilnk<?php else: ?>nlnk<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/<?php if ($this->_tpl_vars['menu']['url'] != 'home'):  echo $this->_tpl_vars['menu']['url']; ?>
/<?php endif; ?>" title="<?php echo $this->_tpl_vars['menu']['name']; ?>
"><?php echo $this->_tpl_vars['menu']['name']; ?>
</a></td>
			<td id="<?php if ($this->_tpl_vars['current_url'] == $this->_tpl_vars['menu']['url']): ?>irs<?php else: ?>nrs<?php endif; ?>">&nbsp;</td>
      <?php endforeach; endif; unset($_from); ?>

      <?php $_from = $this->_tpl_vars['shop_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['shop']):
?>
        <td id="<?php if ($this->_tpl_vars['cat_content']['id'] == $this->_tpl_vars['shop']['id']): ?>ils<?php else: ?>nls<?php endif; ?>">&nbsp;</td>
        <td id="<?php if ($this->_tpl_vars['cat_content']['id'] == $this->_tpl_vars['shop']['id']): ?>ilnk<?php else: ?>nlnk<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/catalog/<?php echo $this->_tpl_vars['shop']['url']; ?>
/" title="<?php echo $this->_tpl_vars['shop']['name']; ?>
"><?php echo $this->_tpl_vars['shop']['name']; ?>
</a></td>
        <td id="<?php if ($this->_tpl_vars['cat_content']['id'] == $this->_tpl_vars['shop']['id']): ?>irs<?php else: ?>nrs<?php endif; ?>">&nbsp;</td>
      <?php endforeach; endif; unset($_from); ?>

      </tr>
    </table>
    <!---- ZAKLADKI ---->
    </td>
    <td id="trt"></td>
  </tr>
  <tr height="100%">
    <td id="tl"></td>
    <td id="tblinn">

		<?php if ($this->_tpl_vars['content'] == '' || ! $this->_tpl_vars['content']): ?>
			<?php $this->assign('content', ""); ?>
			<?php echo smarty_function_fetch(array('file' => $this->_tpl_vars['template'],'assign' => 'content'), $this);?>

		<?php endif; ?>
		<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['content']), $this);?>


    </td>
    <td id="tr"></td>
  </tr>
  <tr>
    <td id="tlb"></td>
    <td id="tb">&nbsp;</td>
    <td id="trb"></td>
  </tr>
  <tr height="100">
  	<td colspan="3" id="bottom"><a href="mailto:vlasov641@yandex.ru" title="vlasov641@yandex.ru"><img src="<?php echo $this->_tpl_vars['template_image']; ?>
email.png" width="377" height="66" alt="vlasov641@yandex.ru" id="bmail"></a></td>
  </tr>
</table>
</body>
</html>