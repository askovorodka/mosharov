
<table width=100% cellspacing=1 cellpadding=3 border=0>

    {foreach from=$items item=news}


			<tr>

				<td><small>[{$news.publish_date|date_format:"%d.%m.%Y %H:%M"}]</small> <b>{$news.title}</b><br>

					{if $news.image!=''}

						<br><img src={$base_url}/uploaded_files/news/{$news.image} align=left>

					{/if}

					{$news.small_text}

					{if $news.text!=''}

						<br>[<a href={$module_url}/archive/{$news.id}>������ ������</a>]

					{/if}

				</td>

			</tr>

			<tr height="10"><td></td></tr>


  {/foreach}

</table>
