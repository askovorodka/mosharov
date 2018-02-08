<?php /* Smarty version 2.6.11, created on 2014-07-23 17:42:21
         compiled from ../templates/left_menu_block.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urlencode', '../templates/left_menu_block.html', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['main_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['main_menu'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['main_menu']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['main_menu']['iteration']++;
?>
	<a href="<?php echo $this->_tpl_vars['base_url']; ?>
/<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['url'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : smarty_modifier_urlencode($_tmp)); ?>
/" class="llink<?php if ($this->_tpl_vars['node_content']['id'] == $this->_tpl_vars['item']['id']): ?> active<?php endif; ?>"><?php echo $this->_tpl_vars['item']['name']; ?>
</a>
	<?php if ($this->_tpl_vars['item']['id'] == 302): ?>
		<div class="llinks">
			<?php $_from = $this->_tpl_vars['shop_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['shop_menu'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['shop_menu']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item1']):
        $this->_foreach['shop_menu']['iteration']++;
?>
				<a <?php if ($this->_tpl_vars['cat_content']['id'] == $this->_tpl_vars['item1']['id']): ?>style="text-decoration:underline;"<?php endif; ?> href="<?php echo $this->_tpl_vars['base_url']; ?>
/<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['url'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : smarty_modifier_urlencode($_tmp)); ?>
/<?php echo $this->_tpl_vars['item1']['url']; ?>
/"><?php echo $this->_tpl_vars['item1']['name']; ?>
</a><br>
			<?php endforeach; endif; unset($_from); ?>
		</div>
	<?php endif;  endforeach; endif; unset($_from); ?>
<a href="http://forum.domofon.ru/" class="llink">Форум</a>