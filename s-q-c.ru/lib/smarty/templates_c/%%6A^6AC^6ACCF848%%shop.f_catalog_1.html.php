<?php /* Smarty version 2.6.11, created on 2016-01-18 16:23:42
         compiled from /var/www/alex/data/www/scl.mosharov.com//modules/shop/front/templates/shop.f_catalog_1.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip_tags', '/var/www/alex/data/www/scl.mosharov.com//modules/shop/front/templates/shop.f_catalog_1.html', 20, false),)), $this); ?>
<?php if (empty ( $this->_tpl_vars['nofilter'] )): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TPL_SHOP_PATH)."top_filter.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<div class="catalog">
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
					<div class="catalog__item__info_button form_button form_button--middle form_button--yellow-light">на потом</div>
				</div>
			</div>
		<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
</div>

<div class="text">
	<h2><?php echo ((is_array($_tmp=$this->_tpl_vars['cat_content']['name'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</h2>
	<?php echo $this->_tpl_vars['cat_content']['text']; ?>

</div>

    