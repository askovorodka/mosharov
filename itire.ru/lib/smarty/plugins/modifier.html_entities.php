<?php

function smarty_modifier_html_entities($string)
{
	return htmlentities($string);
}