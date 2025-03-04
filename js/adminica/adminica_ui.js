function adminicaUi(){

	//jQuery UI elements (more info can be found at http://jqueryui.com/demos/)

	// Navigation accordions
		$(".dropdown_menu > ul > li").each(function(){
			$(this).children("ul").addClass("dropdown").parent().addClass("has_dropdown");
		});

		$("ul.drawer").parent("li").addClass("has_drawer");

		$(".has_drawer > a").bind('click',function(){
			var menuType = ($(this).parent().parent().hasClass("open_multiple"));
			if (menuType != true){
				$(this).parent().siblings().removeClass("open").children("ul.drawer").slideUp();
			}
			$(this).parent().toggleClass("open").children("ul").slideToggle();
			return false;
		});


		// Set on state icon colour

		$('#nav_top > ul > li.current > a > img').each(function(){
			var imgPath = $(this).attr('src').replace("/grey/", "/white/");
			$(this).attr('src', imgPath);
		});

	navCurrent();



	// Side Nav

	$('#sidebar').mouseenter(function(){
		if ($(this).stop(true,true).css('z-index') == '999'){
		$(this).animate({
			left: '-10px'
		}, 200);
		}
	});

	$('#sidebar').mouseleave(function(){
		if ($(this).stop(true,true).css('z-index') == '999'){
		$(this).animate({
			left: '-200px'
		}, 300);
		}
	});

	sideNavCurrent();

	// Stack Nav

	$(".stackbar > ul > li > a").on("click", function(){

		if ($(this).attr("href") == "#"){
			$(".stackbar > ul li").removeClass("current");
			$(this).parent().addClass("current");
		}

		$(".stackbar > ul li").removeClass("current");
		$(this).parent().addClass("current");

		if ($(this).parent().find("ul").length>0){
			$(this).parents(".stackbar").removeClass("list_view").addClass("stack_view");
		}
		else{
			$(this).parents(".stackbar").addClass("list_view").removeClass("stack_view");
		}

	});

	stackNavCurrent();


	// Isolated mode

	$(".isolate").parent().parent().addClass('isolate');


	// Slide to top link

	if($.fn.UItoTop){
		$().UItoTop({ easingType: 'easeOutQuart' });
	}


 	// Content Box Toggle Config

	$("a.toggle").on('click', function(){
		$(this).toggleClass("toggle_closed").parent().next().slideToggle("slow");
		$(this).parent().siblings(".box_head, .tab_header").removeClass("round_top").toggleClass("round_all");
		$(this).parent().parent().toggleClass("closed");
		return false; //Prevent the browser jump to the link anchor
	});


	// toggle all boxes

	$(".toggle_all a").on('click', function(){
		if ($(this).hasClass("close_all")){
			$(".box .toggle").trigger("click");
		}
		if ($(this).hasClass("show_all")){
			$(".box .toggle_closed").trigger("click");
		}

		$(this).parent().not(".closed").toggleClass("closed", 600);
		$(this).parent(".closed").toggleClass("closed");
	});

	$("[data-toggle-class]").on('click', function(){
		x = $(this).attr('data-toggle-class');
		$(".box."+x+" .toggle").trigger("click");
	});


 	// Hide a Content Box

	$(".dismiss_button").on("click",function(){
		var theTarget = $(this).attr("data-dismiss-target");
		console.log(theTarget);
		$(theTarget).animate({opacity:0},'slow',function(){
			$(this).slideUp();
		});
	});


 	// Content Box Tabs Config

	if($.fn.tabs){
		$( ".tabs" ).tabs({
			fx: {opacity: 'toggle', duration: 'fast'},
			select: function(e, ui){
				$(this).removeClass('all_open', 200);
				$(this).removeClass('closed', 200);
				$(this).find('.toggle_closed').trigger('click');
			}
		});

		$(".tabs:not('.all_open') .show_all_tabs").on('click', function(){
			$(this).parent().siblings('.tab_header').children().removeClass('ui-tabs-selected');
			$(this).parent().parent().addClass('all_open');
		});

		$(".tabs.all_open .show_all_tabs").on('click', function(){
			$(this).parent().siblings('.tab_header').find("li:first-child").trigger('click').addClass('ui-tabs-selected');
			$(this).parent().parent().removeClass('all_open');
		});

		$( ".side_tabs" ).tabs({
			fx: {opacity: 'toggle', duration: 'fast', height:'auto'}
		});
	}


	// Content Box Accordion Config

	if($.fn.accordion){
		$( ".content_accordion" ).accordion({
			collapsible: true,
			active:false,
			header: 'h3.bar', // this is the element that will be clicked to activate the accordion
			autoHeight:false,
			event: 'mousedown',
			icons:false,
			animated: true
		});
	}


	// Sortable Content Boxes Config

	if($.fn.sortable){
		$( ".main_container" ).sortable({
			handle:'.grabber',  // the element which is used to 'grab' the item
			items:'div.box', // the item to be sorted when grabbed!
			opacity:0.8,
			revert:true,
			tolerance:'pointer',
			helper:'original',
			forceHelperSize:true,
			placeholder: 'dashed_placeholder',
			forcePlaceholderSize:true,
			cursorAt: { top: 16, right: 16 }
		});
	}


	// Sortable Accordion Items Config

		$( ".content_accordion" ).not(".no_rearrange").sortable({
			handle:'a.handle',
			axis: 'y', // the items can only be sorted along the y axis
			revert:true,
			tolerance:'pointer',
			forcePlaceholderSize:true,
			cursorAt: { top: 16, right: 16 }
		});


	// static tables alternating rows

		$('table.static tr:even').addClass("even");


	// static table input

		$("table.static input[type=text]").addClass("text");


	// Content Boxes without a titlebar

		$('.box').each(function(){
			if (! $(this).children().is('.box_head, .tab_header, .tab_sider')){

				$(this).addClass('no_titlebar');

			}
		});



	// Button Classes

		$("input[type=button]").addClass("button");

		$('button, .button').each(function(){
			if (! $(this).children().is('span')){
				$(this).addClass('icon_only');
			}
			if (! $(this).children().is('img, .ui-icon')){
				$(this).addClass('text_only');
			}
			if ($(this).children().is('img')){
				$(this).addClass('img_icon');
			}
			if ($(this).children().is('.ui-icon')){
				$(this).addClass('div_icon');
			}
			if ($(this).children().is('span')){
				$(this).addClass('has_text');
			}
		});

		$('.indented_button_bar > .columns').each(function(){
			$(this).parent().addClass('has_columns');
		});

		$("button, .button").on('mousedown',function(){
			$(this).addClass("button_down");
		}).on('mouseup',function(){
			$(this).removeClass("button_down");
		}).on('mouseleave',function(){
			$(this).removeClass("button_down");
		});

		// Isotope

		if($.fn.isotope){
			$(".isotope_holder ul").isotope({
				animationEngine:"best-available",
				animationEngine:"jquery",
				sortBy:"sort_1",
				filter: "*",
				getSortData : {
				    sort_1 : function ( $elem ) {
				      return $elem.find('.sort_1').text();
				    },
				    sort_2 : function ( $elem ) {
				      return $elem.find('.sort_2').text();
				    },
				    sort_3 : function ( $elem ) {
				      return $elem.find('.sort_3').text();
				    },
				    sort_4 : function ( $elem ) {
				      return $elem.find('.sort_4').text();
				    }
				    // add more if you need more sort types
				}
			});

			$(".isotope_filter").on('click',function(){
				var x = $(this).attr("data-isotope-filter");
					$(".isotope_holder ul").isotope({filter: x});

				return false;
			});

			$(".isotope_sort").on('click',function(){
				var y = $(this).attr("data-isotope-sort");

				$(".isotope_holder ul").isotope({sortBy: y});

				return false;
			});

			$(".isotope_filter_complex").on("click", function(){
				$(".isotope_filter_complex").removeClass("complex_current");
				$(".isotope_filter_complex:checked").addClass("complex_current");

				var checked = ""

				$(".complex_current").each(function(){
					checked = checked+""+$(this).attr("data-isotope-filter");
				});
				console.log(checked);
				$(".isotope_holder ul").isotope({filter: checked});

				if(checked == "**"){
					$(".isotope_holder ul").isotope({filter: "*"});
				}

			});
		}


	columnHeight();
  	centerContent();
	refreshIsotope();

	$(window).resize(function() {
		columnHeight();
		centerContent();
	});
}

