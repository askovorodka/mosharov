(function () {
    //слайдер на главной
    var $sliderButtonLeft = $('#banners__slider_left-button');
    var $sliderButtonRight = $('#banners__slider_right-button');
    var $sliderItems = $('.banners__slider__item');
    var activeItem = 0;

    if ($sliderItems.length > 1) {
        //$sliderButtonLeft.removeClass('g-hidden');
        $sliderButtonRight.removeClass('g-hidden');

        $sliderButtonLeft.click(function(){
            $sliderItems.each(function(index) {
                if (index === activeItem) {
                    $(this).addClass('g-hidden');

                    activeItem = index - 1;

                    $('#banners__slider__item-' + (activeItem + 1)).removeClass('g-hidden');

                    if (activeItem === 0) {
                        $sliderButtonLeft.addClass('g-hidden');
                    }
                    if (activeItem < $sliderItems.length - 1) {
                        $sliderButtonRight.removeClass('g-hidden');
                    }

                    return false;
                }
            });
        });

        $sliderButtonRight.click(function(){
            $sliderItems.each(function(index) {

                $sliderButtonLeft.removeClass('g-hidden');

                if (index === activeItem) {
                    $(this).addClass('g-hidden');
                    activeItem = index + 1;

                    $('#banners__slider__item-' + (activeItem + 1)).removeClass('g-hidden');

                    if (activeItem === $sliderItems.length - 1) {
                        $sliderButtonRight.addClass('g-hidden');
                    }

                    return false;
                }
            });
        });

        setInterval(function () {
            for (var i = 0; i < $sliderItems.length; i++) {
                $sliderButtonLeft.removeClass('g-hidden');
                $sliderButtonRight.removeClass('g-hidden');

                if ( !($( $sliderItems[i] ).hasClass('g-hidden')) && i === ($sliderItems.length - 1)) {
                    $( $sliderItems[i] ).addClass('g-hidden');
                    $( $sliderItems[0] ).removeClass('g-hidden');
                    activeItem = 0;
                    $sliderButtonLeft.addClass('g-hidden');
                    break;
                } else if ( !($( $sliderItems[i] ).hasClass('g-hidden')) ) {
                    $( $sliderItems[i] ).addClass('g-hidden');
                    $( $sliderItems[i + 1] ).removeClass('g-hidden');
                    activeItem = i + 1;

                    if ((i + 1) === ($sliderItems.length - 1)) {
                        $sliderButtonRight.addClass('g-hidden');
                    }
                    break;
                }
            }
        }, 5000);
    }

    //райндж в фильтрах
    var $range = $('#filters__items__item_range');
    var $rangeActive = $('#filters__items__item_range_active');
    var $rangeTogglerL = $('#filters__items__item_range--first');
    var $rangeTogglerR = $('#filters__items__item_range--second');
    var $rangeInputFrom = $('#filters__items__item_input_from');
    var $rangeInputTo = $('#filters__items__item_input_to');
    var range = 100;

    if ($range.length) {
        //определяем ширину полосы диапазона цен и минусуем половину ширины бегунка
        var rangeWidth = $range.outerWidth();
        var offsetX = $range.offset().left;

        //вычисляем количество шагов исходя из диапазона значений
        var stepsCount = ($rangeInputTo.attr('data-val') - $rangeInputFrom.attr('data-val')) / range;

        //вычисляем интервал шага
        var oneStep = rangeWidth / stepsCount;

        //перетаскиваем второй бегунок до конца полосы
        $rangeTogglerR.css('left', rangeWidth + 'px');

        var dragToggler = function (item) {
            item.mousedown(function(){

                //перемещаем элемент
                function moveTo(e) {
                    item.css('left', (e.pageX - offsetX) + 'px');
                    var leftMax = Math.max($rangeTogglerL.position().left, $rangeTogglerR.position().left);
                    var leftMin = Math.min($rangeTogglerL.position().left, $rangeTogglerR.position().left);

                    //высчитываем значения для полей формы
                    $rangeInputFrom.val(Math.round(leftMin / oneStep) * range);
                    $rangeInputTo.val(Math.round(leftMax / oneStep) * range);

                    $rangeActive.css({
                        'left': leftMin + 'px',
                        'width': (leftMax - leftMin) + 'px'
                    });
                }

                //вешаем обработчик движения мыши
                $(document).bind('mousemove', function(e) {
                    if (e.pageX >= offsetX && e.pageX <= (offsetX + rangeWidth)) {
                        moveTo(e);
                    }
                });

                //при отпускании кнопки удаляем обработчик движения мыши
                $(document).mouseup(function(){
                    $(document).unbind('mousemove');
                });

                //убираем выделение элементов при движении мыши
                return false;
            });
        };

        dragToggler($rangeTogglerL);
        dragToggler($rangeTogglerR);
    }

    //если в локасторадж есть email, значит юзер залогинен
    if (window.localStorage && window.localStorage !== null && localStorage.getItem('userEmail') !== null) {
        $('#lk').text("Ваш кабинет");
        $('#logout').removeClass('g-hidden');
    }

    //меняем картинки по клику в описании товара, ссылка на картинку берется из data атрибута
    $('.js-item__photos__another_photo').click(function(){
        $("#item__photos_main_picture").attr("src", $(this).attr("data-image")).attr("data-big", $(this).attr("data-big"));
    });

    //отображаем фрагмент увеличенного варианта изображения
    $('#item__photos_main').hover(function(){
        var $pictContainer = $(this);
        var bigPict = $('#item__photos_main_picture').attr('data-big');
        var left = $pictContainer.offset().left + $pictContainer.width() + 20;
        $pictContainer.prepend('<div class="item__photos_main_loop" id="item__photos_main-loop" style="left:' + left + 'px;"><img src="' + bigPict + '" id="item__photos_main-loop-image"></div>');

        //вешаем обработчик движения мыши
        $(document).bind('mousemove', function(e) {
            var $image =  $('#item__photos_main-loop-image');
            var $imageContainer = $('#item__photos_main-loop');
            var imageW = $image.width();
            var imageH = $image.height();
            var imageContainerW = $imageContainer.width();
            var imageContainerH = $imageContainer.height();

            //боремся с Firefox
            var offsetX = e.offsetX ? e.offsetX : e.originalEvent.layerX;
            var offsetY = e.offsetY ? e.offsetY : e.originalEvent.layerY;

            //определяем процент отступа
            var marginLeft = Math.round(offsetX / ($pictContainer.width() / 100));
            var marginTop = Math.round(offsetY / ($pictContainer.height() / 100));

            //определяем отступ в пикселях плюс добавляем четверть ширины контейнера для ограничения с левой стороны
            var realLeft = -(imageW / 100) * (marginLeft - 25);
            var realTop = -(imageH / 100) * (marginTop - 25);

            var imageMarginLeft = realLeft + 'px';
            var imageMarginTop = realTop + 'px';

            //смотрим не уперлось ли куда по горизонтали
            if (realLeft >= 0 ) {
                imageMarginLeft = '0px';
            } else if ((imageW + realLeft) <= imageContainerW) {
                imageMarginLeft = -(imageW - imageContainerW)  + 'px';
            }

            //смотрим не уперлось ли куда по вертикали
            if (realTop >= 0 ) {
                imageMarginTop = '0px';
            } else if ((imageH + realTop) <= imageContainerH) {
                imageMarginTop = -(imageH - imageContainerH)  + 'px';
            }

            $image.css({
                'margin-left': imageMarginLeft,
                'margin-top':  imageMarginTop
            });
        });

    }, function(){
        //коллбеком при уходе мыши с картинки убираем привязку к mousemove и удаляем элемент
        $(document).unbind('mousemove');
        $('#item__photos_main-loop').remove();
    });

    //выделяем выбранные позиции фильтра
    $('#filter').click(function(event){
        $(event.target).toggleClass('selected');
    });

    //в зависимости от текста кнопки либо отображаем форму для логина, либо идем в личный кабинет
    $('#lk').click(function(event){
        if ($(event.target).text() === "Войти") {
            $('#auth').removeClass('g-hidden');
            return false;
        }
        if ($(event.target).text() === "Ваш кабинет") {
            document.location.href = 'http://' + document.location.host + '/cabinet/';
        }
    });

    //посылаем запрос авторизации
    $('#auth_send').click(function(event){
        var username = $('#auth_username');
        var password = $('#auth_password');

        username.removeAttr('style');
        password.removeAttr('style');

        if (!username.val()) {
            username.css('border', '1px solid red');
        } else if (!password.val()) {
            password.css('border', '1px solid red');
        } else {
            $.ajax({
                type:'post',
                url: '/cabinet/',
                data: 'submit_login=1&email=' + username.val() + '&password=' + password.val(),
                success: function(response) {
                    if (response.status === "error") {
                        username.css('border', '1px solid red');
                        password.css('border', '1px solid red');
                    } else {
                        if (window.localStorage && window.localStorage !== null) {
                            localStorage.setItem('userName', response.data.name);
                            localStorage.setItem('userEmail', response.data.email);
                        }
                        $('#lk').text("Ваш кабинет");
                        $('#logout').removeClass('g-hidden');
                        $('#auth').addClass('g-hidden');

                        if (window.location.pathname == "/catalog/basket/") {
                            location.reload();
                        }
                    }
                }
            });
        }
    });

    if (typeof properties != "undefined") {
        var sizesBrand = properties.sizes_brand;
        var sizesBrandHtml = '';

        if (!$(".item__info__selecter").is(".js-sizes-brand")) {
            for (var item in sizesBrand) {
                if (sizesBrand.hasOwnProperty(item)) {
                    sizesBrandHtml += '<div class="size js-sizes-brand" data-size="' + item + '" style="display: none;">' + item + '</div>';
                }
            }

            $('#current-item-sizes').append(sizesBrandHtml);
        }

        //выбираем цвета
        $('.item__info__selecter .color').click(function(event){
            if ($(event.target).hasClass('selected')) {return;}

            var color = $(event.target).attr('data-caption');

            if (color) {
                $('#item_selected-color').text(color);
            }

            event.stopPropagation();
         });

        //выбираем размеры
        $('.item__info__selecter .size').click(function(event){
            $('.item__info__selecter .size').removeClass('g-hidden');
            $('.item__info__selecter .color').removeClass('g-hidden selected');

            if ($(event.target).hasClass('selected')) {return;}

            var size = $(event.target).attr('data-size');
            var sizeColors = [];

            if ($('#item-sizetype').val() == 'rus') {
                sizeColors = properties.sizes[size]; //it is array
            } else {
                sizeColors = properties.sizes_brand[size]; //it is array
            }

            $('.item__info__selecter .color').each(function(index, elem){
                var hideMe = true;
                for (var i = 0; i < sizeColors.length; i++) {
                    if (sizeColors[i][0] == $(elem).attr('data-color')) {
                        hideMe = false;
                        break;
                    }
                }

                if (hideMe) {
                    $(elem).addClass('g-hidden');
                }
            });
            event.stopPropagation();
        });
    }



    //переключаем тип размеров
    $('#item-sizetype').change(function(event){
        var $sizesRus = $('.item__info__selecter .js-sizes-rus');

        $('.item__info__selecter .size').removeClass('g-hidden selected');
        $('.item__info__selecter .color').removeClass('g-hidden selected');

        if ($('#item-sizetype').val() == 'manufacturer') {

            $sizesRus.each(function(index, elem){
                $(elem).attr('style', 'display:none');
            });

            $('.item__info__selecter .js-sizes-brand').each(function(index, elem){
                $(elem).attr('style', '');
            });
        } else {
            $('.item__info__selecter .js-sizes-brand').each(function(index, elem){
                $(elem).attr('style', 'display:none');
            });

            $sizesRus.each(function(index, elem){
                $(elem).attr('style', '');
            });
        }
    });

    //посылаем запрос на выход
    $('#logout').click(function(event){
        localStorage.clear();
        document.location.href = 'http://' + document.location.host + '/cabinet/logout/';
    });

    //закрываем окно логина при клике вне его
    $('#auth').click(function(event){
        event.stopPropagation();
        $(this).addClass('g-hidden');
    });

    //выключаем проваливание на самом окне
    $('.auth__form').click(function(event){
        event.stopPropagation();
    });

    //если корзина, то делаем юзеру приятно
    /*if (window.location.pathname == "/catalog/basket/" && userData) {

     }*/


})();