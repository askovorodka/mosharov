
$(document).ready( function(){

	$("#top_search").submit(function(){
		if ($.trim( $("input[name='search_product']", $(this)).val() ) == "")
			return false;
	});
	
	function get_pop_string()
	{
		try{
			var element = arguments[0];
			var string = arguments[1];
			
			var top = $(element).offset().top;
			var left= $(element).offset().left;

			if (arguments[2])
				var left = left + parseInt(arguments[2]); 

			if (arguments[3])
				var top = top + parseInt(arguments[3]);
			
			var span = $("<span></span>").addClass("pop_string").html(string).css({"left" : left+8, "top" : top});
			
			$(element).focus(function(){ $(span).hide(); });
			$(span).click(function(){ $(span).hide(); $(element).focus(); });
			$(element).blur(function(){ if ( $.trim($(element).val()) == "" ) { $(span).show(); } });
			
			if ( $.trim($(element).val()) == "" )
				{
				$(span).appendTo( $("body") );
				}
		}
		catch(e){}
	}
	
	//������������ ������
	get_pop_string($("input[name='search_product']"), "��������: Cordiant polar SL PW-404");
	get_pop_string($("input[name='name']", $("form#form_order")), "�������� ������ ����");
	get_pop_string($("input[name='phone']", $("form#form_order")), "�������� 89031112233");
	get_pop_string($("input[name='email']", $("form#form_order")), "�������� ivanov@mail.ru");
	get_pop_string($("input[name='name']", $("form#fast_order_form")), "���� ���", 0, 23);
	get_pop_string($("input[name='phone']", $("form#fast_order_form")), "��� �������", 0, 23);
	get_pop_string($("textarea[name='comment']", $("form#fast_order_form")), "���� ���������. ��������: �������� �� ���. ������, 3-� ��. ����������, �.25, ��.12", 0, 23);

	
	//�������� � ������ �������
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
		
			$.post('http://' + location.hostname + '/catalog/', 
					{ajax:1, 
					product_id:product_id,
					product_count:product_count,
					dostavka:dostavka,
					fast_order:1},
					
					function (response)
					{
						var array = eval(response);
						$("#fast_order_total_price").html(array[1]);
						$("#fast_order_order_price").html(array[0]);
						$("#fast_order_total_sum").html(array[2]);
						if (array[3] > 0)
						{
						alert("��������! � ������� �������� ������ "+array[3]+" ��.");
						$("input[name='product_count']", $("form#fast_order_form")).val(array[3])
						}
						
					}
					
			);
			
		}
	}
	
	//_change_fast_order();
	
	//$("input[name='product_count'], select[name='dostavka']", $("form#fast_order_form")).change(function(){ return _change_fast_order(); });
	
	//�������� �������� ������
	$("form#fast_order_form").submit(function()
	{
		//_change_fast_order();
		if (fast_order_validate.form())
		{
			return true;
		}
		else
			return false;
	});

	//��������� �������� ������
	var fast_order_validate = $("form#fast_order_form").validate(
			{
		 		
				errorPlacement: function(error, element) {
			    	error.insertAfter( element );
		   		},
		    	
				rules:
				{
					name :	{required: true},
					phone :	{required: true}
				},
				messages:
				{
					name:	{
						required : "������� ���� ���"
					},
					phone:	{
						required : "������� �������"
					}
				}
				
			}
	);
	
	//������� �����
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
				required : "������� email",
				email : "�������� ������ email"
			},
			password:	{
				required : "������� ������"
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
						required : "������� ���� ���"
					},
					
					phone:	{
						required : "������� ��� �������"
					},
					
					email:	{
						required : "������� email",
						email : "�������� ������ email"
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
					email :	{required: true, email : true, remote : 'http://' + location.hostname + '/catalog/ajax/checkemail/'},
					password : {required : true, minlength : 6},
					
				},
				messages:
				{
					email:	{
						required : "������� email",
						email : "�������� ������",
						remote : "����� email ��� ���������������"
					},
					password : {
						required : "������� ������",
						minlength : "����������� ����� ������ 4 �������"
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
						required : "������� ���� ���"
					},
					
					tvfbk:	{
						required : "������� email",
						email : "�������� ������ email"
					},
					
					ntrcn:	{
						required : "������� �����������"
					}
					
				}
			}
			);
			
	//������ ��������/������ ����� �����������/������
	$("A#question").click(function(){
		if ($(this).attr("register") == 1)
		{
			$("#login_user").fadeOut("fast");
			$("#register_user").fadeIn("fast");
			$(this).html("�� ��� ����������������� ?");
			$(this).attr("register", "0");
		}
		else
		{
			$("#login_user").fadeIn("fast");
			$("#register_user").fadeOut("fast");
			$(this).html("�� ����������������� ?");
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

	
	//����� ����, ���-�� ����� ��������
	$("A.lmenubig:not(.static)").click( function(){
		var submenu = $("DIV#subitem_" + $(this).attr("id"));
		if ($(submenu).css("display") != "block" )
		{
			$("DIV.submenu").fadeOut().animate({opacity:.5}, 100);
			$(submenu).animate({opacity:1},250).fadeIn("fast");
		}
		return false;
	} );
	
	
	//����� �������� �� ��������� ��������
	$("FORM#form_order_single").submit(function(){
		if (form_order_single_validate.form())
		{
			//�������� ����� �� �������
			this.response = function(response){
				$("DIV#loading-layer").hide();
				var floor = response.split(";");
				
				if (floor[0] == "error_count")
				{
					if (floor[1] > 0)
						alert("��������! � ������� �������� ������ " + floor[1] + " ��.");
					else
						alert("����� ���������� �� ������.");
					return false;
				}
				
				
				
				$("#basket_number").html(floor[0]);
				//$("#basket_currency").html(floor[1]);
				$("div#basket_block").show();
			};
			
			$("DIV#loading-layer").show();
			var product_id = $("input[name='product_id']", $(this)).val();
			var product_count = $("input[name='count']", $(this)).val();
			
			//������ ������ �� ������
			$.post('http://' + location.hostname + '/catalog/basket/add/', 
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
				required : "������� �����",
				number : "������� ������ �����"
			}
		}
	}
	);
	
	
	//����� �� ������ ��������� � ���������
	$("input[name='add_order'], a[name='add_order']").click(function(){
		
			this.response = function(response){
				$("DIV#loading-layer").hide();
				var floor = response.split(";");
				
				if (floor[0] == "error_count")
				{
					if (floor[1] > 0)
						alert("��������! � ������� �������� ������ " + floor[1] + " ��.");
					else
						alert("����� ���������� �� ������.");
					return false;
				}
				
				
				$("#basket_number").html(floor[0]);
				//$("#basket_currency").html(floor[1]);
				$("div#basket_block").show();
			};
		
		
		var product_count = $("td input[type='text']", $(this).parent().parent()).val();
		var product_id = $("td input[type='text']", $(this).parent().parent()).attr("name");
		$("DIV#loading-layer").show(); 
		if (parseInt(product_count) > 0 && parseInt(product_id) > 0)
		{
			//������ ������ �� ������
			$.post('http://' + location.hostname + '/catalog/basket/add/', 
			{product_id : product_id, product_count : product_count}, 
			this.response );
			
		}
		return false;
	});
	
	
} );
	
