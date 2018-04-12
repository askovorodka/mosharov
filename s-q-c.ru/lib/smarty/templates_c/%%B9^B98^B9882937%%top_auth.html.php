<?php /* Smarty version 2.6.11, created on 2016-04-28 15:01:25
         compiled from /home/a0031953/domains/s-q-c.ru/public_html/conf/../templates/blocks/top_auth.html */ ?>
<div class="auth g-hidden" id="auth">

    <div class="auth__form">
        <img src="<?php echo $this->_tpl_vars['template_image']; ?>
logo_black.png" width="97" height="29">

        <div class="auth_block">
            <input type="text" id="auth_username" name="username" class="form_input" placeholder="Электронная почта" />
            <input type="password" name="password" id="auth_password" class="form_input" placeholder="Пароль" />
            <div class="form_button g-full-width" id="auth_send">Войти</div>
            <a href="/cabinet/restore/" class="restore_password">Восстановить пароль</a>
        </div>

    </div>

</div>

<?php echo '
<script type="text/javascript">

    var onReady = function(e){


    }

    document.addEventListener(\'DOMContentLoaded\', onReady, false);

</script>
'; ?>
