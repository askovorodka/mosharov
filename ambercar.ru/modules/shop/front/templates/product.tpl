<div>
        <h1>{$product.name|strip_tags}</h1>
        {foreach from=$images item=image}
        	<img class="bimage" src="{$DOMAIN}/images/img400x300/uploaded_files/shop_images/{$image.image}" width="400" height="300" />
        {/foreach}
        <p><strong>Наименование:</strong> {$product.name|strip_tags}</p>
        <p><strong>Артикул:</strong> {$product.article}</p>
        <p><strong>Количество на складе:</strong> {$product.sklad} шт.</p>
        <p><strong>Цена:</strong> {$product.price|format_price} руб.</p>
        <p>{$product.description}</p>
</div>