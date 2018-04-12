<?php /* Smarty version 2.6.11, created on 2016-02-29 14:08:06
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/shop/admin/templates/shop.a_promo_codes.html */ ?>
<?php echo '
<DIV id=dhtmltooltip></DIV>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>


<table width=100% class=content_table>
    <tr><th>Код</th>
        <th>Процент</th>
        <th>Использован раз</th>
        <th>Использован в заказах</th>
        <th width=10%>Дата создания</th>
        <th style="width: 120px;">Действия</th></tr>
    <?php $_from = $this->_tpl_vars['codes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>

    <?php if ($this->_tpl_vars['col'] == 1): ?>
    <?php $this->assign('td', 'td1'); ?>
    <?php $this->assign('col', 0); ?>
    <?php else: ?>
    <?php $this->assign('td', 'td2'); ?>
    <?php $this->assign('col', 1); ?>
    <?php endif; ?>

    <tr><td class=<?php echo $this->_tpl_vars['td']; ?>
_left><?php echo $this->_tpl_vars['item']['code']; ?>
</td>
        <td class=<?php echo $this->_tpl_vars['td']; ?>
_middle><?php echo $this->_tpl_vars['item']['percent']; ?>
</td>
        <td class=<?php echo $this->_tpl_vars['td']; ?>
_middle><?php echo $this->_tpl_vars['item']['count']; ?>
</td>
        <td class=<?php echo $this->_tpl_vars['td']; ?>
_middle><?php if (! empty ( $this->_tpl_vars['item']['orders'] )):  echo $this->_tpl_vars['item']['orders'];  endif; ?></td>
        <td width=10% class=<?php echo $this->_tpl_vars['td']; ?>
_middle><?php echo $this->_tpl_vars['item']['date']; ?>
</td>
        <td style="width: 120px;" class=<?php echo $this->_tpl_vars['td']; ?>
_middle align=center>
        <a href="?mod=shop&action=code_state&code=<?php echo $this->_tpl_vars['item']['code']; ?>
" title="Изменить статус"><img src=templates/img/status_<?php echo $this->_tpl_vars['item']['state']; ?>
.gif border=0></a>
            &nbsp;
        <a href=?mod=shop&action=promo_codes&code=<?php echo $this->_tpl_vars['item']['code']; ?>
 class=img_link title="Редактировать промо-код"><img src=templates/img/ico_edit.gif border=0></a>
    </td></tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<br>
<form action="" method="post" id="addCodeForm">
    <input type="hidden" name="edit_code" value="true" />
    <table width=100% class=content_table>
        <tr class=table_content>
            <td class=td1_left>&nbsp;Код:</td>
            <td class=td1_right><input type=text id="code" name=code style="width:20%;" class=field value="<?php echo $this->_tpl_vars['edit_code']['code']; ?>
" /></td>
        </tr>

        <tr class=table_content>
            <td class=td1_left>&nbsp;Статус:</td>
            <td class=td1_right>
                <select name=state id="state" style="width: 20%;" class=field>
                    <option value="1" <?php if ($this->_tpl_vars['edit_code']['state'] == '1'): ?>selected=true<?php endif; ?>>Активный</option>
                    <option value="0" <?php if ($this->_tpl_vars['edit_code']['state'] == '0'): ?>selected=true<?php endif; ?>>Ждёт</option>
                </select>
            </td>
        </tr>

        <tr class=table_content>
            <td class=td1_left>&nbsp;Скидка (в процентах):</td>
            <td class=td1_right><input type=text id="percent" name=percent style="width:20%;" class=field value="<?php echo $this->_tpl_vars['edit_code']['percent']; ?>
" /></td>
        </tr>

    </table>
    <br>
    <div class="add_but" id="addCode"><div>
        <a href=""><?php if (! empty ( $this->_tpl_vars['edit_code']['code'] )): ?>Изменить<?php else: ?>Добавить код<?php endif; ?></a>
    </div>

</form>
<?php echo '
<script type="text/javascript">
    var onSubmit = function(){
        /*var
                id = this.id,
                name = this.name,
                state = this.state;

        name = name.value;
        name = new String(name).replace(/(^\\s{1,})|(\\s{1,}$)/g,\'\');


        if (!/^([0-9a-z]{3,})$/i.test(name)){
            alert(\'Верный формат промо кода: символы [a-zA-Z0-9] длиной более 3х\');
            return false;
        }*/

        var code = document.getElementById(\'code\').value;
        if (!/^([0-9a-z]{3,})$/i.test(code)){
            alert(\'Введите код в формате латинских букв и цифр. (более 3х)\');
            return false;
        }

        addForm.submit();

    };
    var onClick = function(e){
        e.preventDefault();
        return onSubmit();
    };
    var addButton = document.getElementById(\'addCode\'),
        addForm = document.getElementById(\'addCodeForm\');

    addButton.addEventListener(\'click\', onClick, false);
    addForm.addEventListener(\'submit\', function(e){e.preventDefault();}, false);

</script>
'; ?>