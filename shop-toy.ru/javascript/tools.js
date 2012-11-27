	//скрываем/раскрываем корзину
	this.basket_block =  function(){
		var basket = $("#basket_block");
		if (basket.length)
		{
            var showPanel = function() {
                $(basket).animate({
                    right: '+=195',
                }, 200, function() {
                    $(this).addClass('visible');
                });
            };
			
            var hidePanel = function() {
                $(basket).animate({
                    right: '-=195',
                }, 200, function() {
                    $(this).removeClass('visible');
                });
            };
            $("#basketlink").click(function(){
                if ($(basket).hasClass('visible')) {
                    hidePanel();
                }
                else {
                    showPanel();
                }
                return false;
            });
		}
		
	};

	this.imagePreview = function(){	
			xOffset = 10;
			yOffset = 30;
		$("a.preview").hover(function(e){
			//this.t = this.title;
			this.t = "";
			this.title = "";	
			var c = (this.t != "") ? "<br/>" + this.t : "";
			$("body").append("<p id='preview'><img src='"+ $(this).attr("image") +"' alt='Image preview' />"+ c +"</p>");								 
			$("#preview")
				.css("top",(e.pageY - xOffset) + "px")
				.css("left",(e.pageX + yOffset) + "px")
				.fadeIn("fast");						
	    },
		function(){
			this.title = this.t;	
			$("#preview").remove();
	    });	
		$("a.preview").mousemove(function(e){
			$("#preview")
				.css("top",(e.pageY - xOffset) + "px")
				.css("left",(e.pageX + yOffset) + "px");
		});			
	};

	this.get_ajax_request = function(url)
	{
		//основной урл с выбранной категорией
		var url = $("div.filter").attr("url");
		
		//собираем в урл знаечние отмеченных чекбоксов
		var checked_url = checked_filter();
		
		var input_url = null;
		
		var age_start = $("input[name='age_start']", $("div.fromto")).val();
		var age_end = $("input[name='age_end']", $("div.fromto")).val();
		var price_start = $("input[name='price_start']", $("div.fromto")).val();
		var price_end = $("input[name='price_end']", $("div.fromto")).val();
		
		var filter_url = new Array();
		
		if (parseInt(price_start) > 0)
		{
			filter_url.push( "price_start=" + parseInt(price_start) );
		}

		if (parseInt(price_end) > 0)
		{
			filter_url.push( "price_end=" + parseInt(price_end) );
		}

		if (parseInt(age_start) > 0)
		{
			filter_url.push( "age_start=" + parseInt(age_start) );
		}
		
		if (parseInt(age_end) > 0)
		{
			filter_url.push( "age_end=" + parseInt(age_end) );
		}
		
		if (filter_url.length > 0)
		{
			var input_url = filter_url.join('&');
		}
		
		if (checked_url)
			url = url + '?' + checked_url;
		if (input_url && checked_url)
			url = url + '&' + input_url;
		else if (input_url)
			url = url + '?' + input_url;
		
		
		if (typeof(product)!="undefined" && product==true)
		{
			location = url;
		}
		else
		{
			$("#maincontent table").addClass("shadow");
			$.get(url, {ajax : 1}, function(response){
				$("#maincontent").empty();
				$("#maincontent").css("width","730px").append(response);
			});
		}
		
	};

	this.checked_filter = function()
	{
		var filter_cats = new Array();
		var filter_brands = new Array();
		var url = new Array();
		
		$("input[name='categories']:checked").each(function(){
			filter_cats.push( $(this).val() );
		});

		$("input[name='brands']:checked").each(function(){
			filter_brands.push( $(this).val() );
		});
		
		if (filter_cats.length > 0)
		{
			url.push("categories=" + filter_cats.join(','));
		}
		
		if (filter_brands.length > 0)
		{
			url.push("brands=" + filter_brands.join(','));
		}
		
		if (url.length > 0)
		{
			return url.join('&');
		}
		else
		{
			return null;
		}
		
	};
	
	this.left_filter = function()
	{
		$("div.filterinput input[type='checkbox']").click(function(){
			get_ajax_request();
		});
		
		$("input[name='age_start'],input[name='age_end'],input[name='price_start'],input[name='price_end']").change(function(){
			get_ajax_request();
		});
		
	};
	
	

