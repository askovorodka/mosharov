{if $top_product}
<div class="lmenu">
<img src="{$template_image}left_top.png" width="167" height="11" vspace="0"><br>
<div class="lban">
<center><span style="font-size:16px;color:#185f95;text-decoration:underline;text-align:center;">Рекомендуем</span><br><br>
<a href="#" style="font-size:12px;color:#e07e13;line-height:16px;text-decoration:underline;font-weight:bold;">{$top_product.name|strip_tags}</a></span><br><br>
<span style="font-size:20px;color:#2e2e2e;">15000</span> <span style="font-size:16px;color:#7c7c7c;">руб.</span></center>
</div>
<img src="{$template_image}left_bot.png" width="167" height="11" vspace="0"><br>
</div>
{/if}