<?php /* Smarty version 2.6.11, created on 2016-04-28 14:52:35
         compiled from index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'fetch', 'index.html', 36, false),array('function', 'eval', 'index.html', 38, false),)), $this); ?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.png" type="image/x-icon">
    <title><?php echo $this->_tpl_vars['page_title']; ?>
</title>
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

  
  <?php if ($this->_tpl_vars['content'] == '' || ! $this->_tpl_vars['content']): ?>
  <?php $this->assign('content', ""); ?>
  <?php echo smarty_function_fetch(array('file' => $this->_tpl_vars['template'],'assign' => 'content'), $this);?>

  <?php endif; ?>
  <?php echo smarty_function_eval(array('var' => $this->_tpl_vars['content']), $this);?>



</div>

<script src="/templates/js/libs/jquery.min.js"></script>
<script src="/templates/js/scripts.js"></script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_PATH)."blocks/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter36614000 = new Ya.Metrika({
                    id:36614000,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/36614000" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- BEGIN JIVOSITE CODE -->
<script type=\'text/javascript\'>
(function(){ var widget_id = \'I2c1yQANsb\'; var s = document.createElement(\'script\'); s.type = \'text/javascript\'; s.async = true; s.src = \'//code.jivosite.com/script/widget/\'+widget_id; var ss = document.getElementsByTagName(\'script\')[0]; ss.parentNode.insertBefore(s, ss);})();
</script>
<!-- END JIVOSITE CODE -->
'; ?>

</body>
</html>