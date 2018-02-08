<?php /* Smarty version 2.6.11, created on 2011-07-26 16:58:27
         compiled from /home/alex/data/www/demo.mosharov.com/modules/shop/front/templates/products_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'format_price', '/home/alex/data/www/demo.mosharov.com/modules/shop/front/templates/products_list.html', 12, false),)), $this); ?>
<?php if ($this->_tpl_vars['products_list']): ?>
					<table class="catalog" cellspacing="0" cellpadding="0" align="center">
					
					<?php $_from = $this->_tpl_vars['products_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foreach1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foreach1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product']):
        $this->_foreach['foreach1']['iteration']++;
?>
						<?php if ($this->_foreach['foreach1']['iteration'] == 1): ?><tr><?php endif; ?>
						<td><a class="gallery1" href="/uploaded_files/shop_images/big-<?php echo $this->_tpl_vars['product']['image']; ?>
.<?php echo $this->_tpl_vars['product']['ext']; ?>
" title="<?php echo $this->_tpl_vars['product']['name']; ?>
"><?php echo $this->_tpl_vars['product']['name']; ?>
</a>
							<br><div><a class="gallery2" href="/uploaded_files/shop_images/big-<?php echo $this->_tpl_vars['product']['image']; ?>
.<?php echo $this->_tpl_vars['product']['ext']; ?>
" title="<?php echo $this->_tpl_vars['product']['name']; ?>
"><?php if ($this->_tpl_vars['product']['image']): ?><img src="/uploaded_files/shop_images/resized-<?php echo $this->_tpl_vars['product']['image']; ?>
.<?php echo $this->_tpl_vars['product']['ext']; ?>
"><?php else: ?>нет фото<?php endif; ?></a></div>
							<br><?php echo $this->_tpl_vars['product']['price2']; ?>
<br>
							<table id="prs" cellspacing="0" cellpadding="0" align="center">
							<tr height="24">
								<td id="pricep"><img src="<?php echo $this->_tpl_vars['template_image']; ?>
p_left.jpg" width="9" height="24"><br></td>
								<td id="price"><?php echo ((is_array($_tmp=$this->_tpl_vars['product']['price'])) ? $this->_run_mod_handler('format_price', true, $_tmp) : smarty_modifier_format_price($_tmp)); ?>
&nbsp;<span id="pricer">руб.</span></td>
								<td id="pricep"><img src="<?php echo $this->_tpl_vars['template_image']; ?>
p_right.jpg" width="9" height="24"><br></td>
							</tr>
							</table>
						</td>
						
				  		<?php if ($this->_foreach['foreach1']['iteration']%5 == 0 && $this->_foreach['foreach1']['iteration'] > 1 && ! ($this->_foreach['foreach1']['iteration'] == $this->_foreach['foreach1']['total'])): ?>
				  			</tr><tr>
				  		<?php elseif (($this->_foreach['foreach1']['iteration'] == $this->_foreach['foreach1']['total'])): ?>
				  			</tr>
				  		<?php endif; ?>
						
					<?php endforeach; endif; unset($_from); ?>
					
					</table>
<?php endif; ?>