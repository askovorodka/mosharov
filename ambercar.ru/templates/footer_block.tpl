  <tr>
    <td height="100">
    	<div class="botmenu{if !$home}inner{/if}">
        <div class="blinks"><h3>����������</h3>
        <a href="http://ambercar.ru/company/oplata/">������� ������</a><br />
        <a href="http://ambercar.ru/news/">�������</a><br />
        <a href="http://ambercar.ru/company/otzivi/">������ � ���</a><br />
        <br /></div>
        <div class="blinks"><h3>� ��������</h3>
        <a href="http://ambercar.ru/uslugi/">������</a><br />
        <a href="http://ambercar.ru/company/vakancii/">��������</a><br />
        <a href="http://ambercar.ru/company/partners/">���� ��������</a><br />
        <br /></div>
        <div><h3>��������</h3>
        ������, ��. ����� ������ ������, ��� 15 - <a href="http://goo.gl/maps/f6klu" target="_blank">����� �������</a><br />
        ���.: +7 495 772-13-98<br />
        Email: <a href="mailto:list@ambercar.ru">list@ambercar.ru</a>
        <br /></div>
        </div>
    	<div class="botform{if !$home}inner{/if}">
    	<form action="" id="question">
        ������� �� ����� �������!<br />
        {if !$home}
        <input type="text" name="name" id="name" /> <label for="name">���</label><br />
        <input type="text" name="contacts" id="contacts" /> <label for="contacts">��������</label><br />
        {else}
        <label for="name">���: </label><input type="text" name="name" id="name" /><br />
        <label for="contacts">��������: </label><input type="text" name="contacts" id="contacts" /><br />
        {/if}
        <textarea name="text">����� ���������</textarea><br />
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