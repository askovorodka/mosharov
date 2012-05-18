<?php

function smarty_modifier_format_price($value)
{
	$value = intval($value);
	if (strlen($value) < 4)
		return $value;

	$result = strrev($value);

	$result = preg_replace('/(\d{3})/', '$1 ', $result);
	$result = strrev(trim($result));

	return $result;
}