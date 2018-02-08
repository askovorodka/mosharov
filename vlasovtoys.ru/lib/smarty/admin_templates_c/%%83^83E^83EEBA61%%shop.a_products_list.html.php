<?php /* Smarty version 2.6.11, created on 2011-07-28 21:22:45
         compiled from /home/simpleuser/data/www/vlasovtoys.ru/modules/shop/admin/templates/shop.a_products_list.html */ ?>
<?php echo '
<DIV id=dhtmltooltip></DIV>
<SCRIPT language=JavaScript>
<!--
function confirm_delete(delete_id) {
	if (confirm("Дейтсвительно удалить этот продукт?")) parent.location.href = "?mod=shop&action=delete_product&id=" + delete_id;
}

function select_all(elem, str) {
	for (i=0; i<elem.form.elements.length; i++) {
		if (elem.form.elements[i].type=="checkbox" && elem.form.elements[i].name.indexOf(str)==0) {
			elem.form.elements[i].checked=elem.checked;
		}
	}
}

function viewSortProducts(catId){
	try{
		if (parseInt(catId)){
			window.open("?mod=shop&action=viewSortProducts&cat_id=" + parseInt(catId),"","width=600,height=600,resizable=yes,scrollbars=yes");
		}
	}
	catch(e){
		alert(e.toString());
	}
}
function show(name, elem)
{
if(document.getElementById(name).style.display!="none") {
		document.getElementById(name).style.display="none";
		elem.className = "plus";
	}
	else {
		document.getElementById(name).style.display="";
		elem.className = "minus";
	}
}
-->
</SCRIPT>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>


<table width=100%>
<tr>
<td valign="top" colspan="2">
<form action="" method=GET name=cat_sort>
<input type=hidden name=mod value=shop>
<input type=hidden name=action value=products_list>
<input type=hidden name=page value=<?php echo $this->_tpl_vars['current_page']; ?>
>
Сортировать по разделу:
<select name=cat class=field onChange="document.cat_sort.submit();" style="width: 100%">
<?php $_from = $this->_tpl_vars['cat_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
<option value=<?php echo $this->_tpl_vars['entry']['id']; ?>
 <?php if ($this->_tpl_vars['cat'] == $this->_tpl_vars['entry']['id']): ?>selected=true<?php endif; ?>><?php echo $this->_tpl_vars['entry']['full_title']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
</select>
</form>
</td></tr>
<tr>
<td valign="top" width="50%">
</td><td valign="top" style="padding-left: 10px;"><form action="" method=get>
<input type=hidden name=mod value=shop>
<input type=hidden name=action value=products_list>
<input type=hidden name=page value=<?php echo $this->_tpl_vars['current_page']; ?>
>
Поиск:<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top">
    <td width="80%"><input type=text name=search class=field style="width:100%;" value="<?php echo $this->_tpl_vars['search']; ?>
">&nbsp;</td>
    <td>&nbsp;<input type=submit value="Искать"></td>
  </tr>
</table>
</form></td>
</tr></table>
<?php if ($this->_tpl_vars['products_list']): ?>
<form action="" method="post" name=frm1>
	<input type="hidden" name="action" value="resort_order">
	<input type="hidden" name="parent_cat" value="<?php echo $this->_tpl_vars['cat']; ?>
">
<table width=100% class=content_table>
	<tr>
	<th width="30" align="center" style="border-right: none;"><input type="checkbox" onClick="select_all(this,'del_product')" style="margin-left: 7px;"></th>
	<th style="border-left: none;">Продукция&nbsp;&nbsp;<a href="?mod=shop&action=products_list&cat=<?php echo $this->_tpl_vars['cat']; ?>
&sort=name&<?php if (trim ( $this->_tpl_vars['type'] ) != ""): ?>type=<?php echo $this->_tpl_vars['type']; ?>
&<?php endif; ?>order=asc&search=<?php echo $this->_tpl_vars['search']; ?>
&page=<?php echo $this->_tpl_vars['current_page']; ?>
" class=img_link><img src=templates/img/cat_up.gif border=0 width="7" height="6"></a> <a href="?mod=shop&action=products_list&cat=<?php echo $this->_tpl_vars['cat']; ?>
&<?php if (trim ( $this->_tpl_vars['type'] ) != ""): ?>type=<?php echo $this->_tpl_vars['type']; ?>
&<?php endif; ?>sort=name&order=desc&search=<?php echo $this->_tpl_vars['search']; ?>
&page=<?php echo $this->_tpl_vars['current_page']; ?>
" class=img_link><img src=templates/img/cat_down.gif border=0 width="7" height="6"></a></th>
	<th width="80">Статус <a href="?mod=shop&action=products_list&cat=<?php echo $this->_tpl_vars['cat']; ?>
&sort=status&order=asc&search=<?php echo $this->_tpl_vars['search']; ?>
&page=<?php echo $this->_tpl_vars['current_page']; ?>
" class=img_link><img src=templates/img/cat_up.gif border=0 width="7" height="6"></a>&nbsp;<a href="?mod=shop&action=products_list&cat=<?php echo $this->_tpl_vars['cat']; ?>
&sort=status&order=desc&search=<?php echo $this->_tpl_vars['search']; ?>
&page=<?php echo $this->_tpl_vars['current_page']; ?>
" class=img_link><img src=templates/img/cat_down.gif border=0 width="7" height="6"></a></th>
	
		
	<th width="80">Действия</th>
	</tr>


	<?php $_from = $this->_tpl_vars['products_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tree'] = array('total' => count($_from), 'iteration' => 0);
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
_left align="center"><input type="checkbox" name="del_product[<?php echo $this->_tpl_vars['entry']['id']; ?>
]"></td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle>
				<?php if (intval ( $this->_tpl_vars['entry']['hit'] ) == 1): ?><img src="templates/img/hit.gif" width="21" height="21" border="0" alt="Хит продаж" align="right" style="margin: 5px 5px 0 10px;"><?php endif; ?><small><font color=#666666><?php echo $this->_tpl_vars['entry']['cat_title']; ?>
