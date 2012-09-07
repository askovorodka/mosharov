<?php /* Smarty version 2.6.11, created on 2012-02-07 16:23:29
         compiled from /home/alex/data/www/shop-toy.mosharov.com/modules/cabinet/front/templates/cabinet_register_basket.html */ ?>

<?php if ($this->_tpl_vars['registration_success'] == '1'): ?>
Благодарим за регистрацию!<br><br>
На указанный Вами почтовый адрес было выслано письмо с Вашими регистрационными данными. Теперь Вы можете войти в свой личный кабинет.
<?php else: ?>

<form id="register_user_form" method="POST" action="<?php echo @DOMAIN; ?>
/cabinet/register/">
<input type="hidden" name="submit_user_register" value="1">
<input type="hidden" name="basket" value="1">
	<div id="register_user">
		<div class="regfield">ФИО:</div><div class="reginput"><input type="text" name="username"></div>
		<div class="regfield">Телефон (с кодом):</div><div class="reginput"><input type="text" name="phone"></div>
		<div class="regfield">E-mail:</div><div class="reginput"><input type="text" name="useremail"></div>
		<div class="regfield">Адрес (для доставки):</div><div class="reginput"><input type="text" name="address"></div>
		<div class="regfield">Если хотите зарегистрироваться введите пароль:</div>
		<div class="reginput"><input type="password" name="pass"></div>
	</div>
</form>


<?php endif; ?>
