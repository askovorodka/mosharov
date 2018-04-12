<?php /* Smarty version 2.6.11, created on 2016-03-10 23:02:22
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/edit_conf/admin/templates/edit_conf.a_mails_templates.html */ ?>
<?php echo '
<script language="javascript" type="text/javascript">
function validateMailsTemplates(form){

   var i;

   var str = \'\';

   var status = true;

   var bad_field;

   var fields = new Array();

   var prompts = new Array();

    fields[fields.length] = \'key\';

    prompts[prompts.length] = \'Ключ шаблона :\';

    fields[fields.length] = \'name\';

    prompts[prompts.length] = \'Название шаблона :\';

    fields[fields.length] = \'template\';

    prompts[prompts.length] = \'Шаблон :\';


    for (i = 0; i < fields.length; i++)

    {
        var field = form[fields[i]];
        if (trim(field.value) == \'\' || field.value==0)
        {
           if (str != \'\')
           {
              str += \'\\n\';
            }
            else
            {
               bad_field = field;
             }
           str += prompts[i];
          }
     }

    if (trim(form[\'key\'].value) != ""){
      var goodKey = new String();
      goodKey = form[\'key\'].value.match(/\\b(^([0-9a-zA-Z_]+)$)\\b/gi);
      if(!goodKey){
        alert("Код шаблона должен состоять из латинских букв !");
        return false;
      }
    }

    if (str != \'\')
    {
         str +=\'\\n\';
         alert("Не заполнены необходимые поля:\\n" + str);
         status= false;
         return false;
     }

   form.submit();
}

function trim(s){return s.replace(/(^\\s+)|(\\s+$)/g,"");}
</script>
'; ?>









<?php if ($this->_tpl_vars['mode'] != 'edit'): ?>
<b>Доступные шаблоны писем в системе:</b>
<br><br>

<?php if (! $this->_tpl_vars['mails_list']): ?>
Нет ни одного доступного шаблона письма
<?php else: ?>

<form action="" method=post>
<table width=70% cellspacing=1 cellpadding=3>
<?php $_from = $this->_tpl_vars['mails_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['template']):
?>
	<tr>
		<td width=40% align=left><?php echo $this->_tpl_vars['template']['name']; ?>
</td>
		<td width=40% align=left><?php echo $this->_tpl_vars['template']['mail_key']; ?>
</td>
		<td width=40% align=left><?php echo $this->_tpl_vars['template']['status']; ?>
</td>
		<td>[<a href=index.php?mod=edit_conf&action=edit_mail_template&id=<?php echo $this->_tpl_vars['template']['mail_key']; ?>
>Редактировать</a>] / [<a href=index.php?mod=edit_conf&action=delete_mail_template&id=<?php echo $this->_tpl_vars['template']['mail_key']; ?>
>Удалить</a>]</td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
</form>
<?php endif; ?>

<br><br><br>

<form action="" method=post onSubmit="return validateMailsTemplates(this);">
<table width=70% cellspacing=1 cellpadding=3>
	<tr>
		<td>Ключ шаблона:</td>
		<td width=40%><input type=text name=key class=field value="<?php echo $this->_tpl_vars['key']; ?>
"></td>
	</tr>
	<tr>
		<td>Название шаблона:</td>
		<td width=40%><input type=text name=name class=field value="<?php echo $this->_tpl_vars['name']; ?>
"></td>
	</tr>
	<tr>
		<td>Шаблон:</td>
		<td><textarea cols="55" rows="15" name="template"></textarea></td>
	</tr>
	<tr>
		<td><input type=submit name=submit_add_mail_template value="Добавить"></td>
	</tr>
</table>
</form>

<?php else: ?>
<b>Редактирование шаблона <?php echo $this->_tpl_vars['name']; ?>
</b>
<br><br><br>

<form action="" method=post onSubmit="return validateMailsTemplates(this);">
<table width=70% cellspacing=1 cellpadding=3>
	<tr>
		<td>Ключ шаблона:</td>
		<td width=40%><input type=text name=key class=field value="<?php echo $this->_tpl_vars['key']; ?>
"></td>
	</tr>
	<tr>
		<td>Название шаблона:</td>
		<td width=40%><input type=text name=name class=field value="<?php echo $this->_tpl_vars['name']; ?>
"></td>
	</tr>
	<tr>
		<td>Шаблон:</td>
		<td><textarea cols="55" rows="15" name="template"><?php echo $this->_tpl_vars['text']; ?>
</textarea></td>
	</tr>
	<tr>
		<td><input type=submit name=submit_edit_mail_template value="Изменить"></td>
	</tr>
</table>
</form>

<?php endif; ?>