<div>
        <h1>{$product.name|strip_tags}</h1>
        {foreach from=$images item=image}
        	<img class="bimage" src="{$DOMAIN}/images/img400x300/uploaded_files/shop_images/{$image.image}" width="400" height="300" />
        {/foreach}
        <p><strong>������������:</strong> {$product.name|strip_tags}</p>
        <p><strong>�������:</strong> {$product.article}</p>
        <p><strong>���������� �� ������:</strong> {$product.sklad} ��.</p>
        <p><strong>����:</strong> {$product.price|format_price} ���.</p>
        <p>{$product.description}</p>
</div>