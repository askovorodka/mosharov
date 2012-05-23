
$(document).ready( function(){

	$("a.CatalogImages").click(function(){
		var src = $(this).attr("image");
		if ($.trim(src) == "") return false;
		$("#ImageLayout").empty();
		$("#ImageLayout").append( $("<IMG>").attr("src", src).click(function(){ $("#ImageLayout").hide(); }) );
		$("#ImageLayout").css({"left" : $(this).offset().left, "top" : $(this).offset().top} ).show();
		return false;
	});

	$("#ImageLayout").click(function(){ $(this).hide(); });

	$("#submit_basket_form").submit(function(){
		//alert($("input[name='payment']:checked", $("form#submit_basket_form")).val());
		//return false;
		//если авторизован, то сразу делаем заказ
		if ( $("#register").val() == 1 )
			{
				$("input[name='submit_basket'][type='image']").attr("disabled", "true").fadeOut("fast");
									$.post('http://' + location.hostname + '/shop/basket/submit/', {
										submit_order : 1,
										dostavka : $("input[name='dostavka']:checked", $("form#submit_basket_form")).val(),
										company_dost : $("input[name='company_dost']:checked", $("form#submit_basket_form")).val(),
										payment : $("input[name='payment']:checked", $("form#submit_basket_form")).val(),
										company : $("input[name='company']", $("form#submit_basket_form")).val(),
										inn : $("input[name='inn']", $("form#submit_basket_form")).val(),
										kpp : $("input[name='kpp']", $("form#submit_basket_form")).val(),
										comment : $("textarea[name='comment']", $("form#submit_basket_form")).val()
									}, function(response) { location = 'http://' + location.hostname + '/shop/basket/final/'; } );
				
			}
		else
			//иначе регим/логиним
			{
				//авторизация
				if ($("#question").attr("register") == 1)
					{
					
						//if (login_validate.form())
						{
							$.post('http://' + location.hostname + '/cabinet/login/', {
								submit_login : 1,
								login_email : $("input[name='login_email']", $("form#login_user_form")).val(),
								login_pass :  $("input[name='login_pass']", $("form#login_user_form")).val()
							}, function(response){ 
								if (response != 1)
								{

									switch(response)
									{
									case "error1":
										$("#response_server").html("Неправильный формат e-mail адреса");
										break;
									case "error2":
										$("#response_server").html("Неверная пара логин/пароль");
										break;
									}

								}
								else
								{
									//$("#submit_basket_form").submit();
									$("input[name='submit_basket'][type='image']").attr("disabled", "true").fadeOut("fast");
									$.post('http://' + location.hostname + '/shop/basket/submit/', {
										submit_order : 1,
										dostavka : $("input[name='dostavka']:checked", $("form#submit_basket_form")).val(),
										company_dost : $("input[name='company_dost']:checked", $("form#submit_basket_form")).val(),
										payment : $("input[name='payment']:checked", $("form#submit_basket_form")).val(),
										company : $("input[name='company']", $("form#submit_basket_form")).val(),
										inn : $("input[name='inn']", $("form#submit_basket_form")).val(),
										kpp : $("input[name='kpp']", $("form#submit_basket_form")).val(),
										comment : $("textarea[name='comment']", $("form#submit_basket_form")).val()
									}, function(response) { location = 'http://' + location.hostname + '/shop/basket/final/'; } );
									return false;
								}
							} );
						}
					}
				else
					{
						//регистрация
						
						//if (register_validate.form())
						{
							
							$.post('http://' + location.hostname + '/cabinet/register/',{
								
								submit_user_register : 1,
								username : $("input[name='username']", $("form#register_user_form")).val(),
								useremail : $("input[name='useremail']", $("form#register_user_form")).val(),
								phone : $("input[name='phone']", $("form#register_user_form")).val(),
								address : $("input[name='address']", $("form#register_user_form")).val(),
								pass : $("input[name='pass']", $("form#register_user_form")).val()
							}, function(response){ 
								
								if (response != 1)
								{
									switch(response)
									{
									case "error1":
										$("#response_server").html("Неправильный формат e-mail адреса");
										break;
									case "error2":
										$("#response_server").html("Пользователь с таким почтовым адресом уже существует");
										break;
									}
								}
								else
								{
									$("input[name='submit_basket'][type='image']").attr("disabled", "true").fadeOut("fast");
									$.post('http://' + location.hostname + '/shop/basket/submit/', {
										submit_order : 1,
										dostavka : $("input[name='dostavka']:checked", $("form#submit_basket_form")).val(),
										company_dost : $("input[name='company_dost']:checked", $("form#submit_basket_form")).val(),
										payment : $("input[name='payment']:checked", $("form#submit_basket_form")).val(),
										company : $("input[name='company']", $("form#submit_basket_form")).val(),
										inn : $("input[name='inn']", $("form#submit_basket_form")).val(),
										kpp : $("input[name='kpp']", $("form#submit_basket_form")).val(),
										comment : $("textarea[name='comment']", $("form#submit_basket_form")).val()
									}, function(response) { location = 'http://' + location.hostname + '/shop/basket/final/'; } );
								
								}
							})
						}
					}
					
			}
		return false;
	});
	
	
	//регистрация/логин при заказе
	$("#register_login").click(function(){
		
		if ($("#question").attr("register") == 1)
			{
				if (login_validate.form())
					{
					$("form#login_user_form").submit();
					}
			}
		else
			{
				if (register_validate.form())
					{
					$("form#register_user_form").submit();
					}
			}
		
	});
	
	$("form#restore_password_form").submit(function(){
		return restore_validate.form();
	});
	var restore_validate = $("form#restore_password_form").validate(
			{
		 		
				errorPlacement: function(error, element) {
			    	error.insertAfter( element );
		   		},
		    	
				rules:
				{
					email :	{required: true, email : true}
				},
				messages:
				{
					email:	{
						required : "Введите email",
						email : "Неверный формат email"
					}
				}
			}
			);
	
	
	
	var login_validate = $("form#login_user_form").validate(
	{
 		
		errorPlacement: function(error, element) {
	    	error.insertAfter( element );
   		},
    	
		rules:
		{
			login_email :	{required: true, email : true},
			login_pass :	{required: true}
		},
		messages:
		{
			login_email:	{
				required : "Введите email",
				email : "Неверный формат email"
			},
			login_pass:	{
				required : "Введите пароль"
			}
		}
	}
	);

	
	var register_validate = $("form#register_user_form").validate(
			{
		 		
				errorPlacement: function(error, element) {
			    	error.insertAfter( element );
		   		},
		    	
				rules:
				{
					username :		{required: true},
					phone :			{required: true},
					useremail :		{required: true, email:true},
					address :		{required: true}
					//pass: {required: true}
				},
				messages:
				{
					username:	{
						required : "Введите имя"
					},
					phone:	{
						required : "Введите телефон"
					},
					useremail:	{
						required : "Введите email",
						email : "Неверный формат email"
					},
					address:	{
						required : "Введите адрес"
					}
					/*pass:	{
						required : "Введите пароль"
					}*/

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
					bvz : {required: true},
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

	$("#repassword_form").submit(function(){
		if (validator_repassword.form())
		{
			var email = $("input[name='repassword_email']").val();
			$.post('http://' + location.hostname + '/cabinet/', {submit_restore : 1, email : email}, 
					function(response){
					if (response == 1)
						$("#repassword_msg").html("Новый пароль выслан на ваш email");
					else
						$("#repassword_msg").html("Пароль не восстановлен");
				});
		}
		return false;
	});
	
	
	var validator_repassword = $("FORM#repassword_form").validate(
	{

	errorPlacement: function(error, element) {
		error.insertAfter( element );
	},
		    	
	rules:
	{
		repassword_email :	{required: true, email : true}
	},
				
	messages:
	{
		repassword_email:	{
			required : "Введите email",
			email : "Неверный формат"
		}
	}
	}
	);
	
	
	
	//левое меню, что-то вроде анимации
	$("A.lmenuf:not(.static)").click( function(){
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
				$("DIV#loading-layer").hide();
				var floor = response.split(";");
				
				if (parseInt(floor[0]) == 1001)
				{
					if (floor[1] > 0)
						alert("Внимание! В наличии осталось только " + floor[1] + " шт.");
					else
						alert("Товар закончился на складе.");
					return false;
				}
				
				
				$("#basket_number").html(floor[0]);
				$("#basket_currency").html(floor[1]);
			};
			
			
			var product_id = $("input[name='product_id']", $(this)).val();
			var product_count = $("input[name='count']", $(this)).val();
			$("DIV#loading-layer").show();
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
				$("DIV#loading-layer").hide();
				var floor = response.split(";");
				
				if (parseInt(floor[0]) == 1001)
				{
					if (floor[1] > 0)
						alert("Внимание! В наличии осталось только " + floor[1] + " шт.");
					else
						alert("Товар закончился на складе.");
					return false;
				}
				
				$("#basket_number").html(floor[0]);
				$("#basket_currency").html(floor[1]);
			};
		
		
		var product_count = $("td input[type='text']", $(this).parent().parent()).val();
		var product_id = $("td input[type='text']", $(this).parent().parent()).attr("name");
		if (parseInt(product_count) > 0 && parseInt(product_id) > 0)
		{
			$("DIV#loading-layer").show();
			//кидаем запрос на сервер
			$.post('http://' + location.hostname + '/shop/basket/add/', 
			{product_id : product_id, product_count : product_count}, 
			this.response );
			
		}
		return false;
	});
	

	var validator = $("FORM#RegisterForm").validate(
	{
 		
		errorPlacement: function(error, element) {
	    	error.insertAfter( element );
   		},
    	
		rules:
		{
			email :	{required: true, email : true, remote : 'http://' + location.hostname + '/shop/ajax/checkemail/'},
			tel :	{required: true},
			name :	{required: true},
			password : {required : true, minlength : 6},
			password_again : {equalTo : "#password"}
		},
		messages:
		{
			email:	{
				required : "Введите email",
				email : "Неверный формат",
				remote : "Такой email уже зарегистрирован"
			},
			tel:	{
				required : "Введите контактный телефон"
			},
			name:	{
				required : "Введите ваше имя"
			},
			password : {
				required : "Введите пароль",
				minlength : "Минимальная длина пароля 4 символа"
			},
			password_again : "Пароли не совпадают"
			
		}
	}
	);
	

	$("A#i_registered").click(function(){
		if ($("FORM#Registration").css('display') == 'block')
		{
			$("FORM#Registration").hide();
			$("FORM#Auth").show();
			$(this).html("Я не зарегистрирован");
		}
		else
		{
			$("FORM#Auth").hide();
			$("FORM#Registration").show();
			$(this).html("Я уже зарегистрирован");
		}
		return false;
	});
	
} );
	
