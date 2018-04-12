<?php /* Smarty version 2.6.11, created on 2016-01-19 17:00:50
         compiled from /var/www/alex/data/www/scl.mosharov.com/conf/../templates/top_search.html */ ?>
<form action="<?php echo $this->_tpl_vars['base_url']; ?>
/catalog/" method="get">
<input style="float:left;" type="text" class="search" name="search_product" value='<?php echo $this->_tpl_vars['keyword']; ?>
'>
<input type="image" src="<?php echo $this->_tpl_vars['template_image']; ?>
search_button.jpg" value="Поиск" class="searchb"><br>
</form>