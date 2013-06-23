var Catalog = new function()
{

	var instance;
	
	function Catalog()
	{
		if (instance)
			return instance;
		else
			instance = this;
		
		Catalog.prototype.fast_order_form = "form#fast_order_form";
		Catalog.prototype.filter_tire_form = "form#filter_tire";
		Catalog.prototype.filter_tire_form = "form#filter_disk";
		
	}

	Catalog.prototype.fast_order = function()
	{
		
		if ($(this.fast_order_form).length)
		{
			
		}
		
	}
	
	Catalog.prototype.filter_tire = function()
	{
		
	}
	
	return Catalog;

}

$(document).ready(function(){
	
	new Catalog();
	
});