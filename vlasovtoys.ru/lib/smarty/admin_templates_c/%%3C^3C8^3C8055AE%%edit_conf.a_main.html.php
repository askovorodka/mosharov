<?php /* Smarty version 2.6.11, created on 2011-07-28 21:21:33
         compiled from /home/simpleuser/data/www/vlasovtoys.ru/modules/edit_conf/admin/templates/edit_conf.a_main.html */ ?>
<form action="" method=post>
<?php $this->assign('old_section', "");  $_from = $this->_tpl_vars['conf_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['conf_table'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['conf_table']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['conf']):
        $this->_foreach['conf_table']['iteration']++;
?>

<?php if ($this->_tpl_vars['conf']['section'] != $this->_tpl_vars['old_section']):  $this->assign('old_section', $this->_tpl_vars['conf']['section']);  if ($this->_foreach['conf_table']['iteration'] != 1): ?>
</table>
<?php endif; ?>
<br><br>
<b><?php echo $this->_tpl_vars['conf']['section_name']; ?>
</b>
<table width=100% cellspacing=1 cellpadding=3>
<?php endif; ?>

<tr>
<td width=25%><?php echo $this->_tpl_vars['conf']['name']; ?>
:</td>
<td>
  <?php if ($this->_tpl_vars['conf']['conf_key'] == 'CURRENCY_ADMIN' || $this->_tpl_vars['conf']['conf_key'] == 'CURRENCY_SITE' || $this->_tpl_vars['conf']['conf_key'] == 'CURRENCY_SITE2'): ?>
    <?php if (count ( $this->_tpl_vars['cur_list'] ) > 0): ?>
      <select name='<?php echo $this->_tpl_vars['conf']['conf_key']; ?>
' class=field style="width:50%;">
        <?php $_from = $this->_tpl_vars['cur_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
          <option <?php if ($this->_tpl_vars['conf']['conf_value'] == $this->_tpl_vars['item']['id']): ?>selected<?php endif; ?> value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
      </select>
    <?php endif; ?>
  <?php elseif ($this->_tpl_vars['conf']['conf_key'] == 'CATEGORY_TEXT_TEMPLATE' || $this->_tpl_vars['conf']['conf_key'] == 'FOOTER_TITLE' || $this->_tpl_vars['conf']['conf_key'] == 'TIRES_TITLE_TEMPLATE' || $this->_tpl_vars['conf']['conf_key'] == 'DISK_TITLE_TEMPLATE'): ?>
  	<textarea name="<?php echo $this->_tpl_vars['conf']['conf_key']; ?>
" style="width:50%; height:200px;"><?php echo $this->_tpl_vars['conf']['conf_value']; ?>
</textarea>
  <?php else: ?>
    <input type=text name=<?php echo $this->_tpl_vars['conf']['conf_key']; ?>
 value="<?php echo $this->_tpl_vars['conf']['conf_value']; ?>
" class=field style="width:50%;">
  <?php endif; ?>
</td>
</tr>

<?php endforeach; endif; unset($_from); ?>
</table>
<br>
<center><input type=submit name=submit_edit_conf value="Сохранить изменения"></center>
</form>