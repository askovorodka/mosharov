<?php /* Smarty version 2.6.11, created on 2016-03-14 02:31:42
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/forms/admin/templates/forms.a_main.html */ ?>
<?php echo '
<DIV id=dhtmltooltip></DIV>
<SCRIPT language=JavaScript>

function confirm_delete(delete_id)
{
if (confirm("Дейтсвительно удалить эту форму?")) {
parent.location.href = "?mod=forms&action=delete&id=" + delete_id;
}
}
</SCRIPT>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>


<?php if ($this->_tpl_vars['forms_list']): ?>
<table width=100% class=content_table>

	<tr>
	<th width=10%>ID</th>
	<th>Название</th>
	<th width=20%>E-mail</th>
	<th width=5%>Статус</th>
	<th width=10%>Действия</th>
	</tr>

	<?php $_from = $this->_tpl_vars['forms_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['forma'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['forma']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['form']):
        $this->_foreach['forma']['iteration']++;
?>

	<?php if ($this->_tpl_vars['col'] == 1): ?>
	<?php $this->assign('td', 'td1'); ?>
	<?php $this->assign('col', 0); ?>
	<?php else: ?>
	<?php $this->assign('td', 'td2'); ?>
	<?php $this->assign('col', 1); ?>
	<?php endif; ?>
	<tr onmouseover="flatlinkOver(this)" <?php if ($this->_foreach['forma']['iteration']%2 == 1): ?>onmouseout="flatlinkOut(this)"<?php else: ?>onmouseout="flatlinkOut1(this)"<?php endif; ?>>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_left align=center>
				<small><?php echo $this->_tpl_vars['form']['id']; ?>
</small>
			</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle>
				<?php echo $this->_tpl_vars['form']['name']; ?>
 <font color="#666666"><small>(<?php echo $this->_tpl_vars['form']['elements']; ?>
)</small></font>
			</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align=center>
				<?php echo $this->_tpl_vars['form']['email']; ?>

			</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align=center>
				<img src=templates/img/status_<?php echo $this->_tpl_vars['form']['status']; ?>
.gif border=0>
			</td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_right>
				<a href="javascript:confirm_delete('<?php echo $this->_tpl_vars['form']['id']; ?>
');" class=img_link onmouseover="ddrivetip('Удалить форму')" onmouseout=hideddrivetip()><img src=templates/img/ico_delete.gif border=0></a>
				<a href=?mod=forms&action=edit&id=<?php echo $this->_tpl_vars['form']['id']; ?>
 class=img_link onmouseover="ddrivetip('Редактировать форму')" onmouseout=hideddrivetip()><img src=templates/img/ico_edit.gif border=0></a>
			</td>
		</tr>

	<?php endforeach; endif; unset($_from); ?>

</table>
<?php else: ?>
<table width=100% class=content_table>

	<tr>
	<th width=10%>ID</th>
	<th>Название</th>
	<th width=20%>E-mail</th>
	<th width=5%>Статус</th>
	<th width=10%>Действия</th>
	</tr>
    <tr>
<td class=td2_middle colspan="5" style="height: 30px;">
<center>В системе нет ни одной формы.</center></td></tr></table>
<?php endif; ?>
<br>
<div class="add_but" onClick="location.href='?mod=forms&action=add'"><div><a href="?mod=forms&action=add">добавить форму</a></div></div>

<?php if ($this->_tpl_vars['total_pages'] > 1): ?>
<br><br>
<div class="listing">
<li class="str">
<ul>
<li class="center"><a href="?mod=tables&page=1">&laquo;</a>
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
  <a class="active" href="?mod=forms&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php else: ?>
  <a href="?mod=forms&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php endif;  endfor; endif; ?>
<a href="?mod=forms&page=<?php echo $this->_tpl_vars['total_pages']; ?>
">&raquo;</a></li>
</ul>
</li>
</div>
<?php endif; ?>