<?php /* Smarty version 2.6.11, created on 2016-02-26 19:54:15
         compiled from /home/a0031953/domains/s-q-c.ru/public_html/conf/../templates/left_catalog_menu.html */ ?>
	<?php $_from = $this->_tpl_vars['shop_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['for1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['for1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['category']):
        $this->_foreach['for1']['iteration']++;
?>
		<?php $this->assign('counter', ($this->_tpl_vars['counter']+1)); ?>
		<?php if ($this->_tpl_vars['counter'] % 4 == 0):  $this->assign('counter', 1);  endif; ?>
		<ul class="menu<?php echo $this->_tpl_vars['counter']; ?>
"><a title="<?php echo $this->_tpl_vars['category']['name']; ?>
" href="<?php echo $this->_tpl_vars['base_url']; ?>
/<?php echo $this->_tpl_vars['category']['full_url']; ?>
/"><?php echo $this->_tpl_vars['category']['name']; ?>
</a>
		<?php $_from = $this->_tpl_vars['category']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
			<li><a title="<?php echo $this->_tpl_vars['child']['name']; ?>
" href="<?php echo $this->_tpl_vars['base_url']; ?>
/<?php echo $this->_tpl_vars['child']['full_url']; ?>
/"><?php echo $this->_tpl_vars['child']['name']; ?>
</a></li>
		<?php endforeach; endif; unset($_from); ?>
		</ul>
	<?php endforeach; endif; unset($_from); ?>
    <img src="<?php echo $this->_tpl_vars['template_image']; ?>
clear.gif" width="275" height="1">