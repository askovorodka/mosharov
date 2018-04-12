<?php /* Smarty version 2.6.11, created on 2015-12-13 23:05:23
         compiled from /var/www/sqc/conf/../modules/shop/front/templates/top_filter.html */ ?>
<div class="filters">
    <div class="filters__items">
        <div class="filters__items__item">
            <div class="filters__items__item_title">Бренд:</div>
            <?php if (! empty ( $this->_tpl_vars['filter_brands']['elements_array'] )): ?>
                <?php $_from = $this->_tpl_vars['filter_brands']['elements_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                    <div class="size"><?php echo $this->_tpl_vars['item']; ?>
</div>
                <?php endforeach; endif; unset($_from); ?>
            <?php endif; ?>
        </div>
        <div class="filters__items__item">
            <div class="filters__items__item_title">Размер:</div>
            <?php if (! empty ( $this->_tpl_vars['filter_sizes']['elements_array'] )): ?>
                <?php $_from = $this->_tpl_vars['filter_sizes']['elements_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                <div class="size" data-value="<?php echo $this->_tpl_vars['item']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</div>
                <?php endforeach; endif; unset($_from); ?>
            <?php endif; ?>
        </div>
        <div class="filters__items__item">
            <div class="filters__items__item_title">Цвет:</div>
            <?php if (! empty ( $this->_tpl_vars['filter_colors']['elements_array'] )): ?>
                <?php $_from = $this->_tpl_vars['filter_colors']['elements_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                    <div class="color" style="background:<?php echo $this->_tpl_vars['item']; ?>
;"></div>
                <?php endforeach; endif; unset($_from); ?>
            <?php endif; ?>
        </div>
        <div class="filters__items__item">
            <div class="filters__items__item_title">Цена:</div>
            <div class="clearfix">
                <input id="filters__items__item_input_from" class="filters__items__item_input form_input g-pull-left" data-val="0" type="text" value="0"/>
                <input id="filters__items__item_input_to" class="filters__items__item_input form_input g-pull-right" data-val="15000" type="text" value="15000"/>
            </div>
            <div class="filters__items__item_range" id="filters__items__item_range">
                <div class="filters__items__item_range_active" id="filters__items__item_range_active"></div>
                <div class="icon-range filters__items__item_range_toggler" id="filters__items__item_range--first"></div>
                <div class="icon-range filters__items__item_range_toggler" id="filters__items__item_range--second"></div>
            </div>
        </div>
    </div>
</div>

<?php echo '
<script type="text/javascript">
    var onReady = function(){
        var request = [];
        var check_sizes = [];

        var url = location.href;

        $(".size").click(function(){
            //check_sizes.push($(this).data(\'value\'));
            url = new String(url).replace(/(\\?|\\&)?sizes\\=([^\\&]+)/g,\'\');
            url = url + \'?sizes=\' + $(this).data(\'value\');
            location.href = url;
        });

        /*if (check_sizes.length)
        {
            request.push(\'sizes=\' + check_sizes.join());
        }

        return request.length ? \'?\' + request.join(\'&\') : null;*/

    };
    document.addEventListener(\'DOMContentLoaded\', onReady, false);
</script>
'; ?>