$(document).ready( function(){

	left_filter();
	
	basket_block();
	
	//$("#filterbutton").click(function(){
	/*$("input[name='age_start'],input[name='age_end'],input[name='price_start'],input[name='price_end']").change(function(){
		
		left_filter();
		var age_start = $("input[name='age_start']", $("div.fromto")).val();
		var age_end = $("input[name='age_end']", $("div.fromto")).val();
		var price_start = $("input[name='price_start']", $("div.fromto")).val();
		var price_end = $("input[name='price_end']", $("div.fromto")).val();
		
		var checked_url = checked_filter();
		var filter_url = new Array();
		
		if (parseInt(price_start) > 0)
		{
			filter_url.push( "price_start=" + parseInt(price_start) );
		}

		if (parseInt(price_end) > 0)
		{
			filter_url.push( "price_end=" + parseInt(price_end) );
		}

		if (parseInt(age_start) > 0)
		{
			filter_url.push( "age_start=" + parseInt(age_start) );
		}
		
		if (parseInt(age_end) > 0)
		{
			filter_url.push( "age_end=" + parseInt(age_end) );
		}
		
		if (checked_url)
		{
			//location = $("div.filter").attr("url") + '?' + checked_url + '&' + filter_url.join('&');
			get_ajax_request($("div.filter").attr("url") + '?' + checked_url + '&' + filter_url.join('&'));
		}
		else
		{
			//location = $("div.filter").attr("url") + '?' + filter_url.join('&');
			get_ajax_request($("div.filter").attr("url") + '?' + filter_url.join('&'));
		}
		
	});*/

	imagePreview();
	
	$(".rollover").hover(function(){
		var image = $(this).attr("image");
		if (image)
			{
			var position = $(this).position();
			$(".popImage").empty();
			$("<img></img>")
			.css({'width' : 315, 'height' : 228})
			.attr({"src" : image})
			.appendTo($(".popImage"));
			
			if ($.browser.msie)
				$(".popImage").css({'left' : position.left, 'top' : (position.top)}).show();
			else
				$(".popImage").css({'left' : position.left, 'top' : (position.top-108)}).show();
			
			}
	});
	
	$(".popImage").mouseleave(function(){
		$(".popImage").hide();
	});
	
	
	
	
	$("a.colorbox").colorbox();
	
	$("input[type='text']", $("#basket_form")).keyup(function(){ $("#basket_form").submit(); });
	
	$("a.smallimage").click(function(){
		var src = $(this).attr("href");
		var bsrc = $(this).attr("bigimage");
		if ($.trim(src) != "")
		{
			$("#bigimage").attr("src", src).parent().attr("href", bsrc);
			
		}
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
	
	/*$("#submit_basket_form").submit(function(){
		if ( $("#register").val() == 1 )
			{
				$("input[name='submit_basket'][type='image']").attr("disabled", "true").fadeOut("fast");
									$.post('http://' + location.hostname + '/shop/basket/submit/', {
										submit_order : 1,
										dostavka : $("input[name='dostavka']:checked", $("form#submit_basket_form")).val(),
										payment : $("input[name='payment']:checked", $("form#submit_basket_form")).val(),
										company : $("input[name='company']", $("form#submit_basket_form")).val(),
										inn : $("input[name='inn']", $("form#submit_basket_form")).val(),
										kpp : $("input[name='kpp']", $("form#submit_basket_form")).val(),
										comment : $("textarea[name='comment']", $("form#submit_basket_form")).val()
									}, function(response) { location = 'http://' + location.hostname + '/cabinet/orders/'; } );
				
			}
		else
			{
				if ($("#question").attr("register") == 1)
					{
						if (login_validate.form())
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
										payment : $("input[name='payment']:checked", $("form#submit_basket_form")).val(),
										company : $("input[name='company']", $("form#submit_basket_form")).val(),
										inn : $("input[name='inn']", $("form#submit_basket_form")).val(),
										kpp : $("input[name='kpp']", $("form#submit_basket_form")).val(),
										comment : $("textarea[name='comment']", $("form#submit_basket_form")).val()
									}, function(response) { location = 'http://' + location.hostname + '/cabinet/orders/'; } );
									return false;
								}
							} );
						}
					}
				else
					{
						//регистрация
						if (register_validate.form())
						{
							$.post('http://' + location.hostname + '/cabinet/register/',{
								submit_user_register : 1,
								username : $("input[name='username']", $("form#register_user_form")).val(),
								useremail : $("input[name='useremail']", $("form#register_user_form")).val(),
								phone : $("input[name='phone']", $("form#register_user_form")).val(),
								address : $("input[name='address']", $("form#register_user_form")).val(),
								pass : $("input[name='pass']", $("form#register_user_form")).val()
							}, function(response){ 
								//alert(response);
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
										payment : $("input[name='payment']:checked", $("form#submit_basket_form")).val(),
										company : $("input[name='company']", $("form#submit_basket_form")).val(),
										inn : $("input[name='inn']", $("form#submit_basket_form")).val(),
										kpp : $("input[name='kpp']", $("form#submit_basket_form")).val(),
										comment : $("textarea[name='comment']", $("form#submit_basket_form")).val()
									}, function(response) { location = 'http://' + location.hostname + '/cabinet/orders/'; } );
								
								}
							})
						}
					}
					
			}
		return false;
	});*/
	
	
	//регистрация/логин при заказе
	/*$("#register_login").click(function(){
		
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
		
	});*/
	
	/*$("form#restore_password_form").submit(function(){
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
					address :		{required: true},
					pass: {required: true}
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
					},
					pass:	{
						required : "Введите пароль"
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
					username : {required: true},
					email :	{required: true, email : true},
					text : {required: true}
				},
				messages:
				{
					username:	{
						required : "Введите ваше имя"
					},
					
					email:	{
						required : "Введите email",
						email : "Неверный формат email"
					},
					
					text:	{
						required : "Введите комментарий"
					}
					
				}
			}
			);
	*/
	
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
				$("#basket_number").html(floor[0]);
				$("#basket_currency").html(floor[1]);
				//если первый заказ, показываем корзину
				if (floor[2] == 1)
				{
					$("#basketlink").click();
				}
			};
		
		var product_id = parseInt($(this).attr("product_id"));
		
		var product_count = 1;
		
		if (parseInt(product_count) > 0 && parseInt(product_id) > 0)
		{
			$("DIV#loading-layer").show();
			//кидаем запрос на сервер
			$.post('http://' + location.hostname + '/catalog/basket/add/', 
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
	
