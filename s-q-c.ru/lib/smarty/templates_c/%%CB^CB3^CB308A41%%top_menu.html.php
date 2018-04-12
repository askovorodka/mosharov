<?php /* Smarty version 2.6.11, created on 2016-01-31 04:33:10
         compiled from /var/www/alex/data/www/scl.mosharov.com/conf/../templates/top_menu.html */ ?>
<?php $_from = $this->_tpl_vars['main_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menu']):
?>
	<a title="<?php echo $this->_tpl_vars['menu']['name']; ?>
" href="<?php echo $this->_tpl_vars['base_url']; ?>
/<?php echo $this->_tpl_vars['menu']['url']; ?>
/"><?php echo $this->_tpl_vars['menu']['name']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>