<?php /* Smarty version 2.6.11, created on 2016-04-28 14:59:17
         compiled from /home/a0031953/domains/s-q-c.ru/public_html/conf/../templates/blocks/footer.html */ ?>
<footer class="footer">

    <?php echo '
    <script type="text/javascript">
        var currentUserInfo = ';  if (! empty ( $this->_tpl_vars['currentUserJson'] )):  echo $this->_tpl_vars['currentUserJson'];  else: ?>null<?php endif;  echo ';

        $(document).on(\'click\', \'.restore_password\', function(event){
            alert(1);
            event.preventDefault();
            $(\'.auth_block\').hide();
            $(\'.restore_block\').show();
        });

        $(document).on(\'click\', \'.restore_password\', function(event){
            console.log(444);
        });

    </script>
    '; ?>


    <div class="container">
        <div class="footer__menu">
            <a href="/about_shop/" data-ydwidget-open>О магазине</a>
            <a href="/dostavka/">Доставка и оплата</a>
            <a href="/contacts/">Контакты</a>
        </div>
        <div class="footer__info">
            <!--<span class="footer__info-item"><span class="g-text-light-gray">Мы находимся:</span> г. Москва, ул. Тверская, дом 10.</span>-->
            <span class="footer__info-item"><span class="g-text-light-gray">Тел:</span> 8 (925) 329-320-9</span>
            <span class="footer__info-item"><span class="g-text-light-gray">Email:</span> <a href="mailto:info@s-q-c.ru">info@s-q-c.ru</a></span>
        </div>
    </div>
</footer>
<div id="ydwidget" class="yd-widget-modal"></div>