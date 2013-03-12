$(document).ready(function(){
	
	var question = $("form#question").validate(
			{
		 		
				errorPlacement: function(error, element) {
					$(element).addClass('error');
		   		},
		    	
				rules:
				{
					name :	{required: true},
					contacts :	{required: true},
					text :	{required: true}
				},
				messages:
				{
					name:	{ required : "������� ���" },
					contacts:	{ required : "������� ��������" },
					text:	{ required : "������� �����" }
				}
			}
			);
	
	
	//������� ����� � ������ ���������
	$('td.tablecatimg a').lightBox({fixedNavigation:false});
		
	//�������� �����
	$("form#question").submit(function(){
		try{
		if (!question.form())
			return false;
		
		var name = $("input[name='name']", $(this)).val();
		var contacts = $("input[name='contacts']", $(this)).val();
		var text = $("textarea[name='text']", $(this)).val();

		$.ajax({
			
			type : 'get',
			url : 'http://' + location.hostname + '/mail.php',
			data : {type : 'question', name : name, contacts : contacts, text:text},
			success : function(){ alert('��� ������ ���������. �������!'); }
			
		});
		}
		catch(e){}
		return false;
	});
	
	//���������� �������
	$("input[type='image']", $("#phone", $(".simpleform"))).click(function(){
		
		var phone = $(this).siblings().filter(function(){ return $(this).attr("name") == "phone"; }).val();
		
		$.ajax({
			
			type : 'get',
			url : 'http://' + location.hostname + '/mail.php',
			data : {type : 'phone', phone : phone},
			success : function(){ alert('���� ��������� ����������. �������!'); }
			
		});
		
	});

	
	//���������� ��������
	$("input[type='image']", $("#order", $(".simpleform"))).click(function(){
		
		var name = $(this).siblings().filter(function(){ return $(this).attr("name") == "name"; }).val();
		var auto = $(this).siblings().filter(function(){ return $(this).attr("name") == "auto"; }).val();
		var zapchast = $(this).siblings().filter(function(){ return $(this).attr("name") == "zapchast"; }).val();
		var phone = $(this).siblings().filter(function(){ return $(this).attr("name") == "phone"; }).val();
		
		$.ajax({
			
			type : 'get',
			url : 'http://' + location.hostname + '/mail.php',
			data : {type : 'order', name:name, auto:auto, zapchast:zapchast, phone : phone},
			success : function(){ alert('��� ����� �� �������� ���������. �������!'); }
			
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