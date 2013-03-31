        <div>
        <h1>{$mark.name} {$model.name}</h1>
        
        <div class="sidemenu">
        	{foreach from=$types item=type}
            <a href="{$base_url}/catalog/{$mark.url}/{$model.url}/{$type.id}/">{$type.name|strip_tags}</a><br />
            {/foreach}
            </div>
        </div>
        
        <div>{$model.text}</div>
        
        </div>