</font></small><br><img src="templates/img/tree.gif"><b><?php echo $this->_tpl_vars['entry']['name']; ?>
</b>
			</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align=center width="80">
			<a href="?mod=shop&action=change_product_status&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
" title="Изменить статус"><img src=templates/img/status_<?php echo $this->_tpl_vars['entry']['status']; ?>
.gif border=0></a>
			</td>
						<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_right width="80">
				<a href="javascript:confirm_delete('<?php echo $this->_tpl_vars['entry']['id']; ?>
');" class=img_link onmouseover="ddrivetip('Удалить продукт')" onmouseout=hideddrivetip()><img src=templates/img/ico_delete.gif border=0></a>
				<a href=?mod=shop&action=edit_product&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Редактировать продукт')" onmouseout=hideddrivetip()><img src=templates/img/ico_edit.gif border=0></a>
			</td>
		</tr>

	<?php endforeach; endif; unset($_from); ?>
    <tr>
    <td class=td2_left style="height: 40px;" align="center"><img src="templates/img/tree.gif" style="margin-left: 5px;"></td>
    <td class=td2_middle><a href="javascript: void(document.frm1.submit());" style="color: #FF0000; text-decoration: underline;">Удалить отмеченные</a>
<?php if (trim ( $this->_tpl_vars['cat'] ) != ""): ?>&nbsp;&nbsp;&nbsp;&nbsp;<img src="templates/img/blank.gif" width="8" height="10" border="0" alt="" style="margin-right: 10px;"><a href="javascript: void(viewSortProducts(<?php echo $this->_tpl_vars['cat']; ?>
));" style="color: #FF0000; text-decoration: underline;">Упорядочить продукцию</a><?php endif; ?></td>
<td class=td2_middle>&nbsp;</td><td class=td2_right>&nbsp;</td></tr></table>
</form>
<?php else: ?>
<table width=100% class=content_table>
	<tr>
	<th width="30" align="center" style="border-right: none;">&nbsp;</th>
	<th style="border-left: none;">Продукция</th>>
	<th width="80">Статус</th>
	<th width="80">Действия</th>
	</tr>
    <tr>
    <td class="td2_left" style="height: 40px;">&nbsp;</td>
    <td colspan="5" class="td2_right"><strong><?php if (! $this->_tpl_vars['search']): ?>В этой категории нет продуктов<?php else: ?>Ничего не найдено!<?php endif; ?></strong></td></tr></table>
