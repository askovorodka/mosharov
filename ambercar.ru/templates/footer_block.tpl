  <tr>
    <td height="100">
    	<div class="botmenu{if !$home}inner{/if}">
        <div class="blinks"><h3>Информация</h3>
        <a href="http://ambercar.ru/company/oplata/">Способы оплаты</a><br />
        <a href="http://ambercar.ru/news/">Новости</a><br />
        <a href="http://ambercar.ru/company/otzivi/">Отзывы о нас</a><br />
        <br /></div>
        <div class="blinks"><h3>О компании</h3>
        <a href="http://ambercar.ru/uslugi/">Услуги</a><br />
        <a href="http://ambercar.ru/company/vakancii/">Вакансии</a><br />
        <a href="http://ambercar.ru/company/partners/">Наши партнеры</a><br />
        <br /></div>
        <div><h3>Контакты</h3>
        Москва, ул. Аллея Первой Маевки, дом 15 - <a href="http://goo.gl/maps/f6klu" target="_blank">карта проезда</a><br />
        Тел.: +7 495 772-13-98<br />
        Email: <a href="mailto:list@ambercar.ru">list@ambercar.ru</a>
        <br /></div>
        </div>
    	<div class="botform{if !$home}inner{/if}">
    	<form action="" id="question">
        ОТВЕТИМ НА ЛЮБЫЕ ВОПРОСЫ!<br />
        {if !$home}
        <input type="text" name="name" id="name" /> <label for="name">Имя</label><br />
        <input type="text" name="contacts" id="contacts" /> <label for="contacts">Контакты</label><br />
        {else}
        <label for="name">Имя: </label><input type="text" name="name" id="name" /><br />
        <label for="contacts">Контакты: </label><input type="text" name="contacts" id="contacts" /><br />
        {/if}
        <textarea name="text">Текст сообщения</textarea><br />
        <input type="image" src="/templates/img/but_send.png" class="botformbut" />
        </form>
    	</div>
    	
    	
    </td>
  </tr>
</table>
{literal}
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter20587903 = new Ya.Metrika({id:20587903,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/20587903" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
{/literal}
</body>
</html>