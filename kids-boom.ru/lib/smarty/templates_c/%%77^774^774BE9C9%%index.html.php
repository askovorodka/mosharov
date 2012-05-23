<?php /* Smarty version 2.6.11, created on 2012-05-22 12:09:05
         compiled from index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'fetch', 'index.html', 46, false),array('function', 'eval', 'index.html', 48, false),)), $this); ?>
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
<link rel="icon" type="image/png" href="<?php echo $this->_tpl_vars['template_image']; ?>
favicon.png">
</head>
<body>
<table class="mtbl" align="center">
  <tr>
    <td class="logo"><a href="/"><img src="<?php echo $this->_tpl_vars['template_image']; ?>
logo.jpg" width="213" height="72"></a></td>
    <td class="tmenu">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."top_menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </td>
    <td class="rightt">наши менеджеры:<br><span class="rightcod">495</span><span class="rightnum"> 641-68-50</span><br><span class="rightcod">963</span><span class="rightnum"> 641-84-40</span></td>
  </tr>
  <tr>
    <td colspan="4" class="banner">
    <img src="<?php echo $this->_tpl_vars['template_image']; ?>
banner.jpg" width="1100" height="196" usemap="#Map"><br>
    <map name="Map">
    <area shape="poly" coords="280,1,263,196,1,196,1,1" href="#" alt="Одежда для мальчиков" title="Одежда для мальчиков">
    <area shape="poly" coords="283,1,557,1,540,196,265,196" href="#" alt="Одежда для девочек" title="Одежда для девочек">
    <area shape="poly" coords="561,1,834,1,819,196,543,196" href="#" alt="Одежда для новорожденных" title="Одежда для новорожденных">
    <area shape="poly" coords="1100,196,1100,1,837,1,822,196" href="#" alt="Постельные и банные принадлежности" title="Постельные и банные принадлежности">
    </map>
    </td>
  </tr>
  <tr>
    <td class="lmenu"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."left_catalog_menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
    <td class="cont">
    
    <?php if ($this->_tpl_vars['current_url'] == 'home'): ?>
    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."top_search.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."top_special_block.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
    
    <?php if ($this->_tpl_vars['content'] == '' || ! $this->_tpl_vars['content']): ?>
	<?php $this->assign('content', ""); ?>
	<?php echo smarty_function_fetch(array('file' => $this->_tpl_vars['template'],'assign' => 'content'), $this);?>

	<?php endif; ?>
	<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['content']), $this);?>

    
    </td>
    
    <td class="rside"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."basket_block.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
    
  </tr>
  <tr>
    <td colspan="4" class="bottom"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."footer_block.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </td>
  </tr>
</table>
</body>
</html>