function adminicaInit(){

	$("#nav_top, .indent, .flat_area").animate({opacity: 1	});

	$("#login_box > div > span").hide().delay(400).fadeIn();

	$(".box").animate({
		opacity: 1
		}, function(){
			$(".block").animate({
			opacity: 1
		});
	});


	// fade in once page is fully loaded
	hideLoadingOverlay();
}

function refreshIsotope(){
	$(".isotope_holder ul").isotope('reLayout');
}

function hideLoadingOverlay(){
	$("#loading_overlay .loading_message").delay(100).fadeOut(function(){});
	$("#loading_overlay").delay(200).fadeOut();
}

function showLoadingOverlay(){
	$("#loading_overlay .loading_message").show();
	$("#loading_overlay").show();
}

function columnHeight(){
	$(".even fieldset.label_side, .even > div, .even fieldset").css('height','auto');

	$(".label_side > div, .columns").addClass("clearfix");

	$(".columns.even").each(function() {
		x = 0
		$(this).find("fieldset").children().each(function(){
			y = $(this).outerHeight();
			if(y > x){
				x = y
			}
		});
		$(this).find("fieldset.label_side").children().css('height',x-30);

		$(this).children(".col_50,.col_33,.col_66,.col_25,.col_75,.col_60,.col_40,.col_20").each(function(){
			y = $(this).outerHeight();
			if(y > x){
				x = y
			}
		});
		$(this).children().css('height',x);


		$(this).find("fieldset").not(".label_side").each(function(){
			y = $(this).outerHeight();
			if(y > x){
				x = y
			}
		});
		$(this).find("fieldset").css('height',x-1);

	});

	z = 0
	$(this).find("fieldset").children().each(function(){
		y = $(this).outerHeight();
		if(y > z){
			z = y
		}
	});
	$(this).find("fieldset.label_side").children().css('height',z-31);
}

