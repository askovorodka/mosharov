	<table class="news" cellspacing="0" cellpadding="20">
	  <tr>
	  	{foreach from=$news_list_eng item=news}
			<td><img src="{$base_url}/uploaded_files/news/{$news.image}" align="left">
			<span id="date">{$news.publish_date|date_format:"%d.%m.%Y"}</span><br>
			<a href="{$base_url}/news/archive/{$news.id}/">{$news.small_text}</a></td>
		{/foreach}
	  </tr>
	</table>
