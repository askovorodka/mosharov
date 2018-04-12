<?php /* Smarty version 2.6.11, created on 2016-02-29 15:17:00
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/shop/admin/templates/shop.a_colors.html */ ?>
<?php echo '
<DIV id=dhtmltooltip></DIV>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>


<table width=100% class=content_table>
    <tr><th>Цвет</th>
        <th>Код цвета</th>
        <th>Название цвета</th>
        <th width=10%>Дата создания</th>
    <?php $_from = $this->_tpl_vars['colors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
_left><div style="display: block; width:100%; height: 20px; background-color: <?php echo $this->_tpl_vars['item']['color']; ?>
;"></div></td>
        <td class=<?php echo $this->_tpl_vars['td']; ?>
_middle><?php echo $this->_tpl_vars['item']['color']; ?>
</td>
        <td class=<?php echo $this->_tpl_vars['td']; ?>
_middle><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
        <td style="width: 120px;" class=<?php echo $this->_tpl_vars['td']; ?>
_middle align=center>
            <a href="?mod=shop&action=delete_color&color=<?php echo $this->_tpl_vars['item']['id']; ?>
" class="img_link" onclick="return confirm('Удалить цвет ?');"><img src="templates/img/ico_delete.gif" border="0"></a>
        </td></tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

<br>
<form action="" method="post" id="addColorForm">
    <input type="hidden" name="add_color" value="1" />
    <table width=100% class=content_table>
        <tr class=table_content>
            <td class=td1_left>&nbsp;Цвет:</td>
            <td class=td1_right><input type=text id="color" name=color style="width:20%;" class=field value="" /></td>

            <td class=td1_left>&nbsp;Название цвета:</td>
            <td class=td1_right><input type=text id="color_name" name=color_name style="width:20%;" class=field value="" /></td>

        </tr>
    </table>
    <br>
    <div class="add_but" id="addColor"><div>
        <a href="">Добавить цвет</a>
    </div>

</form>
<?php echo '
<script type="text/javascript">

    $(\'#color\').ColorPicker({
        color: \'#0000ff\',
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $(\'#color\').val(\'#\' + hex);
        }
    });

    var onSubmit = function(){
        var color = document.getElementById(\'color\').value;
        if (!$.trim(color)){
            alert(\'Введите код цвета\');
            return false;
        }

        addForm.submit();

    };
    var onClick = function(e){
        e.preventDefault();
        return onSubmit();
    };
    var addButton = document.getElementById(\'addColor\'),
            addForm = document.getElementById(\'addColorForm\');

    addButton.addEventListener(\'click\', onClick, false);
    addForm.addEventListener(\'submit\', function(e){e.preventDefault();}, false);



</script>
'; ?>