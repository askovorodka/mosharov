        <div>
        <h1>Каталог запчастей {$mark.name|strip_tags}</h1>
        <div class="catalog">
        	<ul style="list-style-type:none;">
        	{foreach from=$models item=model}
        		
        		<li><a href="{$base_url}/{$model.full_url}/">{$model.name|strip_tags}</a></li>
        		
        	{/foreach}
        	</ul>
        </div>
        
        {if $mark.text}
        	<p>{$mark.text}</p>
        {/if}
        
        </div>
