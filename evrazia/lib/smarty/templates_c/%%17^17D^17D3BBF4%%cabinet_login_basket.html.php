<?php /* Smarty version 2.6.11, created on 2012-02-07 16:23:29
         compiled from /home/alex/data/www/shop-toy.mosharov.com/modules/cabinet/front/templates/cabinet_login_basket.html */ ?>

			<form id="login_user_form" method="POST" action="<?php echo @DOMAIN; ?>
/cabinet/login/">
				<input type=hidden name=submit_login_basket value=1>
				<input type=hidden name=submit_login value=1>
	            <table class="reg" width="100%" border="0" cellspacing="0" cellpadding="0">
	              <tr>
	                <td class="regt" style="width:230px; height:80px;"><a href="" id="question" register="0">Вы уже зарегистрированны ?</a></td>
	                <td style="width:250px; height:80px;">
	                <div id="login_user" style="display:none;">
	                 <div class="regin">E-mail: <input type="text" name="login_email"></div>
	           		 <div class="regin">Пароль: <input type="password" name="login_pass"></div>
	           		 </div>
	                </td>
	              </tr>
	            </table>
	        </form>