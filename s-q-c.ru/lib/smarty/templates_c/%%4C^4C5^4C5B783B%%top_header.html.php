<?php /* Smarty version 2.6.11, created on 2015-12-05 16:54:14
         compiled from /var/www/sqc/conf/../templates/blocks/top_header.html */ ?>
<header class="header">
    <div class="container">
        <a href="/" class="header__logo" title="Style Quality Comfort - Стиль, Качество, Комфорт"></a>
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
            <a href="/catalog/basket/" class="header__cart__holder" title="Перейти в корзину">
                <div class="icon icon-shopping-cart"></div>
                У вас <span id="basket_number" class="orange"><?php echo $this->_tpl_vars['basket_number']; ?>
</span> товаров на <span id="basket_currency" class="orange"><?php echo $this->_tpl_vars['basket_total']; ?>
</span> руб.
            </a>
        </div>
    </div>
</header>