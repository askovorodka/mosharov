jQuery.validator.addMethod("phone_valid", function(value, element) {
    //return /(\d{3})(\s|\-)?(\d{3})(\s|\-)?(\d{2})(\s|\-)?(\d{2})$/.test(value);
	return /^\d{10,11}$/.test(value);
}, "");

$(document).ready(function(){
	
	$("form#fast_order_form").submit(function(){
		
		return false;
	});
	
	$("input[name='phone']", $("form#fast_order_form")).keydown(function(e){
		
		if ($.inArray(e.which, [8,46]) > -1)
			return true;
		
		if (e.which > 95 && e.which < 106)
		{
			/*if (!/\d+/.test( $(this).val() ))
			{
				$(this).val("(___) ___-__-__");
			}*/
			return true;
		}
		else
		{
			return false;
		}
	});
	
	$("form#fast_order_form").validate({
		
		rules : {
			product_count : {required : true, number : true},
			fio : { required : true, minlength : 4 },
			phone : {phone_valid : true}
		},
		
		messages : {
			product_count : { required : "", number : "" },
			fio : {required:"", minlength:""},
			phone : {phone_valid : ""}
		}
		
	});
	
	
});