<?php
function smarty_modifier_format_number($number)
{
	return number_format($number, 2, '.', '');
}

/* vim: set expandtab: */

?>
