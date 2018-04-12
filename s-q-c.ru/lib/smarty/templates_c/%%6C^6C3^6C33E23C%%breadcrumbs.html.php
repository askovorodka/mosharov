<?php /* Smarty version 2.6.11, created on 2015-12-05 18:13:59
         compiled from /var/www/sqc/conf/../templates/blocks/breadcrumbs.html */ ?>
<div class="breadcrumbs">
    <?php if ($this->_tpl_vars['current_url'] != $this->_tpl_vars['default_url']): ?>
    <?php $_from = $this->_tpl_vars['navigation']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['nav_loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['nav']):
        $this->_foreach['nav_loop']['iteration']++;
?>
    <?php if (($this->_foreach['nav_loop']['iteration'] == $this->_foreach['nav_loop']['total']) && $this->_foreach['nav_loop']['iteration'] == 1):  echo $this->_tpl_vars['nav']['title']; ?>

    <?php elseif (($this->_foreach['nav_loop']['iteration'] == $this->_foreach['nav_loop']['total']) && $this->_foreach['nav_loop']['iteration'] > 1): ?>
    <span class="g-text-light-gray breadcrumbs_arrow">?</span> <?php echo $this->_tpl_vars['nav']['title']; ?>

    <?php else: ?>
    <?php if (! ($this->_foreach['nav_loop']['iteration'] <= 1)): ?> <span class="g-text-light-gray breadcrumbs_arrow">?</span> <?php endif; ?>
    <a href="<?php echo $this->_tpl_vars['nav']['url']; ?>
"><?php echo $this->_tpl_vars['nav']['title']; ?>
</a><?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php else: ?>
    <?php echo $this->_tpl_vars['page_content']['name']; ?>

    <?php endif; ?>
</div>