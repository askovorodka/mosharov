<?php /* Smarty version 2.6.11, created on 2012-02-06 13:20:55
         compiled from /home/alex/data/www/shop-toy.mosharov.com/conf/../templates/filter_green.html */ ?>
<form action="<?php echo $this->_tpl_vars['DOMAIN']; ?>
/catalog/products_search/" method="get" style="margin:0px; padding:0px;">
<div class="filter">
<div class="filterinput">
	<div class="filterpadd">
	�������:
	<select class="filterselect" name="age">
    <option selected value="-">�����</option>
    <option value="0,1">0-1 ���</option>
    <option value="1,2,3">1-3 ����</option>
    <option value="3,4,5">3-6 ���</option>
    <option value="6,7,8,9">6-9 ���</option>
    <option value="9,10,11,12">9-12 ���</option>
    <option value="12">12+ ���</option>
	</select>
    <div class="filtercheck"><div class="filterch">�������</div> <input type="checkbox" name="sex" value="boy"></div>
    <div class="filtercheck"><div class="filterch">�������</div> <input type="checkbox" name="sex" value="girl"></div>
    </div>
</div>
<div class="filterinputc">
	<div class="filterpaddc">
	���������:
	<select class="filterselect" name="category">
    <option selected>��� ���������</option>
    <option>���������� �������</option>
    <option>�����</option>
    <option>&nbsp;&nbsp;- �����������</option>
    <option>&nbsp;&nbsp;- ���������</option>
    <option>���������</option>
    <option>������� ������, ������� �������</option>
	</select>
    </div>
    <div class="filterpaddcb">
    �����:
	<select class="filterselect" name="manufactury">
    <option selected>��� ������</option>
    <option>Chicco</option>
    <option>Erica</option>
    <option>Barbie</option>
	</select>
    </div>
</div>
<div class="filterinputr">
	<div class="filterpadr">
	����:&nbsp; <span class="filtertext">�� <input type="text" name="price_start"> �� <input type="text" name="parice_end"></span>
    </div>
</div>
<input type="image" class="filterbut" src="<?php echo $this->_tpl_vars['template_image']; ?>
filter_button.png" value="������ �������">
</div>
</form>