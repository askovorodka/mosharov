{foreach from=$main_menu item=menu}
	<a href="{$base_url}/{$menu.url}/">{$menu.name}</a>
{/foreach}