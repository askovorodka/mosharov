<?php /* Smarty version 2.6.11, created on 2012-02-06 17:46:58
         compiled from ../templates/left_catalog_menu.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip_tags', '../templates/left_catalog_menu.html', 5, false),)), $this); ?>
<div class="lmenubody">
	<?php $_from = $this->_tpl_vars['shop_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categor']):
?>
		<div class="lmenuc<?php if ($this->_tpl_vars['cat_content']['id'] == $this->_tpl_vars['categor']['id'] || $this->_tpl_vars['cat_parent_info']['id'] == $this->_tpl_vars['categor']['id']): ?>o<?php endif; ?>">
		<img src="/uploaded_files/shop_images/<?php echo $this->_tpl_vars['categor']['image']; ?>
">
		<a title="<?php echo $this->_tpl_vars['categor']['name']; ?>
" href="<?php echo $this->_tpl_vars['base_url']; ?>
/<?php echo $this->_tpl_vars['categor']['full_url']; ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['categor']['name'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</a>
		<?php if ($this->_tpl_vars['cat_content']['id'] == $this->_tpl_vars['categor']['id'] || $this->_tpl_vars['cat_parent_info']['id'] == $this->_tpl_vars['categor']['id']): ?>
			<div class="lmenucos">
			<?php $_from = $this->_tpl_vars['categor']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
				<div><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/<?php echo $this->_tpl_vars['child']['full_url']; ?>
/"<?php if ($this->_tpl_vars['cat_content']['id'] == $this->_tpl_vars['child']['id']): ?> style="font-weight:bold;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['child']['name'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</a></div>
			<?php endforeach; endif; unset($_from); ?>
			</div>
		<?php endif; ?>		
		</div>
	<?php endforeach; endif; unset($_from); ?>
</div>