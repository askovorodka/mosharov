<?php /* Smarty version 2.6.11, created on 2014-07-28 17:21:32
         compiled from catalog.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'fetch', 'catalog.html', 33, false),array('function', 'eval', 'catalog.html', 35, false),)), $this); ?>
<!DOCTYPE html>
<html lang="ru">
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
?ver=<?php echo @TEMPLATE_VERSION; ?>
">
<?php endforeach; endif; unset($_from);  $_from = $this->_tpl_vars['js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['js']):
?>
<script src="<?php echo $this->_tpl_vars['js']; ?>
?ver=<?php echo @TEMPLATE_VERSION; ?>
" type="text/javascript"></script>
<?php endforeach; endif; unset($_from); ?>

</head>
<body>
     
     <div id='loading-layer' style='position: absolute; display:none; width:200px;height:50px;background:#ffda49;padding:10px 10px 15px 10px;text-align:center;border:1px solid #5e005e; z-index:90;'>
           <div style="font-weight:bold; color: #5e005e; background: url(/templates/img/progress.gif) 50% 100% no-repeat; height: 50px">
                 Кладем в корзину
           </div>
     </div>

<table class="mtbl">
  <tr height="100%">
    <td id="tblinn">
       <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../templates/basket_block.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
       <div class="mihail"></div>
       
       
		<?php if ($this->_tpl_vars['content'] == '' || ! $this->_tpl_vars['content']): ?>
			<?php $this->assign('content', ""); ?>
			<?php echo smarty_function_fetch(array('file' => $this->_tpl_vars['template'],'assign' => 'content'), $this);?>

		<?php endif; ?>
		<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['content']), $this);?>

       
       
        <ul class="sidemenu">
	      <?php $_from = $this->_tpl_vars['main_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menu']):
?>
	      		<li><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/<?php if ($this->_tpl_vars['menu']['url'] != 'home'):  echo $this->_tpl_vars['menu']['url']; ?>
/<?php endif; ?>" title="<?php echo $this->_tpl_vars['menu']['name']; ?>
"><?php echo $this->_tpl_vars['menu']['name']; ?>
</a></li>
	      <?php endforeach; endif; unset($_from); ?>
	      <?php $_from = $this->_tpl_vars['shop_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['shop']):
?>
	      		<li><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/catalog/<?php echo $this->_tpl_vars['shop']['url']; ?>
/" title="<?php echo $this->_tpl_vars['shop']['name']; ?>
"><?php echo $this->_tpl_vars['shop']['name']; ?>
</a></li>
	      <?php endforeach; endif; unset($_from); ?>
       </ul>
       
    </td>
  </tr>
  <tr height="100">
  	<td colspan="3" class="bottom"><a href="mailto:vlasovtoys@yandex.ru" title="vlasovtoys@yandex.ru"><img src="<?php echo $this->_tpl_vars['template_image']; ?>
email.png" alt="vlasovtoys@yandex.ru" id="bmail"></a></td>
  </tr>
</table>
</body>
</html>