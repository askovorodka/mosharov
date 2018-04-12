<?php /* Smarty version 2.6.11, created on 2016-01-31 16:27:56
         compiled from /var/www/alex/data/www/scl.mosharov.com/conf/../templates/blocks/footer.html */ ?>
<footer class="footer">

    <?php echo '
    <script type="text/javascript">
        var currentUserInfo = ';  if (! empty ( $this->_tpl_vars['currentUserJson'] )):  echo $this->_tpl_vars['currentUserJson'];  else: ?>null<?php endif;  echo ';

        /*var onReady = function(){
            $.ajax({
                type:\'post\',
                data:{\'submit_login\':1, \'email\':\'shand@ya.ru\', \'password\':\'111111\'},
                url:\'/cabinet/\',
                success:function(response){
                    console.log(response);
                }
            });
        }
        document.addEventListener(\'DOMContentLoaded\', onReady, false);*/

    </script>
    '; ?>


    <div class="container">
        <div class="footer__menu">
            <a href="#">О магазине</a>
            <a href="#">Доставка и оплата</a>
            <a href="#">Возврат товара</a>
            <a href="#">Контакты</a>
        </div>
        <div class="footer__info">
            <span class="footer__info-item"><span class="g-text-light-gray">Мы находимся:</span></span> г. Москва, ул. Тверская, дом 10.</span>
            <span class="footer__info-item"><span class="g-text-light-gray">Тел:</span> 495 565 75 25</span>
            <span class="footer__info-item"><span class="g-text-light-gray">Email:</span> <a href="#">hello@s-q-c.ru</a></span>
        </div>
    </div>
</footer>