<?php /* Smarty version 2.6.11, created on 2012-02-07 16:33:01
         compiled from index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'fetch', 'index.html', 49, false),array('function', 'eval', 'index.html', 51, false),)), $this); ?>
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
<?php endforeach; endif; unset($_from);  $_from = $this->_tpl_vars['js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['js']):
?>
<script src="<?php echo $this->_tpl_vars['js']; ?>
" type="text/javascript"></script>
<?php endforeach; endif; unset($_from); ?>
</head>

<div id='loading-layer'><div>Кладем в корзину. Подождите...</div></div>

<body>
<!--- toping --->
<div class="topd">
	
	<div class="topt"><div class="toptel"><span class="kod">+7 (495)</span> 648-73-68</div><div class="littler">режим работы:  9:00 - 21:00  без выходных</div></div>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."basket_block.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <div class="tmenu">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../templates/top_menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>

</div>
<!--- /toping --->
<!--- search --->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../templates/top_search.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--- /search --->

<!--- special --->
<?php if ($this->_tpl_vars['current_url'] == 'home'):  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../templates/top_special_block.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif; ?>
<!--- /special --->

<!--- middle --->
<table class="middle">
<tr>
<td class="lmenu">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../templates/left_catalog_menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</td>
<td class="righter">
		
		<?php if ($this->_tpl_vars['content'] == '' || ! $this->_tpl_vars['content']): ?>
			<?php $this->assign('content', ""); ?>
			<?php echo smarty_function_fetch(array('file' => $this->_tpl_vars['template'],'assign' => 'content'), $this);?>

		<?php endif; ?>
		<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['content']), $this);?>


</td>
</tr>
</table>
<!--- /middle --->
<!--- bottom --->
<div class="bottom"><br><br>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../templates/top_menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</div>
<!--- /bottom --->
</body>
</html>





