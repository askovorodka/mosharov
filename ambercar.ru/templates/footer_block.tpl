  <tr>
    <td height="100">
    	<div class="botmenu{if !$home}inner{/if}">
        <div class="blinks"><h3>����������</h3>
        <a href="#">����������</a><br />
        <a href="#">�������</a><br />
        <a href="#">������ � ���</a><br />
        <br /></div>
        <div class="blinks"><h3>� ��������</h3>
        <a href="#">������</a><br />
        <a href="#">����������</a><br />
        <a href="#">��������</a><br />
        <br /></div>
        <div><h3>��������</h3>
        ������, ��. ����� ������ ������, ��� 15 - <a href="#">����� �������</a><br />
        ���.: +7 495 612-17-19<br />
        Email: <a href="mailto:clients@ambercar.ru">clients@ambercar.ru</a>
        <br /></div>
        </div>
    	<div class="botform{if !$home}inner{/if}">
        ������� �� ����� �������!<br />
        {if !$home}
        <input type="text" name="name" id="name" /> <label for="name">���</label><br />
        <input type="text" name="contacts" id="contacts" /> <label for="contacts">��������</label><br />
        {else}
        <label for="name">���: </label><input type="text" name="name" id="name" /><br />
        <label for="contacts">��������: </label><input type="text" name="contacts" id="contacts" /><br />
        {/if}
        <textarea>����� ���������</textarea><br />
        <input type="image" src="/templates/img/but_send.png" class="botformbut" />
    	</div>
    	
    	
    </td>
  </tr>
</table>
</body>
</html>