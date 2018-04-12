<?php /* Smarty version 2.6.11, created on 2015-12-05 18:39:31
         compiled from /var/www/sqc/conf/../templates/blocks/top_search.html */ ?>
<div class="tools">
    <div class="tools__search">
        <form action="<?php echo $this->_tpl_vars['base_url']; ?>
/catalog/" method="get">
            <div class="icon-search tools__search__icon"></div>
            <input type="text" name="search_product" placeholder="»щу по артикулу и названию" value="<?php echo $this->_tpl_vars['keyword']; ?>
"/>
        </form>
    </div>
    <div class="tools__second-menu">
        <?php $_from = $this->_tpl_vars['main_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menu']):
?>
            <a href="<?php echo $this->_tpl_vars['base_url']; ?>
/<?php echo $this->_tpl_vars['menu']['url']; ?>
/" <?php if ($this->_tpl_vars['current_url'] == $this->_tpl_vars['menu']['url']): ?>class="tools__second-menu__wishlist"<?php endif; ?> title="<?php echo $this->_tpl_vars['menu']['name']; ?>
"><?php echo $this->_tpl_vars['menu']['name']; ?>
</a>
        <?php endforeach; endif; unset($_from); ?>
    </div>
</div>