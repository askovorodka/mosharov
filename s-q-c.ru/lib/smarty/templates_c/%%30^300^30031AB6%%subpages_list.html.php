<?php /* Smarty version 2.6.11, created on 2015-12-05 18:06:43
         compiled from /var/www/sqc//modules/page/front/templates/subpages_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', '/var/www/sqc//modules/page/front/templates/subpages_list.html', 4, false),)), $this); ?>
<?php if (count ( $this->_tpl_vars['subpages_list'] ) > 0): ?>
            <ul>
				<?php $_from = $this->_tpl_vars['subpages_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['for1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['for1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['page']):
        $this->_foreach['for1']['iteration']++;
?>            
              		<li><a href="<?php echo $this->_tpl_vars['page']['full_url']; ?>
" class="black"><?php echo ((is_array($_tmp=$this->_tpl_vars['page']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : smarty_modifier_stripslashes($_tmp)); ?>
</a></li>
              	<?php endforeach; endif; unset($_from); ?>
              </ul>
<?php endif; ?>