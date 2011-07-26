	        {foreach from=$shop_menu item=item1 name=shop_menu}
	        	{if $item1.param_level == '1'}<a href="#" class="lmenuf" id="item_{$item1.id}">{$item1.name|strip_tags}</a>{/if}
		        	<div style="display:
			{*if !$parent}
			{if $item1.id == $smarty.const.DISK_ID}block{else}none{/if}
			{else*}
				{if $parent.id == $item1.id}block{else}none{/if}
			{*/if*}
			;" id="subitem_item_{$item1.id}" class="submenu">
			        	{foreach from=$shop_menu item=item2}
			        		{if $item2.param_left > $item1.param_left && $item2.param_right < $item1.param_right && $item2.param_level == '2'}
			        			<a href="{$base_url}/shop/{$item2.parent_url|urlencode}/{$item2.url|urlencode}/" class="lmenus{if $parent2.id == $item2.id}it{/if}">{$item2.name|strip_tags}</a>
			        		{/if}
			        	{/foreach}
		        	</div>
	        {/foreach}
	        
	        {foreach from=$left_menu item=lmenu}
            	<a href="{$base_url}/{$lmenu.url}/" class="lmenuf2">{$lmenu.name|strip_tags}</a>
            {/foreach}