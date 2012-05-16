<?php
function smarty_modifier_get_order_status($status)
{
	switch ($status)
	{
		case 0:
			return '<span style="color:#e07e13;">Ожидание</span>';
		break;
		case 1:
			return '<span style="color:#e07e13;">Выполняется</span>';
		break;
		case 2:
			return '<span style="color:green;">Выполнен</span>';
		break;
	}
}

/* vim: set expandtab: */

?>
