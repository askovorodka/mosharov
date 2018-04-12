<?php /* Smarty version 2.6.11, created on 2016-03-02 15:42:00
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/users/admin/templates/users.a_main.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/home/a0031953/domains/s-q-c.ru/public_html//modules/users/admin/templates/users.a_main.html', 68, false),)), $this); ?>
<DIV id=dhtmltooltip></DIV>
<?php echo '
<SCRIPT LANGUAGE="JavaScript"><!--
function confirm_delete(delete_id)
{
if (confirm("Дейтсвительно удалить этого пользователя?")) {
parent.location.href = "?mod=users&action=delete_user&id=" + delete_id;
}
}
--></script>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>

<?php if ($this->_tpl_vars['error_message']): ?><br><font color=red><?php echo $this->_tpl_vars['error_message']; ?>
</font><br><br><?php endif; ?>
<table width="100%">
	<tr>
		<td width="200"><?php if (count ( $this->_tpl_vars['groups'] ) > 0): ?>
	<form action="" method="get" name="frm_groups">
		<input type="hidden" name="mod" value="users">
		<select name="groups" onChange="document.frm_groups.submit();" style="width: 200px;">
			<option selected="selected" value="">Все</option>
			<?php $_from = $this->_tpl_vars['groups']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<option <?php if ($_GET['groups'] == $this->_tpl_vars['item']['id']): ?>selected<?php endif; ?> value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
		</select>
	</form>
<?php endif; ?></td>
		<td align="left" width="80%">
			<table width="100%">
				<tr>
					<td>Английский:</td>
					<td align="left" width="87%">
						<?php $_from = $this->_tpl_vars['char_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['for1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['for1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['for1']['iteration']++;
?>
							<?php if ($this->_tpl_vars['item']['STR_CODE'] < 192): ?>
								<?php if ($this->_tpl_vars['line']): ?>|&nbsp;<?php endif;  if (trim ( $_GET['char'] ) == $this->_tpl_vars['item']['STR']):  echo $this->_tpl_vars['item']['STR'];  else: ?><a href="?mod=users&char=<?php echo $this->_tpl_vars['item']['STR']; ?>
"><strong><?php echo $this->_tpl_vars['item']['STR']; ?>
</strong></a><?php endif; ?>
								<?php $this->assign('line', 1); ?>
							<?php endif; ?>	
						<?php endforeach; endif; unset($_from); ?>
					</td>	
				</tr>
				<tr>
					<td>Русский:</td>
					<td align="left">
						<?php $_from = $this->_tpl_vars['char_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['for1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['for1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['for1']['iteration']++;
?>
							<?php if ($this->_tpl_vars['item']['STR_CODE'] > 191): ?>
								<?php if ($this->_tpl_vars['line2']): ?>|&nbsp;<?php endif;  if (trim ( $_GET['char'] ) == $this->_tpl_vars['item']['STR']):  echo $this->_tpl_vars['item']['STR'];  else: ?><a href="?mod=users&char=<?php echo $this->_tpl_vars['item']['STR']; ?>
"><strong><?php echo $this->_tpl_vars['item']['STR']; ?>
</strong></a><?php endif; ?>
								<?php $this->assign('line2', 1); ?>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</td>	
				</tr>
			</table>
		</td>
	</tr>
</table>
<br>
<table width=100% class=content_table>
	<tr><th>Имя</th><th width=15%>Дата регистрации</th><th width=15%>Логин</th><th width=15%>Группа</th><th width=10%>Статус</th><th width=10% align=center>Действия</th></tr>
	<?php $_from = $this->_tpl_vars['users_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tree'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tree']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entry']):
        $this->_foreach['tree']['iteration']++;
?>
	<?php if ($this->_tpl_vars['col'] == 1): ?>
	<?php $this->assign('td', 'td1'); ?>
	<?php $this->assign('col', 0); ?>
	<?php else: ?>
	<?php $this->assign('td', 'td2'); ?>
	<?php $this->assign('col', 1); ?>
	<?php endif; ?>
	<tr onmouseover="flatlinkOver(this)" <?php if ($this->_foreach['tree']['iteration']%2 == 1): ?>onmouseout="flatlinkOut(this)"<?php else: ?>onmouseout="flatlinkOut1(this)"<?php endif; ?>>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_left><a href="?mod=users&action=edit_user&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
"><strong><?php echo $this->_tpl_vars['entry']['name']; ?>
</strong></a></td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle><?php echo ((is_array($_tmp=$this->_tpl_vars['entry']['reg_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle><?php echo $this->_tpl_vars['entry']['login']; ?>
</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle><a href="?mod=users&groups=<?php echo $this->_tpl_vars['entry']['group_id']; ?>
"><?php echo $this->_tpl_vars['entry']['priv']; ?>
</a></td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_middle><a href="?mod=users&action=change_user_status&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
" title="Изменить статус"><img src=templates/img/status_<?php echo $this->_tpl_vars['entry']['status']; ?>
.gif border=0></a></td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_right><a href="javascript:confirm_delete('<?php echo $this->_tpl_vars['entry']['id']; ?>
');" class=img_link onmouseover="ddrivetip('Удалить пользователя')" onmouseout=hideddrivetip()><img src=templates/img/ico_delete.gif border=0></a>
			<a href=?mod=users&action=edit_user&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Редактировать данные пользователя')" onmouseout=hideddrivetip()><img src=templates/img/ico_edit.gif border=0></a></td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>	
	</table>

    <br><br>
<div class="add_but" style="float: left;" onClick="location.href='index.php?mod=users&action=add_user'"><div><a href="index.php?mod=users&action=add_user">добавить пользователя</a></div></div>
    
<?php if ($this->_tpl_vars['total_pages'] > 1): ?>
<br><br>
<div class="listing">
<li class="str">
<ul>
<li class="center"><a href="?mod=users&sort=<?php echo $this->_tpl_vars['sort']; ?>
&page=1">&laquo;</a>
<?php unset($this->_sections['p']);
$this->_sections['p']['name'] = 'p';
$this->_sections['p']['loop'] = is_array($_loop=$this->_tpl_vars['pages']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['p']['show'] = true;
$this->_sections['p']['max'] = $this->_sections['p']['loop'];
$this->_sections['p']['step'] = 1;
$this->_sections['p']['start'] = $this->_sections['p']['step'] > 0 ? 0 : $this->_sections['p']['loop']-1;
if ($this->_sections['p']['show']) {
    $this->_sections['p']['total'] = $this->_sections['p']['loop'];
    if ($this->_sections['p']['total'] == 0)
        $this->_sections['p']['show'] = false;
} else
    $this->_sections['p']['total'] = 0;
if ($this->_sections['p']['show']):

            for ($this->_sections['p']['index'] = $this->_sections['p']['start'], $this->_sections['p']['iteration'] = 1;
                 $this->_sections['p']['iteration'] <= $this->_sections['p']['total'];
                 $this->_sections['p']['index'] += $this->_sections['p']['step'], $this->_sections['p']['iteration']++):
$this->_sections['p']['rownum'] = $this->_sections['p']['iteration'];
$this->_sections['p']['index_prev'] = $this->_sections['p']['index'] - $this->_sections['p']['step'];
$this->_sections['p']['index_next'] = $this->_sections['p']['index'] + $this->_sections['p']['step'];
$this->_sections['p']['first']      = ($this->_sections['p']['iteration'] == 1);
$this->_sections['p']['last']       = ($this->_sections['p']['iteration'] == $this->_sections['p']['total']);
?>
  <?php if ($this->_tpl_vars['pages'][$this->_sections['p']['index']] == $this->_tpl_vars['current_page']): ?>
  <a class="active" href="?mod=users&sort=<?php echo $this->_tpl_vars['sort']; ?>
&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php else: ?>
  <a href="?mod=users&sort=<?php echo $this->_tpl_vars['sort']; ?>
&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php endif;  endfor; endif; ?>
<a href="?mod=users&sort=<?php echo $this->_tpl_vars['sort']; ?>
&page=<?php echo $this->_tpl_vars['total_pages']; ?>
">&raquo;</a></li>
</ul></li></div><?php endif; ?>    