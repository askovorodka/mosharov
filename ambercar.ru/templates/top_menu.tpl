{foreach from=$main_menu item=menu}
	<a {if $node_content.id == $menu.id}class="selected"{/if} href="{$base_url}/{$menu.url}/">{$menu.name}</a>
{/foreach}