function centerContent(){
	$(".isolate").each(function(){
		var theHeight =	$(window).height()-60;
		$(this).css("height", theHeight);
	});
}

function navCurrent(){

	var nav1 = $("#wrapper").data("adminica-nav-top");
	var nav2 = $("#wrapper").data("adminica-nav-inner");

	$('#nav_top > ul > li').eq(nav1 - 1).addClass("current").find("li").eq(nav2 - 1).addClass("current");

	$('#nav_top > ul > li.current > a > img').each(function(){
		var imgPath = $(this).attr('src').replace("/grey/", "/white/");
		$(this).attr('src', imgPath);
	});
}

function sideNavCurrent(){

	var snav1 = $("#wrapper").data("adminica-side-top");
	var snav2 = $("#wrapper").data("adminica-side-inner");

	$('ul#nav_side > li').eq(snav1 - 1).addClass("current").find("li").eq(snav2 - 1).addClass("current");
	$('ul#nav_side > li').addClass("icon_only").children("a").children("span:visible").parent().parent().removeClass("icon_only");
}

function stackNavCurrent(stnav1, stnav2){

	var stnav1 = $("#wrapper").data("adminica-stack-top");
	var stnav2 = $("#wrapper").data("adminica-stack-inner");

	if(stnav2 == null){
		$('#stackbar').addClass("list_view");
	}
	else{
		$('#stackbar').addClass("stack_view");
	}

	$('#stackbar > ul > li').eq(stnav1 - 1).addClass("current").find("li").eq(stnav2 - 1).addClass("current");
}