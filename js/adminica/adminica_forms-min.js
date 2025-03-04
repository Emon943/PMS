function adminicaForms(){
    $("fieldset > div > input[type=text]").addClass("text");
    $("fieldset > div > input[type=email]").addClass("text");
    $("fieldset > div > input[type=number]").addClass("text");
    $("fieldset > div > input[type=password]").addClass("text");
    $("fieldset > div > textarea").addClass("textarea");
    $("fieldset > div > input[type=checkbox]").addClass("checkbox");
    $("fieldset > div > input[type=radio]").addClass("radio");
    $("fieldset > div > input[type=checkbox].indeterminate").prop("indeterminate",!0);
    $.fn.validate&&$(".validate_form").validate();
    $(".alert.dismissible").on("click",function(){
        $(this).animate({
            opacity:0
        },"slow",function(){
            $(this).slideUp()
            })
        });
    $.fn.autoGrow&&$("textarea.autogrow").autoGrow();
    $.fn.datepicker&&$(".datepicker").datepicker({
        dateFormat:"d M yy",
        showOn:"focus"
    });
    if($.fn.slider){
        function e(e,t){
            var n=$(this).children().children().size();
            $(this).children("ol.slider_labels").children("li").css({
                "margin-right":100/(n-1)+"%"
                })
            }
            $(".slider").slider({
            min:"0",
            max:"100",
            range:"min",
            slide:function(e,t){
                $("#slider_value").text(t.value)
                },
            create:e
        })
        }
        if($.fn.slider){
        $(".slider_range").slider({
            range:!0,
            min:0,
            max:500,
            values:[75,300],
            slide:function(e,t){
                $("#amount").val("$"+t.values[0]+" - $"+t.values[1])
                }
            });
    $("#amount").val("$"+$("#slider_range").slider("values",0)+" - $"+$("#slider_range").slider("values",1));
    $(".slider_vertical > span").each(function(){
        var e=parseInt($(this).text());
        $(this).empty().slider({
            value:e,
            range:"min",
            animate:!0,
            orientation:"vertical"
        })
        });
    function t(){
        var e=$(this).attr("title");
        $(this).append('<div class="unlock_message">'+e+"</div>")
        }
        function n(){
        var e=$(this).slider("value"),t=e/100*-30;
        $(this).find(".ui-slider-handle").css("margin-left",t+"px")
        }
        function r(e,t){
        if($(this).slider("value")>95){
            $(this).siblings("button, input").trigger("click");
            $(this).find(".ui-slider-handle").delay(500).animate({
                left:"0%",
                "margin-left":0
            },350);
            $(this).find(".ui-slider-range").delay(500).animate({
                width:0
            },function(){
                $(this).slider("value",0)
                })
            }else{
            $(this).find(".ui-slider-handle").animate({
                left:"0%",
                "margin-left":0
            });
            $(this).find(".ui-slider-range").animate({
                width:0
            },function(){
                $(this).slider("value",0)
                })
            }
        }
    $(".slider_unlock").slider({
    value:"0",
    range:"min",
    animate:!0,
    stop:r,
    slide:n,
    change:n,
    create:t
})
}
$.fn.progressbar&&$(".progressbar").progressbar({
    value:75
});
if($.fn.buttonset){
    $(".jqui_checkbox").buttonset();
    $(".jqui_radios").buttonset();
    $(".jqui_radios > label").on("click",function(){
        $(this).siblings().removeClass("ui-state-active")
        })
    }
    $.fn.uniform&&setTimeout('$(".uniform input, .uniform, .uniform a, .time_picker_holder select").uniform();',10);
$.fn.knob&&$(".knob").knob();
$.fn.multiselect&&$(".multisorter").multiselect();
$.fn.timepicker&&$(".time_picker").timepicker();
if($.fn.ColorPicker){
    $("#colorpicker_inline").ColorPicker({
        flat:!0
        });
    $("#colorpicker_popup").ColorPicker({
        onSubmit:function(e,t,n,r){
            $(r).val(t);
            $(r).ColorPickerHide()
            },
        onBeforeShow:function(){
            $(this).ColorPickerSetColor(this.value)
            }
        }).on("keyup",function(){
    $(this).ColorPickerSetColor(this.value)
    })
}
$.fn.stars&&$("#star_rating").stars({
    inputType:"select"
});
$.fn.tipTip&&$(".tooltip").tipTip({
    defaultPosition:"top",
    maxWidth:"auto",
    edgeOffset:0
});
var i=["ActionScript","AppleScript","Asp","BASIC","C","C++","Clojure","COBOL","ColdFusion","Erlang","Fortran","Groovy","Haskell","Java","JavaScript","Lisp","Perl","PHP","Python","Ruby","Scala","Scheme"];
$(".autocomplete").autocomplete({
    source:i
});
$.fn.tagit&&setTimeout("$('.tagit').tagit();",3e3);
if($.fn.dialog){
    $(".dialog_content").dialog({
        autoOpen:!1,
        resizable:!1,
        show:"fade",
        hide:"fade",
        modal:!0,
        width:"500",
        show:{
            effect:"fade",
            duration:500
        },
        hide:{
            effect:"fade",
            duration:500
        },
        create:function(){
            $(".dialog_content.no_dialog_titlebar").dialog("option","dialogClass","no_dialog_titlebar")
            },
        open:function(){
            setTimeout(columnHeight,100)
            }
        });
$(".dialog_button").live("click",function(){
    var e=$(this).attr("data-dialog");
    $("#"+e).dialog("open");
    return!1
    });
$(".close_dialog").live("click",function(){
    $(".dialog_content").dialog("close");
    return!1
    });
$(".link_button").live("click",function(){
    var e=$(this).attr("data-link");
    window.location.href=e;
    return!1
    });
$(".dialog_content.very_narrow").dialog("option","width",300);
$(".dialog_content.narrow").dialog("option","width",450);
$(".dialog_content.wide").dialog("option","width",650);
$(".dialog_content.medium_height").dialog("option","height",315);
$(".dialog_content.no_modal").dialog("option","modal",!1);
$(".dialog_content.no_modal").dialog("option","draggable",!1);
$(".ui-widget-overlay").live("click",function(){
    $(".dialog_content").dialog("close");
    return!1
    })
}
if($.fn.slider){
    function s(e,t){
        if($(this).slider("value")>95){
            $("#dialog_content_1").dialog("close");
            $(this).find(".ui-slider-handle").animate({
                left:0
            },350);
            $(this).find(".ui-slider-range").animate({
                width:0
            })
            }else{
            $(this).find(".ui-slider-handle").animate({
                left:0
            },350);
            $(this).find(".ui-slider-range").animate({
                width:0
            })
            }
        }
    $("#slider_close_dialog").slider({
    value:"0",
    range:"min",
    animate:!0,
    stop:s
})
}
$.fn.select2&&$(".select2").select2({
    allowClear:!0,
    minimumResultsForSearch:10
})
};