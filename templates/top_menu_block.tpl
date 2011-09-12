    <table class="menu" align="center">
      <tr>
        <td class="menus"><img src="{$template_image}tmenu_l.gif" width="17" height="46"></td>
        {foreach from=$main_menu item=menu}
        <td><a href="{$base_url}/{$menu.url}/" title="Главная">{$menu.name|strip_tags}</a></td>
        {/foreach}
        <td><a href="#" title="Главная">Главная</a></td>
        <td><a href="#" title="О компании">О компании</a></td>
        <td><a href="#" title="Проекты домов">Проекты домов</a></td>
        <td><a href="#" title="Цены">Цены</a></td>
        <td><a href="#" title="Материалы">Материалы</a></td>
        <td><a href="#" title="Контакты">Контакты</a></td>
        <td class="menus"><img src="{$template_image}tmenu_r.gif" width="17" height="46"></td>
      </tr>
    </table>

