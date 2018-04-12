<?php /* Smarty version 2.6.11, created on 2015-12-15 12:10:07
         compiled from /var/www/alex/data/www/scl.mosharov.com//templates/404.html */ ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Ошибка 404. Страница не найдена.</title>
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

<div style="position:absolute; z-index:90; border:1px solid #541B6E; background:#FFF; display:none;" id="ImageLayout"></div>

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
    <td class="rightt">наши менеджеры:<br><span class="rightcod">963</span><span class="rightnum"> 641-84-40</span><br><span class="rightcod">916</span><span class="rightnum"> 287-03-29</span></td>
  </tr>
  <tr>
    <td colspan="4" class="banner">
    <img src="<?php echo $this->_tpl_vars['template_image']; ?>
banner.jpg" width="1100" height="196" usemap="#Map"><br>
    <map name="Map">
    <area shape="poly" coords="280,1,263,196,1,196,1,1" href="<?php echo @DOMAIN; ?>
catalog/boys/" alt="Одежда для мальчиков" title="Одежда для мальчиков">
    <area shape="poly" coords="283,1,557,1,540,196,265,196" href="<?php echo @DOMAIN; ?>
catalog/girls/" alt="Одежда для девочек" title="Одежда для девочек">
    <area shape="poly" coords="561,1,834,1,819,196,543,196" href="<?php echo @DOMAIN; ?>
catalog/new_born/" alt="Одежда для новорожденных" title="Одежда для новорожденных">
    <area shape="poly" coords="1100,196,1100,1,837,1,822,196" href="<?php echo @DOMAIN; ?>
catalog/bedding/" alt="Постельные и банные принадлежности" title="Постельные и банные принадлежности">
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
    
    <center>Запрашиваемая страница не найдена</center>
    
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