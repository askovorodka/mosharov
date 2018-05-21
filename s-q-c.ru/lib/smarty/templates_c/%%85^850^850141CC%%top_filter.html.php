<?php /* Smarty version 2.6.11, created on 2018-04-05 12:40:13
         compiled from /home/a0031953/domains/s-q-c.ru/public_html/conf/../modules/shop/front/templates/top_filter.html */ ?>
<div class="filters">
    <form id="filter">
    <div class="filters__items">

        <?php if (! empty ( $this->_tpl_vars['filter_brands']['elements_array'] )): ?>
        <div class="filters__items__item">
            <div class="filters__items__item_title">Бренд:</div>
                <?php $_from = $this->_tpl_vars['filter_brands']['elements_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                    <div class="size" data-value="<?php echo $this->_tpl_vars['item']; ?>
" data-type="brand" data-property_id="<?php echo $this->_tpl_vars['filter_brands']['property_id']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</div>
                <?php endforeach; endif; unset($_from); ?>
        </div>
        <?php endif; ?>

        <?php if (! empty ( $this->_tpl_vars['filter_sizes'] )): ?>
        <div class="filters__items__item">
            <div class="filters__items__item_title">Размер:</div>
                <?php $_from = $this->_tpl_vars['filter_sizes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                <div class="size" data-value="<?php echo $this->_tpl_vars['item']; ?>
" data-type="size"><?php echo $this->_tpl_vars['item']; ?>
</div>
                <?php endforeach; endif; unset($_from); ?>
        </div>
        <?php endif; ?>

        <?php if (! empty ( $this->_tpl_vars['filter_colors'] )): ?>
        <div class="filters__items__item">
            <div class="filters__items__item_title">Цвет:</div>
                <?php $_from = $this->_tpl_vars['filter_colors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                    <div class="color" style="background:<?php echo $this->_tpl_vars['item']; ?>
;" data-value="<?php echo $this->_tpl_vars['item']; ?>
" data-type="color"></div>
                <?php endforeach; endif; unset($_from); ?>
        </div>
        <?php endif; ?>

        <?php if (! empty ( $this->_tpl_vars['filterPrices']['max'] )): ?>
        <div class="filters__items__item">
            <div class="filters__items__item_title">Цена:</div>
            <div class="clearfix">
                <input id="filters__items__item_input_from" class="filters__items__item_input form_input g-pull-left" data-val="0" type="text" value="0"/>
                <input id="filters__items__item_input_to" class="filters__items__item_input form_input g-pull-right" data-val="<?php echo $this->_tpl_vars['filterPrices']['max']; ?>
" type="text" value="<?php echo $this->_tpl_vars['filterPrices']['max']; ?>
"/>
            </div>
            <div class="filters__items__item_range" id="filters__items__item_range">
                <div class="filters__items__item_range_active" id="filters__items__item_range_active"></div>
                <div class="icon-range filters__items__item_range_toggler" id="filters__items__item_range--first"></div>
                <div class="icon-range filters__items__item_range_toggler" id="filters__items__item_range--second"></div>
            </div>
        </div>
        <?php endif; ?>
        
    </div>
    </form>
</div>

<?php echo '
<script type="text/javascript">

    var filterForm = null, startPrice = null, endPrice = null, startPriceInput, endPriceInput;
    var getItemsBeforeSend = function(form)
    {
        var items = $(".selected",$(form)),
            data = {};
        if (items.length)
        {
            $(items).each(function(){
                if ($.inArray($(this).data(\'type\'), Object.keys(data)) < 0 ){
                //if (typeof data[$(this).data(\'type\')] == \'undefined\'){
                    data[$(this).data(\'type\')] = [];
                }
                //data[$(this).data(\'type\')].push($(this).data(\'value\'));
                if ($(this).data(\'property_id\')){
                    data[$(this).data(\'type\')].push({\'value\' : $(this).data(\'value\'), \'property_id\' : $(this).data(\'property_id\')});
                } else {
                    data[$(this).data(\'type\')].push($(this).data(\'value\'));
                }

            });
        }
        data[\'price_start\'] = parseInt($("#filters__items__item_input_from").val());
        data[\'price_end\'] = parseInt($("#filters__items__item_input_to").val());

        var url = location.href;
        url = url.match(/([^\\?]+)/)[1];
        url = url + \'?json=true\';

        $.ajax({
            type:\'post\',
            url: url,
            data: data,
            success: function(response)
            {
                var html = $.parseHTML(response);
                $(".catalog").empty();
                $(".catalog").append($(html));
            },
            error: function(response)
            {

            }
        });

    }

    var getHash = function(filterData)
    {
        var result = $.ajax({
            type:\'post\',
            url:location.protocol + \'://\' + location.hostname + \'/catalog/?filterhash\',
            cache:false,
            data:filterData
        }).done(function() {
            result = this;
            return typeof result[\'data\'] == \'string\' ? result[\'data\'] : null;
        });
    }

    var onPriceChange = function(event)
    {
        event.preventDefault();
        event.stopPropagation();
        getItemsBeforeSend(filterForm);
    }

    var checkPrices = function()
    {
        var localStartPrice = parseInt(startPriceInput.value),
            localEndPrice = parseInt(endPriceInput.value);

        if (localStartPrice != startPrice || localEndPrice != endPrice)
        {
            startPrice = localStartPrice;
            endPrice = localEndPrice;
            getItemsBeforeSend(filterForm);
        }

    }

    var onReady = function(){
        var request = [];
        var check_sizes = [];
        var url = location.href;
        filterForm = $("form#filter"),
        startPriceInput=document.getElementById("filters__items__item_input_from"),
        endPriceInput=document.getElementById("filters__items__item_input_to");
        startPrice = startPriceInput.value;
        endPrice = endPriceInput.value;

        $(".size,.color", $(".filters__items__item")).click(function(event){
            //делаем задержку
            $({}).delay(500).queue(function(){
                getItemsBeforeSend(filterForm);
            });

        });

        $(document).on(\'click\', \'.catalog__item__info_button:not(.later_btn)\', function () {
            var productId = $(this).data(\'product_id\');
            if (productId)
            {
                $.ajax({
                    type:\'post\',
                    url: location.protocol + \'//\' + location.hostname + \'/catalog/order_later/add/\',
                    data: {\'product_id\' : productId},
                    success: function(response){
                        //alert(\'Товар отложен на потом.\');
                        location.reload();
                    }
                })
            }
        });

        $(document).on(\'click\', \'.later_btn\', function(event){
            var product_id = parseInt($(this).data(\'product_id\'));
            var url = location.protocol + \'//\' + location.hostname + \'/catalog/order_later/delete/\' + product_id + \'/\';
            if (true){
                location.href = url;
            }
        });


        window.setInterval(checkPrices, 2000);
    };

    document.addEventListener(\'DOMContentLoaded\', onReady, false);
</script>
'; ?>