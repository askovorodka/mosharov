!function(){var a=$("#banners__slider_left-button"),b=$("#banners__slider_right-button"),c=$(".banners__slider__item"),d=0;c.length>1&&(b.removeClass("g-hidden"),a.click(function(){c.each(function(e){return e===d?($(this).addClass("g-hidden"),d=e-1,$("#banners__slider__item-"+(d+1)).removeClass("g-hidden"),0===d&&a.addClass("g-hidden"),d<c.length-1&&b.removeClass("g-hidden"),!1):void 0})}),b.click(function(){c.each(function(e){return a.removeClass("g-hidden"),e===d?($(this).addClass("g-hidden"),d=e+1,$("#banners__slider__item-"+(d+1)).removeClass("g-hidden"),d===c.length-1&&b.addClass("g-hidden"),!1):void 0})}));var e=$("#filters__items__item_range"),f=$("#filters__items__item_range_active"),g=$("#filters__items__item_range--first"),h=$("#filters__items__item_range--second"),i=$("#filters__items__item_input_from"),j=$("#filters__items__item_input_to"),k=100;if(e.length){var l=e.outerWidth(),m=e.offset().left,n=(j.attr("data-val")-i.attr("data-val"))/k,o=l/n;h.css("left",l+"px");var p=function(a){a.mousedown(function(){function b(b){a.css("left",b.pageX-m+"px");var c=Math.max(g.position().left,h.position().left),d=Math.min(g.position().left,h.position().left);i.val(Math.round(d/o)*k),j.val(Math.round(c/o)*k),f.css({left:d+"px",width:c-d+"px"})}return $(document).bind("mousemove",function(a){a.pageX>=m&&a.pageX<=m+l&&b(a)}),$(document).mouseup(function(){$(document).unbind("mousemove")}),!1})};p(g),p(h)}$(".js-item__photos__another_photo").click(function(){$("#item__photos_main_picture").attr("src",$(this).attr("data-image"))}),$("#item__photos_main").hover(function(){var a=$(this),b=a.offset().left+a.width()+20;a.prepend('<div class="item__photos_main_loop" id="item__photos_main-loop" style="left:'+b+'px;"><img src="/img/pict_item_item--big.jpg" id="item__photos_main-loop-image"></div>'),$(document).bind("mousemove",function(b){var c=$("#item__photos_main-loop-image"),d=$("#item__photos_main-loop"),e=c.width(),f=c.height(),g=d.width(),h=d.height(),i=b.offsetX?b.offsetX:b.originalEvent.layerX,j=b.offsetY?b.offsetY:b.originalEvent.layerY,k=Math.round(i/(a.width()/100)),l=Math.round(j/(a.height()/100)),m=-(e/100)*(k-25),n=-(f/100)*(l-25),o=m+"px",p=n+"px";m>=0?o="0px":g>=e+m&&(o=-(e-g)+"px"),n>=0?p="0px":h>=f+n&&(p=-(f-h)+"px"),c.css({"margin-left":o,"margin-top":p})})},function(){$(document).unbind("mousemove"),$("#item__photos_main-loop").remove()})}();