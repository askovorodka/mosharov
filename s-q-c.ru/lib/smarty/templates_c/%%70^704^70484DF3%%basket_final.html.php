<?php /* Smarty version 2.6.11, created on 2016-11-20 01:18:41
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/shop/front/templates/basket_final.html */ ?>
<center>���������� ��� �� ��, ��� ������� ����� � ����� ��������. � ��������� ����� � ���� �������� ��� ��������.</center><br>
<?php echo $this->_tpl_vars['error_register_message']; ?>

<?php echo '
<script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru-RU"></script>
<script src="https://delivery.yandex.ru/widget/loader?resource_id=11119&sid=8062&key=7a260d4d1458cf32bcc155cc4d1af21c"></script>
<script type="text/javascript">
  ydwidget.ready(function(){
    ydwidget.initCartWidget({
      // ���������� �������� ���������� �������.
      \'onLoad\': function () {
        // ������������ ����� � �������� ����� ������ �� �������� ��������� ����������, ���� 
        // ����������.
        ydwidget.cartWidget.order.confirmOrder()
        .done(function (data) {
           if (data.status == \'ok\') {
             console.log(\'����� ������ �������.\', data)
            } else {
              // ��� ���������� ����������, �� ���� ����� ������ ���� �� ������, ��� ��� ��� 
              // ��������� ���������� �� ����� ������ createOrder, � ����� � cookie ��� ��������
              // ������
              console.log(\'��� �������� ������ ���� ������.\', data)
            }
        });
      }
    })
  })
</script>
'; ?>
