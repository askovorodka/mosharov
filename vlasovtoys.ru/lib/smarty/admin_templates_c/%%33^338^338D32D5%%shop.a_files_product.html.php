<?php /* Smarty version 2.6.11, created on 2011-07-26 12:55:42
         compiled from /home/alex/data/www/demo.mosharov.com/modules/shop/admin/templates/shop.a_files_product.html */ ?>
<?php if ($this->_tpl_vars['files_list']): ?>
	<?php $_from = $this->_tpl_vars['files_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['file']):
?>
		<tr>
		  <td class=td1_left style="border-bottom: none;"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/uploaded_files/shop_files/<?php echo $this->_tpl_vars['product']['id']; ?>
/<?php echo $this->_tpl_vars['file']['file']; ?>
"><?php echo $this->_tpl_vars['file']['title']; ?>
</a></td>
		  <td class=td1_right style="border-bottom: none;">
		  <input type=input name=edit_file_title[<?php echo $this->_tpl_vars['file']['id']; ?>
] class=field style="width:300px;" value="<?php echo $this->_tpl_vars['file']['title']; ?>
">
		  &nbsp;&nbsp;<input type="checkbox" name="del_file[<?php echo $this->_tpl_vars['file']['id']; ?>
]" id="delfile_<?php echo $this->_tpl_vars['file']['id']; ?>
">&nbsp;
		  <label for="delfile_<?php echo $this->_tpl_vars['file']['id']; ?>
">удалить</label></td>
		</tr>	
	<?php endforeach; endif; unset($_from);  endif; ?>


<tr>
  <td class=td1_left style="border-bottom: none;" colspan="2">
  <div id="files">
  	<div>
  		<input type="text" name="file_title[]" style="width:200px; margin-right:20px;">
  		<input type=file name="add_file[]" class=field >
		<a href="#" class="photos_more" onclick="return photos_more()" style="font-size:23px; font-weight:bold;">+</a>  		
  	</div>
  </div>	
  	<div id="photos_clone" style="display:none;clear:both; white-space:nowrap;">
  		<input type="text" name="file_title[]" style="width:200px; margin-right:20px;">
  		<input type=file name="add_file[]" class=field>
		<a href="#" class="photos_more" onclick="return photos_more()" style="font-size:23px; font-weight:bold;">+</a>  		
  	</div>
  	
  </td>
</tr>

<?php echo '
<script type="text/javascript" language="JavaScript"> 
	function photos_more()
	{
		$(\'#photos_clone > *\').clone().appendTo(\'#files\');
 
		rows = $(\'.photos_more\').size() - 2;
		$(\'.photos_remove:lt(\' + rows + \')\').show();
		$(\'.photos_more:lt(\' + rows + \')\').hide();
 
		return false;
	}
</script>
'; ?>