    <table class="menu" align="center">
      <tr>
        <td class="menus"><img src="{$template_image}tmenu_l.gif" width="17" height="46"></td>
        {foreach from=$main_menu item=menu}
        <td><a href="{$base_url}/{$menu.url}/" title="�������">{$menu.name|strip_tags}</a></td>
        {/foreach}
        <td><a href="#" title="�������">�������</a></td>
        <td><a href="#" title="� ��������">� ��������</a></td>
        <td><a href="#" title="������� �����">������� �����</a></td>
        <td><a href="#" title="����">����</a></td>
        <td><a href="#" title="���������">���������</a></td>
        <td><a href="#" title="��������">��������</a></td>
        <td class="menus"><img src="{$template_image}tmenu_r.gif" width="17" height="46"></td>
      </tr>
    </table>

