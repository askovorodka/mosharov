<?php
function smarty_modifier_format_number($number)
{
	if ($number - intval($number) > 0)
		return number_format($number, 1, '.', '');
	else
		return intval($number);
}

/* vim: set expandtab: */

?>
