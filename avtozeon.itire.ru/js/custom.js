jQuery.validator.addMethod("phone_valid", function(value, element) {
    //return /(\d{3})(\s|\-)?(\d{3})(\s|\-)?(\d{2})(\s|\-)?(\d{2})$/.test(value);
	return /^\d{10,11}$/.test(value);
}, "");

$(document).ready(function(){
	
	var sklad, before_count = null;
	
	var config = $.parseJSON($.ajax({type : 'get', 'url' : 'http://' + location.hostname + '/catalog/get_constants/', async : false}).responseText);

	jQuery.validator.addMethod("count_valid", function(value, element) {
		return parseInt(value) > 0 || parseInt(value) > sklad;
	}, "");
	
	
	$("#send_to_basket", $("#fast_order_form")).click(function(){
		
		var order_count = $("#order_count", $("#fast_order_form")).val();
		var product_id = $("#product_id", $("#fast_order_form")).val();
		
		if ($.isNumeric(order_count) && $.isNumeric(product_id))
		{
			if (order_count <= sklad)
			{
				$.post('http://' + location.hostname + '/catalog/basket/add/', 
						{product_id : product_id, product_count : order_count}, 
						function(response){
							
							if (/error_count/i.test(response))
							{
								return false;
							}
							
							if (response)
							{
								$("#basket_block").html(response);
							}
							
						});
				
			}
		}
		
	});
	
	alert( document.cookie );
	
	$("input[name='phone']", $("form")).keydown(function(e){
		
		if ($.inArray(e.which, [8,46]) > -1)
			return true;
		
		if (e.which > 95 && e.which < 106)
		{
			return true;
		}
		else
		{
			return false;
		}
	});
	
	$("form#fast_order_form").validate({
		
		rules : {
			product_count : {required : true, number : true, count_valid : true},
			fio : { required : true, minlength : 4 },
			phone : {phone_valid : true},
			order_type : {required: true, number:true}
		},
		
		messages : {
			product_count : { required : "", number : "", count_valiud : "" },
			fio : {required:"", minlength:""},
			phone : {phone_valid : ""},
			order_type : {required : "", number: ""}
		}
		
	});
	
	$("a.order_button").click(function(){

		
		get_order_layer( $(this).attr("product_id"), $(this).attr("product_name"), $(this).attr("product_price"), 1, $("select#order_type option:selected", $("#fast_order_form")).val() );
		
		$("#order_count", $("#fast_order_form")).val(1);
		$("#layer_product_price", $("#fast_order_form")).val( $(this).attr("product_price") );
		$("#product_id", $("#fast_order_form")).val( $(this).attr("product_id") );
		
		sklad = parseInt($(this).attr("sklad"));
		
	});
	
	//если отдельный продукт
	if ($("#fast_order_form", $("section#single_product")).length)
	{
		get_order_layer( $("input#product_id", $("#fast_order_form")).val(), $("input#product_name", $("#fast_order_form")).val(), $("input#layer_product_price", $("#fast_order_form")).val(), 1, $("select#order_type option:selected", $("#fast_order_form")).val() );
		
		$("#order_count", $("#fast_order_form")).val(1);
		sklad = parseInt($("input#sklad", $("#fast_order_form")).val());
		
	}
	
	function get_order_layer(product_id, product_name, product_price, product_count, order_type)
	{
		
		product_sum = parseFloat(product_price * product_count);
		total_sum = product_sum;
		order_price = 0.00;
		
		if (product_sum < parseFloat(config['SHOP_DOSTAVKA_LIMIT']) && order_type > 1)
		{
			total_sum += parseFloat(config['SHOP_DOSTAVKA_PRICE']);
			order_price = parseFloat(config['SHOP_DOSTAVKA_PRICE']);
		}
		
		$("p#order_product_name", $("#fast_order_form")).html(product_name);
		$("span#order_product_price", $("#fast_order_form")).html( number_format(product_sum, 2, '.', '') );
		$("span#order_price", $("#fast_order_form")).html( number_format(order_price, 2, '.', '') );
		$("span#order_sum", $("#fast_order_form")).html( number_format(total_sum, 2, '.', '') );
		
	}
	
	
	function keydown_working(e)
	{
		
		if ($.inArray(e.which, [8,46]) > -1)
			return true;
		
		if (e.which > 95 && e.which < 106)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	function keyup_working(e, self)
	{
		
		if (!$.isNumeric($(self).val()) || parseInt($(self).val()) <= 0)
		{
			$("span#order_product_price", $("#fast_order_form")).html( number_format(0, 2, '.', '') );
			$("span#order_price", $("#fast_order_form")).html( number_format(0, 2, '.', '') );
			$("span#order_sum", $("#fast_order_form")).html( number_format(0, 2, '.', '') );
			
			return false;
		}
		
		if (parseInt($(self).val()) > sklad)
		{
			$(self).val(sklad);
		}
		
		if ($(self).val() > 0)
		{
			
			var id = $("#product_id", $("#fast_order_form")).val();
			var name = $("p#order_product_name", $("#fast_order_form")).html();
			var price = $("#layer_product_price", $("#fast_order_form")).val();
			var count = parseInt($(self).val());
			var order_type = $("select#order_type option:selected").val();
			
			get_order_layer(id , name, price, count, order_type);
			
		}
		
		return true;
		
	}
	
	
	$("#order_count", $("#fast_order_form")).keydown(function(e)
	{
		return keydown_working(e);
		
	}).keyup(function(e){
		
		return keyup_working(e, this);
		
	});
	
	$("#order_type").change(function(){
		
		var id = $("#product_id", $("#fast_order_form")).val();
		var name = $("p#order_product_name", $("#fast_order_form")).html();
		var price = $("#layer_product_price", $("#fast_order_form")).val();
		var count = parseInt( $("#order_count", $("#fast_order_form")).val() );
		var order_type = $(this).val();
		
		get_order_layer(id , name, price, count, order_type);
		
	});
	
	
	$("input[type='text']", $("form#form_basket_recount"))
		.each(function(){
				
			$(this).keydown(function(e){
					
				return keydown_working(e);
					
			}).keyup(function(e){
					
				if (!keydown_working(e))
					return false;
					
				if (/^([1-9]+)$/.test( $(this).val() ))
				{	
					$("form#form_basket_recount").submit();
				}
					
			});
			
		});

	
	function change_basket_order_type(value)
	{
		
		var basket_price = $("input[name='basket_order_price']",$("form#form_order")).val();
		basket_price = parseFloat(basket_price);
		var order_price = 0;
		
		if (basket_price < parseFloat(config['SHOP_DOSTAVKA_LIMIT']) && parseInt(value) > 1)
		{
			basket_price += parseFloat(config['SHOP_DOSTAVKA_PRICE']);
			order_price = parseFloat(config['SHOP_DOSTAVKA_PRICE']);
		}
		
		$("span#dostavka_ajax").html(number_format(order_price, 2, '.', ''));
		$("span#total_ajax").html(number_format(basket_price, 2, '.', ''));
		
	}
	
	$("select[name='order_type']", $("form#form_order")).change(function(){
		change_basket_order_type( parseInt($(this).val()) );
	});
	
	change_basket_order_type( $("select[name='order_type'] option:selected", $("form#form_order")).val() );
	
	
	
	$("form#form_order").validate({
		
		rules : {
			name : { required : true, minlength : 4 },
			phone : {phone_valid : true},
			email : {email : true, required : true},
			order_type : {required: true, number:true}
			
		},
		
		messages : {
			name : {required:"", minlength:""},
			phone : {phone_valid : ""},
			email : {email : "", required : ""},
			order_type : {required : "", number: ""}
		}
		
	});
	
	
	
	
});