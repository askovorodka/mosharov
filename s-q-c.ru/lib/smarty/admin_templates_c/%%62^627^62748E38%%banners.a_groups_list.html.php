<?php /* Smarty version 2.6.11, created on 2015-12-15 18:41:10
         compiled from /var/www/alex/data/www/scl.mosharov.com//modules/banners/admin/templates/banners.a_groups_list.html */ ?>
<?php if ($this->_tpl_vars['groups_list']): ?>
<DIV id=dhtmltooltip></DIV>
<?php echo '
<script language="JavaScript">
function confirm_delete(delete_id) {
	if (confirm("Дейтсвительно удалить эту группу?")) {
		parent.location.href = "?mod=banners&action=delete_group&id=" + delete_id;
	}
}
</script>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>


<table width=100% class="content_table">
<tr>
<th>Группа</th><th width=25%>Код вставки</th><th width=5%>Действия</th>
</tr>
<?php $_from = $this->_tpl_vars['groups_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['bn'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['bn']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entry']):
        $this->_foreach['bn']['iteration']++;
 if ($this->_tpl_vars['col'] == 1):  $this->assign('td', 'td1');  $this->assign('col', 0);  else:  $this->assign('td', 'td2');  $this->assign('col', 1);  endif; ?>
<tr onmouseover="flatlinkOver(this)" <?php if ($this->_foreach['bn']['iteration']%2 == 1): ?>onmouseout="flatlinkOut(this)"<?php else: ?>onmouseout="flatlinkOut1(this)"<?php endif; ?>>
<td class=<?php echo $this->_tpl_vars['td']; ?>
_left><b><?php echo $this->_tpl_vars['entry']['name']; ?>
</b></td>
<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle><input style="width:100%;" type=text class=field value='<?php echo '{banners group="';  echo $this->_tpl_vars['entry']['id'];  echo '"}'; ?>
'></td>
<td class=<?php echo $this->_tpl_vars['td']; ?>
_right align="center"><a href="javascript:confirm_delete('<?php echo $this->_tpl_vars['entry']['id']; ?>
');" class=img_link onmouseover="ddrivetip('Удалить группу')" onmouseout=hideddrivetip()><img src=templates/img/ico_delete.gif border=0></a><a href=?mod=banners&action=edit_group&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Редактировать группу')" onmouseout=hideddrivetip()><img src=templates/img/ico_edit.gif border=0></a></td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<br>
<div class="add_but" onClick="location.href='?mod=banners&action=add_group'"><div><a href="?mod=banners&action=add_group">добавить группу</a></div></div>

<?php if ($this->_tpl_vars['total_pages'] > 1): ?>
<br><br>
<div class="listing">
<li class="str">
<ul>
<li class="center"><a href="?mod=banners&action=groups_list&page=1">&laquo;</a>
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
  <a class="active" href="?mod=banners&action=groups_list&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php else: ?>
  <a href="?mod=banners&action=groups_list&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php endif;  endfor; endif; ?>
<a href="?mod=banners&action=groups_list&page=<?php echo $this->_tpl_vars['total_pages']; ?>
">&raquo;</a></li>
</ul>
</li>
</div>
<?php endif; ?>

<?php else: ?>
<table width=100% class="content_table">
<tr>
<th>Группа</th><th width=25%>Код вставки</th><th width=5%>Действия</th>
</tr>
<tr>
<td class=td2_middle colspan="3" style="height: 30px;">
<center>В системе нет групп баннеров.</center></td></tr></table>
<br>
<div class="add_but" onClick="location.href='?mod=banners&action=add_group'"><div><a href="?mod=banners&action=add_group">добавить группу</a></div></div>
<?php endif; ?>