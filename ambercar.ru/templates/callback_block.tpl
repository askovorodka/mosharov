    	<div class="simpleform">
            
            <a href="#" class="simpleformlnk tabs" elem="phone">ОБРАТНЫЙ ЗВОНОК</a><a href="#" class="simpleformlnksecond tabs" elem="order">ЗАКАЗАТЬ ДЕТАЛЬ</a>
            
            <div class="simpleforminner" id="phone">
	            <input type="text" name="phone" value="Ваш телефон" onfocus="{literal}if(this.value=='Ваш телефон'){this.value='';}{/literal}" onblur="{literal}if(this.value==''){this.value='Ваш телефон';}{/literal}" /><br />
	            <input type="image" src="{$template_image}but_send_transparent.png" class="simpleformbut" />
            </div>
            
            <div class="simpleforminnersecond hide" id="order">
	            <input type="text" name="name" value="ФИО" onfocus="{literal}if(this.value=='ФИО'){this.value='';}{/literal}" onblur="{literal}if(this.value==''){this.value='ФИО';}{/literal}" /><br />
	            <input type="text" name="auto" value="Марка, модель, год выпуска" onfocus="{literal}if(this.value=='Марка, модель, год выпуска'){this.value='';}{/literal}" onblur="{literal}if(this.value==''){this.value='Марка, модель, год выпуска';}{/literal}" /><br />
	            <input type="text" name="zapchast" value="Запчасть" onfocus="{literal}if(this.value=='Запчасть'){this.value='';}{/literal}" onblur="{literal}if(this.value==''){this.value='Запчасть';}{/literal}" /><br />
	            <input type="text" name="phone" value="Ваш телефон" onfocus="{literal}if(this.value=='Ваш телефон'){this.value='';}{/literal}" onblur="{literal}if(this.value==''){this.value='Ваш телефон';}{/literal}" /><br />
	            <input type="image" src="{$template_image}but_send_transparent.png" class="simpleformbut" />
            </div>
            
        </div>
        <br />
        
        {*
        <div class="simpleform">
            <a href="#" class="simpleformlnksecond">ОБРАТНЫЙ ЗВОНОК</a><a href="#" class="simpleformlnk">ЗАКАЗАТЬ ДЕТАЛЬ</a>
            <div class="simpleforminnersecond">
            <input type="text" name="name" value="ФИО" /><br />
            <input type="text" name="auto" value="Марка, модель, год выпуска" /><br />
            <input type="text" name="zapchast" value="Запчасть" /><br />
            <input type="text" name="phone" value="Ваш телефон" /><br />
            <input type="image" src="img/but_send_transparent.png" class="simpleformbut" />
            </div>
        </div>
        *}