<?php /* Smarty version 2.6.11, created on 2017-04-22 02:49:44
         compiled from /home/a0031953/domains/s-q-c.ru/public_html/conf/../templates/blocks/top_header.html */ ?>
<header class="header">
    <div class="container">
        <a href="/" class="header__logo" title="Style Quality Comfort - �����, ��������, �������"></a>
        <nav class="header__menu">
            <?php $_from = $this->_tpl_vars['shop_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menu']):
?>
                <a href="<?php echo $this->_tpl_vars['base_url']; ?>
/catalog/<?php echo $this->_tpl_vars['menu']['url']; ?>
/" title="<?php echo $this->_tpl_vars['menu']['name']; ?>
" class="header__menu-link"><?php echo $this->_tpl_vars['menu']['name']; ?>
</a>
            <?php endforeach; endif; unset($_from); ?>
        </nav>
        <div class="header__cart basket">
            <a href="/catalog/basket/" class="header__cart__holder" title="������� � �������">
                <div class="icon icon-shopping-cart"></div>
                � ��� <span id="basket_number" class="orange"><?php echo $this->_tpl_vars['basket_number']; ?>
</span> ������� �� <span id="basket_currency" class="orange"><?php echo $this->_tpl_vars['basket_total']; ?>
</span> ���.
            </a>
        </div>
    </div>
</header>