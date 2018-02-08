<?php /* Smarty version 2.6.11, created on 2014-07-30 11:05:57
         compiled from main.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'main.html', 31, false),array('modifier', 'strip_tags', 'main.html', 54, false),array('modifier', 'truncate', 'main.html', 54, false),)), $this); ?>
<table width=100% class="content_table">
<tr>
<th colspan="2">Общая статистика по сайту</th></tr>
<tr>
<td width="280" class="td1_left">На сайте узлов:</td>
<td class="td1_right"><?php echo $this->_tpl_vars['count_cat']; ?>
</td></tr>
<tr>
<td width="280" class="td2_left">Документов:</td><td class="td2_right"><?php echo $this->_tpl_vars['count_documents']; ?>
</td>
</tr>
<tr>
<td width="280" class="td1_left">Пользователей:</td><td class="td1_right"><?php echo $this->_tpl_vars['count_users']; ?>
</td>
</table>

<?php if (count ( $this->_tpl_vars['last_orders'] ) > 0): ?>
<br><br>
<table width=100% class="content_table">
<tr>
	<th colspan="4">
		<strong>Последние заказы</strong>
	</th>
</tr>
<?php $_from = $this->_tpl_vars['last_orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ns'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ns']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['ns']['iteration']++;
 if ($this->_tpl_vars['col'] == 1):  $this->assign('td', 'td1');  $this->assign('col', 0);  else:  $this->assign('td', 'td2');  $this->assign('col', 1);  endif; ?>
	<tr onmouseover="flatlinkOver(this)" <?php if ($this->_foreach['ns']['iteration']%2 == 1): ?>onmouseout="flatlinkOut(this)"<?php else: ?>onmouseout="flatlinkOut1(this)"<?php endif; ?>>
		<td width="120" class=<?php echo $this->_tpl_vars['td']; ?>
_left><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['order_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d") : smarty_modifier_date_format($_tmp, "%d")); ?>
&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['order_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%B") : smarty_modifier_date_format($_tmp, "%B")); ?>
&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['order_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
</td><td class=<?php echo $this->_tpl_vars['td']; ?>
_middle width="150"><a href="?mod=shop&action=order_details&id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><strong><?php echo $this->_tpl_vars['item']['user_name']; ?>
</strong></a></td><td class=<?php echo $this->_tpl_vars['td']; ?>
_middle><strong style="color: red;"><?php echo $this->_tpl_vars['item']['total_summ']; ?>
&nbsp;<?php echo $this->_tpl_vars['currency_site']['znak']; ?>
</strong></td><td width="100"  class=<?php echo $this->_tpl_vars['td']; ?>
_right>&nbsp;</td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>

<?php if (count ( $this->_tpl_vars['last_faq'] ) > 0): ?>
<br><br>
<table width=100% class="content_table">
<tr>
	<th colspan="3">
		<strong>Последние сообщения FAQ</strong>
	</th>
</tr>
<?php $_from = $this->_tpl_vars['last_faq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['faq'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['faq']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['faq']['iteration']++;
 if ($this->_tpl_vars['col'] == 1):  $this->assign('td', 'td1');  $this->assign('col', 0);  else:  $this->assign('td', 'td2');  $this->assign('col', 1);  endif; ?>
	<tr onmouseover="flatlinkOver(this)" <?php if ($this->_foreach['faq']['iteration']%2 == 1): ?>onmouseout="flatlinkOut(this)"<?php else: ?>onmouseout="flatlinkOut1(this)"<?php endif; ?>>
	<td width="120" class="<?php echo $this->_tpl_vars['td']; ?>
_left"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['insert_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d") : smarty_modifier_date_format($_tmp, "%d")); ?>
&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['insert_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%B") : smarty_modifier_date_format($_tmp, "%B")); ?>
&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['insert_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
</td><td class="<?php echo $this->_tpl_vars['td']; ?>
_middle" width="150"><a href="?mod=guestbook&action=edit_msg&id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><strong><?php echo $this->_tpl_vars['item']['author']; ?>
</strong></a></td><td class="<?php echo $this->_tpl_vars['td']; ?>
_right"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['message'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 180) : smarty_modifier_truncate($_tmp, 180)); ?>
</td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>

<?php if (count ( $this->_tpl_vars['last_forum'] ) > 0): ?>
<br><br>
<table width=100% class="content_table">

<tr>
	<th colspan="3">
		<strong>Последние сообщения форума</strong>
	</th>
</tr>
<?php $_from = $this->_tpl_vars['last_forum']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fr'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fr']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['fr']['iteration']++;
 if ($this->_tpl_vars['col'] == 1):  $this->assign('td', 'td1');  $this->assign('col', 0);  else:  $this->assign('td', 'td2');  $this->assign('col', 1);  endif; ?>
	<tr onmouseover="flatlinkOver(this)" <?php if ($this->_foreach['fr']['iteration']%2 == 1): ?>onmouseout="flatlinkOut(this)"<?php else: ?>onmouseout="flatlinkOut1(this)"<?php endif; ?>>
	<td width="120" class="<?php echo $this->_tpl_vars['td']; ?>
_left" nowrap><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d") : smarty_modifier_date_format($_tmp, "%d")); ?>
&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%B") : smarty_modifier_date_format($_tmp, "%B")); ?>
&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
</td><td class="<?php echo $this->_tpl_vars['td']; ?>
_middle" width="150"><a href="/forum/<?php echo $this->_tpl_vars['item']['url']; ?>
/thread_<?php echo $this->_tpl_vars['item']['thread_id']; ?>
" target="_blank"><strong><?php echo $this->_tpl_vars['item']['author']; ?>
</strong></a></td><td class="<?php echo $this->_tpl_vars['td']; ?>
_right"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['text'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 180) : smarty_modifier_truncate($_tmp, 180)); ?>
</td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</table><?php endif; ?>