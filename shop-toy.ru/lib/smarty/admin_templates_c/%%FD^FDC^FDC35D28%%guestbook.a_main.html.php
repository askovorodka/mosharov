<?php /* Smarty version 2.6.11, created on 2012-02-01 17:14:42
         compiled from /home/alex/data/www/shop-toy.mosharov.com/modules/guestbook/admin/templates/guestbook.a_main.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/home/alex/data/www/shop-toy.mosharov.com/modules/guestbook/admin/templates/guestbook.a_main.html', 29, false),)), $this); ?>
<?php if ($this->_tpl_vars['guestbook_list']): ?>
<DIV id=dhtmltooltip></DIV>
<?php echo '
<script language="JavaScript">
function confirm_delete(delete_id) {
  if (confirm("Дейтсвительно удалить это сообщение?")) {
    parent.location.href = "?mod=guestbook&action=delete_msg&id=" + delete_id;
  }
}
</script>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>


<table width=100% class="content_table">
<tr>
<th>Тема</th><th width="150">Автор</th><th width=100>Опубликовано</th><th width="50">Статус</th><th width=10%>Действия</th>
</tr>
<?php $_from = $this->_tpl_vars['guestbook_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['gs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['gs']['iteration']++;
 if ($this->_tpl_vars['col'] == 1):  $this->assign('td', 'td1');  $this->assign('col', 0);  else:  $this->assign('td', 'td2');  $this->assign('col', 1);  endif; ?>
<tr onmouseover="flatlinkOver(this)" <?php if ($this->_foreach['gs']['iteration']%2 == 1): ?>onmouseout="flatlinkOut(this)"<?php else: ?>onmouseout="flatlinkOut1(this)"<?php endif; ?>>
<td class=<?php echo $this->_tpl_vars['td']; ?>
_left><a href="?mod=guestbook&action=edit_msg&id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><strong><?php echo $this->_tpl_vars['item']['tema']; ?>
</strong></a></td>
<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle style="text-align: justify;"><?php echo $this->_tpl_vars['item']['author']; ?>
</td>
<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align="center" style="font-size: 11px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['insert_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d") : smarty_modifier_date_format($_tmp, "%d")); ?>
&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['insert_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%B") : smarty_modifier_date_format($_tmp, "%B")); ?>
&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['insert_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
</td>
<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align="center"><a href="?mod=guestbook&action=change_message_status&id=<?php echo $this->_tpl_vars['item']['id']; ?>
" title="Изменить статус"><img src=templates/img/status_<?php echo $this->_tpl_vars['item']['status']; ?>
.gif border=0></a></td>
<td class=<?php echo $this->_tpl_vars['td']; ?>
_right align="center"><a href="javascript:confirm_delete('<?php echo $this->_tpl_vars['item']['id']; ?>
');" class=img_link onmouseover="ddrivetip('Удалить сообщение')" onmouseout=hideddrivetip()><img src=templates/img/ico_delete.gif border=0></a><a href=?mod=guestbook&action=edit_msg&id=<?php echo $this->_tpl_vars['item']['id']; ?>
 class=img_link onmouseover="ddrivetip('Редактировать сообщение')" onmouseout=hideddrivetip()><img src=templates/img/ico_edit.gif border=0></a></td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<br>
<div class="add_but" onClick="location.href='?mod=guestbook&action=add'"><div><a href="?mod=guestbook&action=add">добавить сообщение</a></div></div>

<?php if ($this->_tpl_vars['total_pages'] > 1): ?>
<br><br>
<div class="listing">
<li class="str">
<ul>
<li class="center"><a href="?mod=guestbook&page=1">&laquo;</a>
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
  <a class="active" href="?mod=guestbook&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php else: ?>
  <a href="?mod=guestbook&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php endif;  endfor; endif; ?>
<a href="?mod=guestbook&page=<?php echo $this->_tpl_vars['total_pages']; ?>
">&raquo;</a></li>
</ul>
</li>
</div>
<?php endif; ?>

<?php else: ?>
<table width=100% class="content_table">
<tr>
<th>Тема</th><th width="150">Автор</th><th width=100>Опубликовано</th><th width="50">Статус</th><th width=10%>Действия</th>
</tr>
<tr>
<td class=td2_middle colspan="5" style="height: 30px;">
<center>В системе нет сообщений.</center></td></tr></table>
<br>
<div class="add_but" onClick="location.href='?mod=guestbook&action=add'"><div><a href="?mod=guestbook&action=add">добавить сообщение</a></div></div>
<?php endif; ?>