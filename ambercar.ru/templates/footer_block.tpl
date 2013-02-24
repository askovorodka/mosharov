  <tr>
    <td height="100">
    	<div class="botmenu{if !$home}inner{/if}">
        <div class="blinks"><h3>Информация</h3>
        <a href="#">Публикации</a><br />
        <a href="#">Новости</a><br />
        <a href="#">Отзывы о нас</a><br />
        <br /></div>
        <div class="blinks"><h3>О компании</h3>
        <a href="#">Услуги</a><br />
        <a href="#">Аксессуары</a><br />
        <a href="#">Доставка</a><br />
        <br /></div>
        <div><h3>Контакты</h3>
        Москва, ул. Аллея Первой Маевки, дом 15 - <a href="#">карта проезда</a><br />
        Тел.: +7 495 612-17-19<br />
        Email: <a href="mailto:clients@ambercar.ru">clients@ambercar.ru</a>
        <br /></div>
        </div>
    	<div class="botform{if !$home}inner{/if}">
        ОТВЕТИМ НА ЛЮБЫЕ ВОПРОСЫ!<br />
        {if !$home}
        <input type="text" name="name" id="name" /> <label for="name">Имя</label><br />
        <input type="text" name="contacts" id="contacts" /> <label for="contacts">Контакты</label><br />
        {else}
        <label for="name">Имя: </label><input type="text" name="name" id="name" /><br />
        <label for="contacts">Контакты: </label><input type="text" name="contacts" id="contacts" /><br />
        {/if}
        <textarea>Текст сообщения</textarea><br />
        <input type="image" src="/templates/img/but_send.png" class="botformbut" />
    	</div>
    	
    	
    </td>
  </tr>
</table>
</body>
</html>