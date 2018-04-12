<?php /* Smarty version 2.6.11, created on 2016-02-29 18:43:58
         compiled from ../../modules/banners/admin/templates/banners.a_edit_banner_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'str_repeat', '../../modules/banners/admin/templates/banners.a_edit_banner_list.html', 4, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['urlslist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cl'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cl']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['cat']):
        $this->_foreach['cl']['iteration']++;
?>
	<div>
		<input class="checkbox_tree" type="checkbox" name="edit_banners_cat[]" value="<?php echo $this->_tpl_vars['cat']['full_url']; ?>
" id="id_<?php echo $this->_tpl_vars['cat']['url']; ?>
_<?php echo $this->_foreach['cl']['iteration']; ?>
" <?php if (in_array ( $this->_tpl_vars['cat']['full_url'] , $this->_tpl_vars['cat_checked'] )): ?>checked<?php endif; ?>>
		<label for="id_<?php echo $this->_tpl_vars['cat']['url']; ?>
_<?php echo $this->_foreach['cl']['iteration']; ?>
"><?php echo smarty_function_str_repeat(array('str' => "&nbsp;",'num' => $this->_tpl_vars['cat']['param_level'],'mod' => '4'), $this);?>
<img src=templates/img/tree.gif><?php echo $this->_tpl_vars['cat']['name']; ?>
</label>
		<?php if ($this->_tpl_vars['cat']['sublist']): ?>
			<?php $this->assign('urlslist', $this->_tpl_vars['cat']['sublist']); ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../modules/banners/admin/templates/banners.a_edit_banner_list.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php $this->assign('fullurl', $this->_tpl_vars['_tmp_parent_url']); ?>
		<?php endif; ?>
	</div>
<?php endforeach; endif; unset($_from); ?>