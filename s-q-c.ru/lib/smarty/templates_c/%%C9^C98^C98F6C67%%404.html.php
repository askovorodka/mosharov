<?php /* Smarty version 2.6.11, created on 2016-02-26 20:12:10
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//templates/404.html */ ?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">
  <title>404 Error</title>
  <meta name="Keywords" content="<?php echo $this->_tpl_vars['meta_keywords']; ?>
">
  <meta name="Description" content="<?php echo $this->_tpl_vars['meta_description']; ?>
">
  <link href="/templates/css/styles.css" rel="stylesheet">
  <!--[if lt IE 9]>
  <script src="/templates/js/libs/html5shiv.min.js"></script>
  <script src="/templates/js/libs/respond.min.js"></script>
  <![endif]-->
</head>
<body>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."blocks/top_auth.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."blocks/top_header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="container">

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."blocks/top_search.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  <?php if ($this->_tpl_vars['current_url'] != 'home'): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."blocks/breadcrumbs.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['current_url'] == 'home'): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."blocks/banners.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>

  <center>Error 404. Page not found</center>


</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."blocks/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script src="/templates/js/libs/jquery.min.js"></script>
<script src="/templates/js/scripts.js"></script>
</body>
</html>