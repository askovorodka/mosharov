
$(document).ready( function(){

    $("input.itemsnumber").change(function(){
        $(this).parents("form").submit();
    });

    $("button.catbutton").click(function(){

        this.response = function(response){
            $("div#loading-layer").hide();
            var floor = response.split(";");
            $("#basket_number").html(floor[0]);
            $("#basket_currency").html(floor[1]);

            if ($("div#basket_block").css("display") == "none") {
                $("div#basket_block").fadeIn("fast");
            }

        };

        var top = $(window).scrollTop();
        var top_pos = top + $(window).height() / 2;
        var left_pos = ($(window).width() / 2) - ($("#loading-layer").outerWidth() / 2);

        //var product_count = parseInt( $(this).attr("count") );

        var product_id = parseInt($(this).attr("product_id"));
        var product_count = parseInt( $("input[type='text'][name='price" + product_id + "']").val() );
        if (product_count && product_count && product_count > 0)
        {
            $("div#loading-layer").css({"top": top_pos, "left" : left_pos}).show();
            var self = this;
            $({}).delay(800).queue(function(){
                $.post('http://' + location.hostname + '/catalog/basket/add/', {product_id : product_id, product_count : product_count}, self.response );
            });


        }
        return false;
    });


    $('a.gallery1, a.gallery2').lightBox({fixedNavigation: false});

    $("a.CatalogImages").click(function(){
        var src = $(this).attr("image");
        if ($.trim(src) == "") return false;
        $("#ImageLayout").empty();
        $("#ImageLayout").append( $("<IMG>").attr("src", src).click(function(){ $("#ImageLayout").hide(); }) );
        $("#ImageLayout").css({"left" : $(this).offset().left, "top" : $(this).offset().top} ).show();
        return false;
    });

    $("#ImageLayout").click(function(){ $(this).hide(); });

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



    var form_basket_validate = $("form#form_basket").validate(
        {

            errorPlacement: function(error, element) {
                error.insertAfter( element );
            },

            rules:
                {
                    name :	{required: true}
                },
            messages:
                {
                    count:	{
                        required : "Введите имя",
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

