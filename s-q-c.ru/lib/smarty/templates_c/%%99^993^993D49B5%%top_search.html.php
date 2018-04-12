<?php /* Smarty version 2.6.11, created on 2015-12-05 18:36:08
         compiled from /var/www/sqc/conf/../templates/top_search.html */ ?>
<form action="<?php echo $this->_tpl_vars['base_url']; ?>
/catalog/" method="get">
<input style="float:left;" type="text" class="search" name="search_product" value='<?php echo $this->_tpl_vars['keyword']; ?>
'>
<input type="image" src="<?php echo $this->_tpl_vars['template_image']; ?>
search_button.jpg" value="Поиск" class="searchb"><br></form>