<?php endif; ?>
<table width=100% class=content_table>
	<tr>
		<th bgcolor=#99CCFF onClick="show('metas', this);" class="button plus" style="border-bottom: none; text-align: left; padding-left: 30px;"><b>Дополнительно</b></th>
	</tr>
 </table>
    <div id="metas" style="display: none;">
<table width=100% class=content_table>
	<tr>
		<td width=15% class=td2_left><strong>Фотографии:</strong></td>
		<td class=td2_right><a href=index.php?mod=shop&action=delete_previews style="text-decoration: underline;"><strong>Удалить уменьшенные копии фотографий продукции</strong></a><br>
        <small style="color: #999;">данная процедура занимает некоторое время, просьба подождать</small></td>
	</tr>
</table>

</div>
<br>
<div class="add_but" style="float: left;" onClick="location.href='?mod=shop&action=add_product<?php if ($this->_tpl_vars['cat']): ?>&cat=<?php echo $this->_tpl_vars['cat'];  endif; ?>'"><div><a href="?mod=shop&action=add_product<?php if ($this->_tpl_vars['cat']): ?>&cat=<?php echo $this->_tpl_vars['cat'];  endif; ?>">добавить продукт</a></div></div>
<br>
<?php if ($this->_tpl_vars['total_pages'] > 1): ?>
<br><br>
<div class="listing">
<li class="str">
<ul>
<li class="center"><a href="?mod=shop&action=products_list&cat=<?php echo $this->_tpl_vars['cat']; ?>
&type=<?php echo $this->_tpl_vars['type']; ?>
&sort=<?php echo $this->_tpl_vars['sort']; ?>
&order=<?php echo $this->_tpl_vars['order']; ?>
&search=<?php echo $this->_tpl_vars['search']; ?>
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
  <a class="active" href="?mod=shop&action=products_list&cat=<?php echo $this->_tpl_vars['cat']; ?>
&sort=<?php echo $this->_tpl_vars['sort']; ?>
&type=<?php echo $this->_tpl_vars['type']; ?>
&order=<?php echo $this->_tpl_vars['order']; ?>
&search=<?php echo $this->_tpl_vars['search']; ?>
&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php else: ?>
  <a href="?mod=shop&action=products_list&cat=<?php echo $this->_tpl_vars['cat']; ?>
&sort=<?php echo $this->_tpl_vars['sort']; ?>
&type=<?php echo $this->_tpl_vars['type']; ?>
&order=<?php echo $this->_tpl_vars['order']; ?>
&search=<?php echo $this->_tpl_vars['search']; ?>
&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php endif;  endfor; endif; ?>
<a href="?mod=shop&action=products_list&cat=<?php echo $this->_tpl_vars['cat']; ?>
&type=<?php echo $this->_tpl_vars['type']; ?>
&sort=<?php echo $this->_tpl_vars['sort']; ?>
&order=<?php echo $this->_tpl_vars['order']; ?>
&search=<?php echo $this->_tpl_vars['search']; ?>
&page=<?php echo $this->_tpl_vars['total_pages']; ?>
">&raquo;</a></li>
</ul></li></div><?php endif; ?>