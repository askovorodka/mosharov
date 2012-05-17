
$(document).ready( function(){

	//картинка в списке товаров
	$("a.CatalogImages").click(function(){
		var src = $(this).attr("image");
		
		if ($.trim(src) == "") return false;
		
		$("#ImageLayout").empty();
		$("#ImageLayout").append( $("<IMG>").attr("src", src).click(function(){ $("#ImageLayout").hide(); }) );
		$("#ImageLayout").css({"left" : $(this).offset().left, "top" : $(this).offset().top} ).show();
		return false;
	});
	
	$("#ImageLayout, body").click(function(){ if ($("#ImageLayout").css('display') == 'block') $("#ImageLayout").hide(); });
	
	function _change_fast_order()
	{
		
		var product_id = $("input[name='product_id']", $("form#fast_order_form")).val();
		var product_count = $("input[name='product_count']", $("form#fast_order_form")).val();
		var dostavka = $("select[name='dostavka']", $("form#fast_order_form")).val();
		
		if (parseInt(product_id) > 0 && parseInt(product_count) > 0)
		{
		
			$.post('http://' + location.hostname + '/shop/', 
					{ajax:1, 
					product_id:product_id,
					product_count:product_count,
					dostavka:dostavka,
					fast_order:1},
					
					function (response)
					{
						var array = eval(response);
						$("#fast_order_total_price").html(array[0]);
						$("#fast_order_order_price").html(array[1]);
						$("#fast_order_total_sum").html(array[2]);
						if (array[3] > 0)
							{
							alert("Внимание! В наличие осталось только "+array[3]+" шт.");
							$("input[name='product_count']", $("form#fast_order_form")).val(array[3])
							}
					}
					
			);
			
		}
	}
	
	_change_fast_order();
	
	$("input[name='product_count'], select[name='dostavka']", $("form#fast_order_form")).change(function(){ return _change_fast_order(); });
	
	//отправка быстрого заказа
	$("form#fast_order_form").submit(function(){
		_change_fast_order();
		if (fast_order_validate.form())
		{
			return true;
		}
		else
			return false;
	});

	//валидатор быстрого заказа
	var fast_order_validate = $("form#fast_order_form").validate(
			{
		 		
				errorPlacement: function(error, element) {
			    	error.insertAfter( element );
		   		},
		    	
				rules:
				{
					product_count :	{required: true, number : true},
					name :	{required: true},
					phone :	{required: true}
				},
				messages:
				{
					product_count:	{
						required : "Введите количество",
						number : "Введите число"
					},
					name:	{
						required : "Введите ваше ФИО"
					},
					phone:	{
						required : "Введите телефон"
					}
					
				}
				
			}
	);
	
	//быстрый заказ
	$("form#form_order").submit(function(){
		
		if ( $("input[name='submit_order']", $(this)).val() == 1)
			{
				register_validate.form();
			}
		
		
	});
	
	
	$("a#for_basketpart2").click(function(){
		$("div.basketpart1").hide();
		$("div.basketpart2").show();
		return false;
	});
	
	
	$("a.CatalogImages").click(function(){
		var src = $(this).attr("image");
		if ($.trim(src) == "") return false;
		$("#ImageLayout").empty();
		$("#ImageLayout").append( $("<IMG>").attr("src", src).click(function(){ $("#ImageLayout").hide(); }) );
		$("#ImageLayout").css({"left" : $(this).offset().left, "top" : $(this).offset().top} ).show();
		return false;
	});

	$("#ImageLayout").click(function(){ $(this).hide(); });
	
	
	
	var login_validate = $("form#form_login").validate(
	{
 		
		errorPlacement: function(error, element) {
	    	error.insertAfter( element );
   		},
    	
		rules:
		{
			email :		{required: true, email : true},
			password :	{required: true}
		},
		messages:
		{
			email:	{
				required : "Введите email",
				email : "Неверный формат email"
			},
			password:	{
				required : "Введите пароль"
			}
		}
	}
	);

	
	var register_validate = $("form#form_order").validate({
		 		
				errorPlacement: function(error, element) {
			    	error.insertAfter( element );
		   		},
		    	
				rules:
				{
					name :		{required: true},
					phone :		{required: true},
					email :		{required: true, email : true}
				},
				messages:
				{
					name:	{
						required : "Введите ваше имя"
					},
					
					phone:	{
						required : "Введите ваш телефон"
					},
					
					email:	{
						required : "Введите email",
						email : "Неверный формат email"
					}
				}
	});
	
	var register_email_validate = $("form#form_order").validate(
			{
		 		
				errorPlacement: function(error, element) {
			    	error.insertAfter( element );
		   		},
		    	
				rules:
				{
					email :	{required: true, email : true, remote : 'http://' + location.hostname + '/shop/ajax/checkemail/'},
					password : {required : true, minlength : 6},
					
				},
				messages:
				{
					email:	{
						required : "Введите email",
						email : "Неверный формат",
						remote : "Такой email уже зарегистрирован"
					},
					password : {
						required : "Введите пароль",
						minlength : "Минимальная длина пароля 4 символа"
					}
				}
			}
			);
	
	
			
	var comment_validate = $("form#add_comment").validate(
			{
		 		
				errorPlacement: function(error, element) {
			    	error.insertAfter( element );
		   		},
		    	
				rules:
				{
					bvz : 	{required: true},
					tvfbk :	{required: true, email : true},
					ntrcn : {required: true}
				},
				messages:
				{
					bvz:	{
						required : "Введите ваше имя"
					},
					
					tvfbk:	{
						required : "Введите email",
						email : "Неверный формат email"
					},
					
					ntrcn:	{
						required : "Введите комментарий"
					}
					
				}
			}
			);
			
	//ссылка показать/скрыть форму регистрации/логина
	$("A#question").click(function(){
		if ($(this).attr("register") == 1)
		{
			$("#login_user").fadeOut("fast");
			$("#register_user").fadeIn("fast");
			$(this).html("Вы уже зарегистрированны ?");
			$(this).attr("register", "0");
		}
		else
		{
			$("#login_user").fadeIn("fast");
			$("#register_user").fadeOut("fast");
			$(this).html("Не зарегистрированны ?");
			$(this).attr("register", "1");
		}
		return false;
	});
	
	
	$("#repassword").click(function(){
		
		$("#repassword_user").css({"top" : $(this).offset().top, "left" : $(this).offset().left-100 })
		.fadeIn("fast");
		return false;
	});

	$("#repassword_close").click(function(){
		
		$("#repassword_user").fadeOut("fast");
		return false;
	});

	
	//левое меню, что-то вроде анимации
	$("A.lmenubig:not(.static)").click( function(){
		var submenu = $("DIV#subitem_" + $(this).attr("id"));
		if ($(submenu).css("display") != "block" )
		{
			$("DIV.submenu").fadeOut().animate({opacity:.5}, 100);
			$(submenu).animate({opacity:1},250).fadeIn("fast");
		}
		return false;
	} );
	
	
	//заказ продукта на отдельной странице
	$("FORM#form_order_single").submit(function(){
		if (form_order_single_validate.form())
		{
			//получаем ответ от сервера
			this.response = function(response){
				var floor = response.split(";");
				
				if (floor[0] == "error_count")
				{
					if (floor[1] > 0)
						alert("Внимание! В наличии осталось только " + floor[1] + " шт.");
					else
						alert("Товар закончился на складе.");
					return false;
				}
				
				$("DIV#confirm_layer").show();
				
				$("#basket_number").html(floor[0]);
				$("#basket_currency").html(floor[1]);
				
				if ($("#basket_block").css('display') == 'none')
					$("#basket_block").show();
				
			};
			
			
			var product_id = $("input[name='product_id']", $(this)).val();
			var product_count = $("input[name='count']", $(this)).val();
			//кидаем запрос на сервер
			$.post('http://' + location.hostname + '/shop/basket/add/', 
			{product_id : product_id, product_count : product_count}, 
			this.response );
			
			
		}
		return false;
	});
	
	
	
	var form_order_single_validate = $("FORM#form_order_single").validate(
	{
 		
		errorPlacement: function(error, element) {
	    	error.insertAfter( element );
   		},
    	
		rules:
		{
			count :	{required: true, number : true}
		},
		messages:
		{
			count:	{
				required : "Введите число",
				number : "Вводите только числа"
			}
		}
	}
	);
	
	
	//заказ из списка продуктов в категории
	$("input[name='add_order']").click(function(){
		
			this.response = function(response){
				//$("DIV#loading-layer").hide();
				var floor = response.split(";");
				
				if (floor[0] == "error_count")
				{
					if (floor[1] > 0)
						alert("Внимание! В наличии осталось только " + floor[1] + " шт.");
					else
						alert("Товар закончился на складе.");
					return false;
				}
				
				$("DIV#confirm_layer").show();
				$("#basket_number").html(floor[0]);
				$("#basket_currency").html(floor[1]);
				
				if ($("#basket_block").css('display') == 'none')
					$("#basket_block").show();
				
			};
		
		
		var product_count = $("td input[type='text']", $(this).parent().parent()).val();
		var product_id = $("td input[type='text']", $(this).parent().parent()).attr("name");
		if (parseInt(product_count) > 0 && parseInt(product_id) > 0)
		{
			//кидаем запрос на сервер
			$.post('http://' + location.hostname + '/shop/basket/add/', 
			{product_id : product_id, product_count : product_count}, 
			this.response );
			
		}
		return false;
	});
	
	
} );
	
