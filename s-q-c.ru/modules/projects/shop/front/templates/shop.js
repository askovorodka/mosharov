function doLoad(force,p_id) {

		var val = document.getElementById('product_number_'+p_id).value.match(/\b(^([1-9]+)$)\b/gi);
		if (!val){
			alert('Введите количество продукта');
			return false;
		}		else
			var product_number = '' + document.getElementById('product_number_'+p_id).value;

		var znak = document.getElementById('znak').value;

		switch_loading_box('loading-layer');
        var product_id = '' + document.getElementById('product_id_'+p_id).value;
        //var product_number = '' + document.getElementById('product_number_'+p_id).value;
        var req = new Subsys_JsHttpRequest_Js();

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                if (req.responseJS) {
			obj_number = document.getElementById('basket_number');
			obj_total = document.getElementById('basket_total');
			obj_currency = document.getElementById('basket_currency');

			if (typeof(obj_number)) {obj_number.innerHTML = '<span style=color:#FFFFFF;>' + (req.responseJS.basket_number||'') + '</span>';}
			if (typeof(obj_total)) obj_total.innerHTML = '<span style=color:#FFFFFF;>' + (req.responseJS.basket_total||'') + '</span>';
			//if (typeof(obj_currency)) obj_currency.innerHTML = '<span style=color:#FFFFFF;>' + (req.responseJS.currency||'') + '</span>';
			if (typeof(obj_currency)) obj_currency.innerHTML = '<span style=color:#FFFFFF;>' + znak + '</span>';
               }

		setTimeout("switch_loading_box('loading-layer')",400);
            }
   }

        req.caching = false;
        module_url = window.location.toString();
        module_url = module_url.replace("http://","");
        module_url = module_url.split("/");
        module_url = "http://"+module_url[0]+"/"+module_url[1];

        req.open('GET', module_url+'/basket_add/', true);

        req.send({product_id:product_id, product_number:product_number});

        return false;
}


function doLoad2(force,p_id) {

		var znak = document.getElementById('znak').value;

		switch_loading_box('loading-layer');
        var product_id = '' + document.getElementById('product_id_'+p_id).value;
        //var product_number = '' + document.getElementById('product_number_'+p_id).value;
        var req = new Subsys_JsHttpRequest_Js();

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                if (req.responseJS) {
			obj_number = document.getElementById('basket_number');
			obj_total = document.getElementById('basket_total');
			obj_currency = document.getElementById('basket_currency');

			if (typeof(obj_number)) {obj_number.innerHTML = '<span style=color:#FFFFFF;>' + (req.responseJS.basket_number||'') + '</span>';}
			if (typeof(obj_total)) obj_total.innerHTML = '<span style=color:#FFFFFF;>' + (req.responseJS.basket_total||'') + '</span>';
			//if (typeof(obj_currency)) obj_currency.innerHTML = '<span style=color:#FFFFFF;>' + (req.responseJS.currency||'') + '</span>';
			if (typeof(obj_currency)) obj_currency.innerHTML = '<span style=color:#FFFFFF;>' + znak + '</span>';
               }

		setTimeout("switch_loading_box('loading-layer')",400);
            }
   }

        req.caching = false;
        module_url = window.location.toString();
        module_url = module_url.replace("http://","");
        module_url = module_url.split("/");
        module_url = "http://"+module_url[0]+"/"+module_url[1];

        req.open('GET', module_url+'/basket_add/', true);

        req.send({product_id:product_id, product_number:1});

        return false;
}
