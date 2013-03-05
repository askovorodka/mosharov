{if $news_list}
<div class="news">
            {foreach from=$news_list item=news name=news}
            <p><a href="{$base_url}/news/archive/{$news.id}/">{$news.title|strip_tags}</a><br />
            {$news.small_text}
            </p>
            {/foreach}
</div>
{/if}