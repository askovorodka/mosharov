<?php /* Smarty version 2.6.11, created on 2015-12-13 19:24:53
         compiled from /var/www/sqc//modules/banners/admin/templates/banners.a_main.html */ ?>
<?php if ($this->_tpl_vars['banners_list']): ?>
<DIV id=dhtmltooltip></DIV>
<?php echo '
<script language="JavaScript">
function confirm_delete(delete_id) {
	if (confirm("Дейтсвительно удалить этот баннер?")) {
		parent.location.href = "?mod=banners&action=delete&id=" + delete_id;
	}
}
</script>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>


<table width=100% class="content_table">
<tr>
<th>Название баннера</th><th width=10%>Кликов</th><th width=15%>Показано</th><th width=10%>Статус</th><th width=5%>Действия</th>
</tr>
<?php $_from = $this->_tpl_vars['banners_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['br'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['br']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['banners']):
        $this->_foreach['br']['iteration']++;
 if ($this->_tpl_vars['col'] == 1):  $this->assign('td', 'td1');  $this->assign('col', 0);  else:  $this->assign('td', 'td2');  $this->assign('col', 1);  endif; ?>
<tr onmouseover="flatlinkOver(this)" <?php if ($this->_foreach['br']['iteration']%2 == 1): ?>onmouseout="flatlinkOut(this)"<?php else: ?>onmouseout="flatlinkOut1(this)"<?php endif; ?>>
<td class=<?php echo $this->_tpl_vars['td']; ?>
_left><b><?php echo $this->_tpl_vars['banners']['name']; ?>
</b></td>
<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align="center" nowrap><b><?php echo $this->_tpl_vars['banners']['clicks']; ?>
</b></td>
<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align="center" nowrap><?php echo $this->_tpl_vars['banners']['shown']; ?>
 из <?php echo $this->_tpl_vars['banners']['showings']; ?>
 раз</td>
<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_middle><img src=templates/img/status_<?php echo $this->_tpl_vars['banners']['status']; ?>
.gif border=0></td>
<td class=<?php echo $this->_tpl_vars['td']; ?>
_right align="center"><a href="javascript:confirm_delete('<?php echo $this->_tpl_vars['banners']['id']; ?>
');" class=img_link onmouseover="ddrivetip('Удалить баннер')" onmouseout=hideddrivetip()><img src=templates/img/ico_delete.gif border=0></a><a href=?mod=banners&action=edit_banner&id=<?php echo $this->_tpl_vars['banners']['id']; ?>
 class=img_link onmouseover="ddrivetip('Редактировать баннер')" onmouseout=hideddrivetip()><img src=templates/img/ico_edit.gif border=0></a></td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<br>
<div class="add_but" onClick="location.href='?mod=banners&action=add_banner'"><div><a href="?mod=banners&action=add_banner">добавить кампанию</a></div></div>


<?php if ($this->_tpl_vars['total_pages'] > 1): ?>
<br><br>
<div class="listing">
<li class="str">
<ul>
<li class="center"><a href="?mod=banners&page=1">&laquo;</a>
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
  <a class="active" href="?mod=banners&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php else: ?>
  <a href="?mod=banners&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php endif;  endfor; endif; ?>
<a href="?mod=banners&page=<?php echo $this->_tpl_vars['total_pages']; ?>
">&raquo;</a></li>
</ul>
</li>
</div>
<?php endif; ?>

<?php else: ?>
<table width=100% class="content_table">
<tr>
<th>Название баннера</th><th width=10%>Кликов</th><th width=15%>Показано</th><th width=10%>Статус</th><th width=5%>Действия</th>
</tr>
<tr>
<td class=td2_middle colspan="5" style="height: 30px;">
<center>В системе нет баннеров.</center></td></tr></table>
<br>
<div class="add_but" onClick="location.href='?mod=banners&action=add_banner'"><div><a href="?mod=banners&action=add_banner">добавить кампанию</a></div></div>
<?php endif; ?>