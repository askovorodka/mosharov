       <div>
        <h1>Результаты поиска по запросу: {$search}</h1>
{if $products}
        <table class="tablecat">
          <tr class="tablecapt">
            <td>Фото</td>
            <td>Артикул</td>
            <td>Наименование</td>
            <td>Кол-во</td>
            <td>Цена</td>
          </tr>
	          {foreach from=$products item=product}
		          <tr>
		            <td class="tablecatimg"><a href="{$base_url}/{$product.full_url}/{$product.product_type}"><img src="/images/img82x62/uploaded_files/shop_images/{$product.image}" width="82" height="62" /></td>
		            <td>{$product.article}</td>
		            <td class="naimenovanie"><a href="{$base_url}/{$product.full_url}/{$product.product_type}">{$product.name}</a></td>
		            <td>{$product.sklad}</td>
		            <td class="price">{$product.price|format_price} руб.</td>
		          </tr>
	          {/foreach}
        </table><br />
        
{else}
Ничего не найдено.
{/if}
        </div>
