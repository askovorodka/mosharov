<?php /* Smarty version 2.6.11, created on 2018-04-05 12:47:20
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/shop/front/templates/shop.catalog_json.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip_tags', '/home/a0031953/domains/s-q-c.ru/public_html//modules/shop/front/templates/shop.catalog_json.html', 16, false),)), $this); ?>
<?php if (! empty ( $this->_tpl_vars['products_list'] )): ?>
    <?php $_from = $this->_tpl_vars['products_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <div class="catalog__item" id="catalog__item-<?php echo $this->_tpl_vars['item']['id']; ?>
">
        <?php if ($this->_tpl_vars['item']['image']): ?>
        <a href="<?php echo $this->_tpl_vars['base_url']; ?>
/<?php echo $this->_tpl_vars['item']['full_url']; ?>
/" class="catalog__item_pic<?php if ($this->_tpl_vars['item']['sale']): ?> sale<?php endif; ?>"><img src="/uploaded_files/shop_images/small-<?php echo $this->_tpl_vars['item']['image']; ?>
.<?php echo $this->_tpl_vars['item']['ext']; ?>
" /></a>
        <?php endif; ?>
        <div class="catalog__item__info">
            <div class="catalog__item__info_plus">
                <div class="catalog__item__info_plus_sizes">
                    <?php if (! empty ( $this->_tpl_vars['item']['sizes'] )): ?>
                    <?php $_from = $this->_tpl_vars['item']['sizes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['size']):
?>
                    <div class="size size--small"><?php echo $this->_tpl_vars['size']['value']; ?>
</div>
                    <?php endforeach; endif; unset($_from); ?>
                    <?php endif; ?>
                </div>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>

            </div>
            <span class="catalog__item__info_price"><?php echo $this->_tpl_vars['item']['price']; ?>
 руб.</span>
            <div data-product_id="<?php echo $this->_tpl_vars['item']['id']; ?>
" class="catalog__item__info_button form_button form_button--middle form_button--yellow-light">на потом</div>
        </div>
    </div>
    <?php endforeach; endif; unset($_from);  endif; ?>