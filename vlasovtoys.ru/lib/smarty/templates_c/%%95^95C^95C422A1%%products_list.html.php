<?php /* Smarty version 2.6.11, created on 2014-08-31 14:39:47
         compiled from /home/simpleuser/data/www/vlasovtoys.ru/modules/shop/front/templates/products_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'format_price', '/home/simpleuser/data/www/vlasovtoys.ru/modules/shop/front/templates/products_list.html', 16, false),)), $this); ?>
<?php if ($this->_tpl_vars['products_list']): ?>
					
					<?php $_from = $this->_tpl_vars['products_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foreach1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foreach1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product']):
        $this->_foreach['foreach1']['iteration']++;
?>
						<?php if ($this->_foreach['foreach1']['iteration'] == 1): ?><tr><?php endif; ?>
						
						<td>
						
						
            	<a class="gallery1" href="/uploaded_files/shop_images/800-<?php echo $this->_tpl_vars['product']['image']; ?>
.<?php echo $this->_tpl_vars['product']['ext']; ?>
" title="<?php echo $this->_tpl_vars['product']['name']; ?>
"><?php echo $this->_tpl_vars['product']['name']; ?>
</a>
            	<br>
            	<a  class="gallery1" href="/uploaded_files/shop_images/800-<?php echo $this->_tpl_vars['product']['image']; ?>
.<?php echo $this->_tpl_vars['product']['ext']; ?>
" title="<?php echo $this->_tpl_vars['product']['name']; ?>
">
            		<img src="/uploaded_files/shop_images/resized-<?php echo $this->_tpl_vars['product']['image']; ?>
.<?php echo $this->_tpl_vars['product']['ext']; ?>
" width="132" height="174" alt="<?php echo $this->_tpl_vars['product']['name']; ?>
"></a>
            		<br><?php echo $this->_tpl_vars['product']['price2']; ?>
<br>
            		<div class="price">
            			<?php if (! empty ( $this->_tpl_vars['product']['price_sale'] )): ?>
            				<span class="oldprice"><?php echo ((is_array($_tmp=$this->_tpl_vars['product']['price'])) ? $this->_run_mod_handler('format_price', true, $_tmp) : smarty_modifier_format_price($_tmp)); ?>
</span> - <?php echo ((is_array($_tmp=$this->_tpl_vars['product']['price_sale'])) ? $this->_run_mod_handler('format_price', true, $_tmp) : smarty_modifier_format_price($_tmp)); ?>
&nbsp;
            			<?php else: ?>
            				<?php echo ((is_array($_tmp=$this->_tpl_vars['product']['price'])) ? $this->_run_mod_handler('format_price', true, $_tmp) : smarty_modifier_format_price($_tmp)); ?>

            			<?php endif; ?>
            			<span class="pricer">руб.</span>
            		</div>
            		<input type="text" name="price<?php echo $this->_tpl_vars['product']['id']; ?>
" class="itemsquantity" value="1" /><button class="catbutton" product_id="<?php echo $this->_tpl_vars['product']['id']; ?>
" count="1">В корзину</button>
						
						</td>
						
				  		<?php if ($this->_foreach['foreach1']['iteration']%4 == 0 && $this->_foreach['foreach1']['iteration'] > 1 && ! ($this->_foreach['foreach1']['iteration'] == $this->_foreach['foreach1']['total'])): ?>
				  			</tr><tr>
				  		<?php elseif (($this->_foreach['foreach1']['iteration'] == $this->_foreach['foreach1']['total'])): ?>
				  			</tr>
				  		<?php endif; ?>
						
					<?php endforeach; endif; unset($_from); ?>
					
<?php endif; ?>










