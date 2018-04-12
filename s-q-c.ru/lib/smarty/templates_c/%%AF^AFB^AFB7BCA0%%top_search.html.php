<?php /* Smarty version 2.6.11, created on 2016-02-26 19:54:14
         compiled from /home/a0031953/domains/s-q-c.ru/public_html/conf/../templates/blocks/top_search.html */ ?>
<div class="tools">
    <div class="tools__search">
        <form action="<?php echo $this->_tpl_vars['base_url']; ?>
/catalog/" method="get">
            <div class="icon-search tools__search__icon"></div>
            <input type="text" name="search_product" placeholder="Ищу по артикулу и названию" value="<?php echo $this->_tpl_vars['search_string']; ?>
"/>
        </form>
    </div>
    <div class="tools__second-menu">
        <?php $_from = $this->_tpl_vars['main_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['for1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['for1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['menu']):
        $this->_foreach['for1']['iteration']++;
?>
            <?php if (($this->_foreach['for1']['iteration'] == $this->_foreach['for1']['total']) && ! empty ( $this->_tpl_vars['order_later_count'] )): ?>
                <div class="tools__second-menu__wishlist"><a href="/catalog/order_later/" title="Товары отложенные на потом">На потом: <?php echo $this->_tpl_vars['order_later_count']; ?>
</a></div>
            <?php endif; ?>
            <a href="<?php echo $this->_tpl_vars['base_url']; ?>
/<?php echo $this->_tpl_vars['menu']['url']; ?>
/" <?php if ($this->_tpl_vars['current_url'] == $this->_tpl_vars['menu']['url']): ?>class="tools__second-menu__wishlist"<?php endif; ?> title="<?php echo $this->_tpl_vars['menu']['name']; ?>
"><?php echo $this->_tpl_vars['menu']['name']; ?>
</a>
        <?php endforeach; endif; unset($_from); ?>
		<a href="#" id="lk">Войти</a>
		<a href="/cabinet/logout/" id="logout" class="g-hidden" style="color: red;">Выход</a>
    </div>
</div>

<?php echo '
<script type="text/javascript">
    var onReady = function(e){
        $(document).on(\'click\',\'.tools__search__icon\',function(){
            var form = $(this).closest(\'form\');
            var search = $("input[type=text]",$(form)).val();
            if ($.trim(search)){
                $(form).submit();
            }
        });
    }
    document.addEventListener(\'DOMContentLoaded\', onReady, false);
</script>
'; ?>