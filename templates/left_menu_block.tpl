{foreach from=$documents item=document}
<a href="{$base_url}/{$document.url}/item_{$document.id}/" title="{$document.title|strip_tags}">{$document.title|strip_tags}</a>
{/foreach}