<?php

function smarty_modifier_age_postfix($value)
{
	$value = intval($value);
	if ($value == 1)
		return $value . " года";
	else 
		return $value . " лет";

}