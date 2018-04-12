<?php /* Smarty version 2.6.11, created on 2016-07-21 01:22:26
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/shop/front/templates/order_notice.txt */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

	<title>Заказ в магазине s-q-c.ru</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!--[if !mso]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--<![endif]-->

    <style type="text/css">
	<?php echo '
        body { width: 100%; background-color: #F7F7F7; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; font-family: Arial, Times, serif }
        table { border-collapse: collapse !important; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }

        @-ms-viewport{ width: device-width; }

        @media only screen and (max-width: 639px){
        .wrapper{ width:100%;  padding: 0 !important; }
        }

        @media only screen and (max-width: 480px){
        .centerClass{ margin:0 auto !important; }
        .wrapper{ width:320px; padding: 0 !important; }
        .container{ width:300px;  padding: 0 !important; }
        .mobile{ width:300px; display:block; padding: 0 !important; text-align:center !important;}
        *[class="mobileOff"] { width: 0px !important; display: none !important; }
        *[class*="mobileOn"] { display: block !important; max-height:none !important; }
        }
	'; ?>

    </style>

	<!--[if gte mso 15]>
	<style type="text/css">
		<?php echo '
		table { font-size:1px; line-height:0; mso-margin-top-alt:1px;mso-line-height-rule: exactly; }
		* { mso-line-height-rule: exactly; }
		'; ?>

	</style>
	<![endif]-->

</head>
<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" style="background-color:#F7F7F7;  font-family:Arial,serif; margin:0; padding:0; min-width: 100%; -webkit-text-size-adjust:none; -ms-text-size-adjust:none;">

    <!-- START HEADER -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" st-sortable="header">
        <tr>
            <td width="100%" valign="top" align="center">

                <!-- Start Wrapper  -->
                <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper">
                    <tr>
                        <td align="center">

                            <!-- Start Container  -->
                            <table width="640" cellpadding="0" cellspacing="0" border="0" class="container">
                                <tr>
                                    <td height="20" style="font-size:10px; line-height:10px;"> </td><!-- Spacer -->
                                </tr>
                                <tr>
                                    <td width="320" class="mobile">
                                        <img src="http://s-q-c.ru/templates/img/logo_black.png" width="97" height="29" style="margin:0 auto; padding:0; border:none; display:block;" border="0" class="centerClass" alt="SQC" st-image="image" />
                                    </td>
                                </tr>
                                <tr>
                                    <td height="20" style="font-size:10px; line-height:10px;"> </td><!-- Spacer -->
                                </tr>
                            </table>
                            <!-- Start Container  -->

                        </td>
                    </tr>
                </table>
                <!-- End Wrapper  -->

            </td>
        </tr>
    </table>
    <!-- END HEADER -->

    <!-- START SEPARATOR -->
    <table width="100%" st-sortable="separator">
        <tr>
            <td>
                <table width="640" class="container">
                    <tr>
                        <td height="20" style="font-size:10px; line-height:10px;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- END SEPARATOR -->

    <!-- START GREETINGS -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr>
            <td width="100%" valign="top" align="center">
                <!-- Start Wrapper -->
                <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper">
                    <tr>
                        <td align="center" style="font-size: 24px;line-height:28px;" st-content="title">
                            Большое спасибо вам за заказ, <?php echo $this->_tpl_vars['name']; ?>
!
                        </td>
                   </tr>
                </table>
                <!-- End Wrapper -->
            </td>
        </tr>
    </table>
    <!-- END GREETINGS -->

    <!-- START SEPARATOR -->
    <table width="100%" st-sortable="separator">
        <tr>
            <td>
                <table width="640" class="container">
                    <tr>
                        <td height="20" style="font-size:10px; line-height:10px;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- END SEPARATOR -->

    <!-- START TEXT -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" st-sortable="title+text">
        <tr>
            <td width="100%" valign="top" align="center">

                <!-- Start Wrapper -->
                <table width="640" cellpadding="0" cellspacing="0" align="center" border="0" class="wrapper">
                    <tbody>
                        <tr>
                            <td align="center" st-content="order-details">

                                <!-- Start Container -->
                                <table width="640" cellpadding="0" cellspacing="0" align="center" border="0" class="container">
                                    <tr>
                                        <td height="20" style="line-height:20px; font-size:20px;" bgcolor="#ffffff"> </td><!-- Spacer -->
                                    </tr>
                                    <tr>
                                        <td align="center" style="font-family:Arial, sans serif; font-size: 24px; line-height:24px; padding:0 20px;" bgcolor="#ffffff">
                                            Детали вашего заказа:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" style="line-height:20px; font-size:20px;" bgcolor="#ffffff"> </td><!-- Spacer -->
                                    </tr>
                                    <tr>
                                        <td height="1" style="line-height:1px; font-size:1px;"> </td><!-- Spacer -->
                                    </tr>
                                    <tr>
                                        <td align="left" style="font-family:Arial, sans serif; font-size: 14px; line-height:20px; padding:12px 20px;" bgcolor="#ffffff">
                                            Номер заказа <span style="color: #999999; padding: 0 5px;">&mdash;</span> <?php echo $this->_tpl_vars['order_id']; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="1" style="line-height:1px; font-size:1px;"> </td><!-- Spacer -->
                                    </tr>
                                    <?php if (! empty ( $this->_tpl_vars['promoSale'] )): ?>
                                        <tr>
                                            <td align="left" style="font-family:Arial, sans serif; font-size: 14px; line-height:20px; padding:12px 20px;" bgcolor="#ffffff">
                                                Скидка по промо-коду: <span style="color: #999999; padding: 0 5px;">&mdash;</span> <?php echo $this->_tpl_vars['promoSale']; ?>
 руб.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="1" style="line-height:1px; font-size:1px;"> </td><!-- Spacer -->
                                        </tr>
                                    <?php endif; ?>

                                    <?php if (! empty ( $this->_tpl_vars['registerSale'] )): ?>
                                        <tr>
                                            <td align="left" style="font-family:Arial, sans serif; font-size: 14px; line-height:20px; padding:12px 20px;" bgcolor="#ffffff">
                                                Скидка за регистрацию: <span style="color: #999999; padding: 0 5px;">&mdash;</span> <?php echo $this->_tpl_vars['registerSale']; ?>
 руб.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="1" style="line-height:1px; font-size:1px;"> </td><!-- Spacer -->
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td align="left" style="font-family:Arial, sans serif; font-size: 14px; line-height:20px; padding:12px 20px;" bgcolor="#ffffff">
                                            Сумма заказа <span style="color: #999999; padding: 0 5px;">&mdash;</span> <?php echo $this->_tpl_vars['order_total']; ?>
 руб.  плюс доставка: <?php echo $this->_tpl_vars['delivery']; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="1" style="line-height:1px; font-size:1px;"> </td><!-- Spacer -->
                                    </tr>
                                    <tr>
                                        <td height="1" style="line-height:1px; font-size:1px;"> </td><!-- Spacer -->
                                    </tr>
                                    <tr>
                                        <td align="left" style="font-family:Arial, sans serif; font-size: 14px; line-height:20px; padding:12px 20px;" bgcolor="#ffffff">
                                            Адрес доставки <span style="color: #999999; padding: 0 5px;">&mdash;</span> <?php echo $this->_tpl_vars['address']; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="1" style="line-height:1px; font-size:1px;"> </td><!-- Spacer -->
                                    </tr>
                                    <tr>
                                        <td align="left" style="font-family:Arial, sans serif; font-size: 14px; line-height:20px; padding:12px 20px;" bgcolor="#ffffff">
                                            Телефон <span style="color: #999999; padding: 0 5px;">&mdash;</span> <?php echo $this->_tpl_vars['phone']; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="1" style="line-height:1px; font-size:1px;"> </td><!-- Spacer -->
                                    </tr>
                                    <tr>
                                        <td align="left" style="font-family:Arial, sans serif; font-size: 14px; line-height:20px; padding:12px 20px;" bgcolor="#ffffff">
                                            Ваш комментарий <span style="color: #999999; padding: 0 5px;">&mdash;</span> <?php echo $this->_tpl_vars['comment']; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" style="line-height:20px; font-size:20px;" bgcolor="#ffffff"> </td><!-- Spacer -->
                                    </tr>
                                </table>
                                <!-- End Container -->

                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- End Wrapper -->

            </td>
        </tr>
    </table>
    <!-- END TEXT -->

    <!-- START SEPARATOR -->
    <table width="100%" st-sortable="separator">
        <tr>
            <td>
                <table width="640" class="container">
                    <tr>
                        <td height="20" style="font-size:10px; line-height:10px;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- END SEPARATOR -->

    <!-- START ITEMS LIST TITLE -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr>
            <td width="100%" valign="top" align="center">
                <!-- Start Wrapper -->
                <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper">
                    <tr>
                        <td align="center" style="font-size: 20px;line-height:24px;" st-content="title">
                            Выбранные вами товары:
                        </td>
                    </tr>
                </table>
                <!-- End Wrapper -->
            </td>
        </tr>
    </table>
    <!-- START ITEMS LIST TITLE -->

    <!-- START SEPARATOR -->
    <table width="100%" st-sortable="separator">
        <tr>
            <td>
                <table width="640" class="container">
                    <tr>
                        <td height="10" style="font-size:10px; line-height:10px;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- END SEPARATOR -->

    <!-- START TEXT -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" st-sortable="title+text">
        <tr>
            <td width="100%" valign="top" align="center">

                <!-- Start Wrapper -->
                <table width="640" cellpadding="0" cellspacing="0" align="center" border="0" class="wrapper">
                    <tbody>
                    <tr>
                        <td align="center" st-content="order-details">

                            <!-- Start Container -->
                            <table width="640" cellpadding="0" cellspacing="0" align="center" border="0" class="container">
                                <tr>
                                    <td align="left" style="font-family:Arial, sans serif; font-size: 12px; color: #666666; line-height:16px; padding:0 0 5px 10px;">
                                        №
                                    </td>
                                    <td align="left" style="font-family:Arial, sans serif; font-size: 12px; color: #666666; line-height:16px; padding:0 0 5px 5px;">
                                        Наименование
                                    </td>
                                    <td align="left" style="font-family:Arial, sans serif; font-size: 12px; color: #666666; line-height:16px; padding:0 0 5px 5px;">
                                        Кол-во
                                    </td>
                                    <td align="left" style="font-family:Arial, sans serif; font-size: 12px; color: #666666; line-height:16px; padding:0 0 5px 5px;">
                                        Свойства
                                    </td>
                                    <td align="left" style="font-family:Arial, sans serif; font-size: 12px; color: #666666; line-height:16px; padding:0 0 5px 5px;">
                                        Цена
                                    </td>
                                </tr>
                                <?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['for1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['for1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product']):
        $this->_foreach['for1']['iteration']++;
?>
                                    <tr>
                                        <td align="left" style="font-family:Arial, sans serif; font-size: 14px; line-height:20px; padding:12px 0 12px 10px;" bgcolor="#ffffff"><?php echo $this->_foreach['for1']['iteration']; ?>
</td>
                                        <td align="left" style="font-family:Arial, sans serif; font-size: 14px; line-height:20px; padding:12px 0 12px 5px;" bgcolor="#ffffff"><?php echo $this->_tpl_vars['product']['details']['name']; ?>
</td>
                                        <td align="left" style="font-family:Arial, sans serif; font-size: 14px; line-height:20px; padding:12px 0 12px 5px;" bgcolor="#ffffff"><?php echo $this->_tpl_vars['product']['count']; ?>
</td>
                                        <td align="left" style="font-family:Arial, sans serif; font-size: 14px; line-height:20px; padding:12px 0 12px 5px;" bgcolor="#ffffff">
                                        <?php if (! empty ( $this->_tpl_vars['product']['properties'] )): ?>
                                            <?php $_from = $this->_tpl_vars['product']['properties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['forP'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['forP']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['property']):
        $this->_foreach['forP']['iteration']++;
?>
                                                <?php if ($this->_tpl_vars['key'] == 'name'): ?>
                                                    Цвет: <?php echo $this->_tpl_vars['property']; ?>
; 
                                                <?php endif; ?>
                                                <?php if ($this->_tpl_vars['key'] == 'size'): ?>
                                                    Размер: <?php echo $this->_tpl_vars['property']; ?>
; 
                                                <?php endif; ?>
                                            <?php endforeach; endif; unset($_from); ?>
                                        <?php endif; ?>
                                        </td>
                                        <td align="left" style="font-family:Arial, sans serif; font-size: 14px; line-height:20px; padding:12px 5px 12px 5px;" bgcolor="#ffffff"><?php echo $this->_tpl_vars['product']['price']; ?>
</td>
                                    </tr>
                                    <tr>
                                        <td height="2" style="line-height:6px; font-size:6px;"> </td><!-- Spacer -->
                                    </tr>
                                <?php endforeach; endif; unset($_from); ?>
                            </table>
                            <!-- End Container -->

                        </td>
                    </tr>
                    </tbody>
                </table>
                <!-- End Wrapper -->

            </td>
        </tr>
    </table>
    <!-- END TEXT -->

    <!-- START SEPARATOR -->
    <table width="100%" st-sortable="separator">
        <tr>
            <td>
                <table width="640" class="container">
                    <tr>
                        <td height="20" style="font-size:10px; line-height:10px;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- END SEPARATOR -->
</body>
</html>