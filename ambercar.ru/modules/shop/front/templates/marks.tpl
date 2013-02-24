        <div>
        <h1>Каталог запчастей</h1>
        <div class="catalog">
        	{foreach from=$marks item=mark}
        		<div>
        			{$mark.name|strip_tags}
        			
        			{if $mark.models}
        				<ul>
        				{foreach from=$mark.models item=model}
        					<li><a href="{$base_url}/{$model.full_url}/">{$model.name|strip_tags}</a></li>
        				{/foreach}
        				</ul>
        			{/if}
        			
        		</div>
        	{/foreach}
        </div>
        </div>
