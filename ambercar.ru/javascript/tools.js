$(document).ready(function(){
	
	//обратная связь
	$("form#question").submit(function(){
		var name = $("input[name='name']", $(this)).val();
		var contacts = $("input[name='contacts']", $(this)).val();
		var text = $("textarea[name='text']", $(this)).val();

		$.ajax({
			
			type : 'get',
			url : 'http://' + location.hostname + '/mail.php',
			data : {type : 'question', name : name, contacts : contacts, text:text},
			success : function(){ alert('Ваш вопрос отправлен. Спасибо!'); }
			
		});
		
		return false;
	});
	
	//отправляем телефон
	$("input[type='image']", $("#phone", $(".simpleform"))).click(function(){
		
		var phone = $(this).siblings().filter(function(){ return $(this).attr("name") == "phone"; }).val();
		
		$.ajax({
			
			type : 'get',
			url : 'http://' + location.hostname + '/mail.php',
			data : {type : 'phone', phone : phone},
			success : function(){ alert('Ваше сообщение отправлено. Спасибо!'); }
			
		});
		
	});

	
	//отправляем запчасть
	$("input[type='image']", $("#order", $(".simpleform"))).click(function(){
		
		var name = $(this).siblings().filter(function(){ return $(this).attr("name") == "name"; }).val();
		var auto = $(this).siblings().filter(function(){ return $(this).attr("name") == "auto"; }).val();
		var zapchast = $(this).siblings().filter(function(){ return $(this).attr("name") == "zapchast"; }).val();
		var phone = $(this).siblings().filter(function(){ return $(this).attr("name") == "phone"; }).val();
		
		$.ajax({
			
			type : 'get',
			url : 'http://' + location.hostname + '/mail.php',
			data : {type : 'order', name:name, auto:auto, zapchast:zapchast, phone : phone},
			success : function(){ alert('Ваш заказ на запчасть отправлен. Спасибо!'); }
			
		});
		
	});
	
	
	$("a.tabs", $("div.simpleform")).click(function(){
		
		$("a.tabs", $("div.simpleform")).removeClass("simpleformlnk").addClass("simpleformlnksecond");
		
		$(this).removeClass("simpleformlnksecond").addClass("simpleformlnk");
		
		
		$("div", $("div.simpleform")).addClass("hide").removeClass('simpleforminner');
		
		$("div#" + $(this).attr("elem"), $("div.simpleform"))
		.removeClass("hide")
		.removeClass("simpleforminnersecond")
		.addClass('simpleforminner');
		
		return false;
	});
});