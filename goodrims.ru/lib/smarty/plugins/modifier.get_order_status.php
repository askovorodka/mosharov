<?php
function smarty_modifier_get_order_status($status)
{
	switch ($status)
	{
		case 0:
			return '<span style="color:#e07e13;">��������</span>';
		break;
		case 1:
			return '<span style="color:#e07e13;">�����������</span>';
		break;
		case 2:
			return '<span style="color:green;">��������</span>';
		break;
	}
}

/* vim: set expandtab: */

?>
