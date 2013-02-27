$(document).ready(function(){
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