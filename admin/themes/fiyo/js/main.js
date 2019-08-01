function checkFirstVisit() {
	$(window).bind('onbeforeunload',function(){
		return false;
		window.location.replace(document.URL);

	});  
	$(document).bind('keydown keyup', function(e) {
		if(e.which === 116) {
		   console.log('blocked');
			e.preventDefault();	
		   window.location.replace(document.URL);
		}
		if(e.which === 82 && e.ctrlKey) {
		   console.log('blocked');
			e.preventDefault();	
		   window.location.replace(document.URL);
		}
	});
}

function bname(path) {
	if(path)
		return path.split('/').reverse()[0];
	else	
		return "";
}

function basename(path) {
	if(path) {
		path = bname(path);
		return path.split('\\').reverse()[0];
	} 
	else 
	return "Choose file...";
}

function stringify(s) {		
	return s.replace(/"/g, "'");
}

function getEditor(editor) {
	try{
		return stringify(CKEDITOR.instances['editor'].getData());
	} catch (e) {

	}
}
$(function() {
	//checkFirstVisit();
    $('a[href=#]').on('click', function(e){
      e.preventDefault();
    });    
	
    $('.minimize-box').on('click', function(e) {
        e.preventDefault();
        var $icon = $(this).children('i');
        if ($icon.hasClass('icon-chevron-down')) {
            $icon.removeClass('icon-chevron-down').addClass('icon-chevron-up');
        } else if ($icon.hasClass('icon-chevron-up')) {
            $icon.removeClass('icon-chevron-up').addClass('icon-chevron-down');
        }
    });
	
    $('.close-box').click(function() {
        $(this).closest('.box').hide('slow');
    });

    $('.changeSidebarPos').on('click', function(e) {
        $('body').toggleClass('hide-sidebar');
        $('body').removeClass('user-sidebar');
		$('.changeSidebarPos').toggleClass('removeSidebar');
		$.ajax({
			type: 'POST',
			url: "themes/fiyo/module/view.php",
			data: "view=true",
			success: function(data){
			}
		});	
    });
	
    $('.userSideBar').on('click', function(e) {
        $('body').toggleClass('user-sidebar');
        $('body').removeClass('hide-sidebar');
    });
    
    $('.removeSidebar').on('click', function(e) {
        $('body').removeClass('hide-sidebar');
        $('body').removeClass('user-sidebar');
    });
	
    $('li.accordion-group > a').on('click',function(e){
        $(this).children('span').children('i').toggleClass('icon-angle-down');
    });		
	
	loader();
	$('.spinner').change(function () {
		$(this).next('label').hide() ;
	});
	
	
});
function logs(data) {
	return console.log(data);
}
function loader() {
	v = $(".input-append.time, .input-append.datetime,.input-append.date").length;
	
	$(".bootstrap-datetimepicker-widget").slice(1, 4).remove();
	

	$(".cb-enable").click(function(){
		if($(this).parents('.switch-group').length == 0 ) {
			var parent = $(this).parents('.switch');
			$('.cb-disable',parent).removeClass('selected');
			$(this).addClass('selected');
		}		
	});

	$(".cb-disable").click(function(){
		if($(this).parents('.switch-group').length == 0 ) {
			var parent = $(this).parents('.switch');
			$('.cb-enable',parent).removeClass('selected');
			$(this).addClass('selected');
		}
	});	
	
	$('.selectbox li').click(function(){
		$(this).toggleClass('active');
		var checkBoxes = $("input[type='checkbox']", this);
		checkBoxes.prop("checked", !checkBoxes.prop("checked"));
	});
	$('.selections-all').click(function(){
		var t = $('.selectbox li').addClass('active');
		var checkBoxes = $("input[type='checkbox']", t);
		checkBoxes.prop("checked",true);
	});
	$('.selections-reset').click(function(){
		var t = $('.selectbox li').removeClass('active');
		var checkBoxes = $("input[type='checkbox']", t);
		checkBoxes.prop("checked",false);
	});
	$("input, select, textarea").addClass('form-control');	
	$('input[type="checkbox"]:not(.wrapped)').addClass('wrapped').wrap("<label>");
	$('input[type="radio"]:not(.wrapped)').addClass('wrapped').parent().wrap("<label>");
	$('input[type="number"]').attr("type","text").addClass('spinner').addClass('numeric');
	$('input[type="checkbox"],input[type="radio"]').after("<span class='input-check'>");	
	$("input.form-control[type=password]:not(.wrapped)").addClass('wrapped').parent().wrapInner("<div>");
	
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {	
		$(".btn").find("[class^='icon-'], [class*='icon-']").parent().addClass("btn-icon-only");
		$('body').on( 'change keyup keydown paste cut', 'textarea', function (){
			$(this).height(0).height(this.scrollHeight - 10);
		}).find( 'textarea' ).change();

	}else {
		$('input[type="file"]:not(.wrapped):not([disabled])').addClass('wrapped').wrap("<label class='input-append file input-group'>").wrap("<div class='form-file form-control'>").change(function () {	t = $(this); return t.next().val(basename(t.val()));
		}).after(function () {t = $(this);v = t.attr("value"); return "<input type='text' readonly value= '" + basename(v) + "' class='form-file-text'>";}).parent().before('<span class="add-on input-group-addon"><i class="icon-file-text-o"></i></span>').wrapInner("<div>");$(".form-file-text").click(function () {t = $(this);t.parent().trigger("click");});

		$('input[type="file"]').change(function () {
			v = $(this);
			v.parent().find(".form-file-text").val(v.val());
		});
	
		$('input[type=date]:not(.wrapped):not([disabled])').addClass('wrapped').attr('type','text').attr('autocomplete','OFF').after('<span class="add-on input-group-addon"><i class="icon-calendar"></i></span>').parent().wrapInner("<div class='input-append date input-group'>").datetimepicker({
			format: "yyyy-MM-dd",
			pickTime: true
		}).find(".picker-switch").remove();	
	
		$('input[type=date]:not(.wrapped):not([disabled])').addClass('wrapped').attr('type','text').attr('autocomplete','OFF').after('<span class="add-on input-group-addon"><i class="icon-calendar"></i></span>').parent().wrapInner("<div class='input-append date input-group'>").datetimepicker({
			format: "yyyy-MM-dd",
			pickTime: true
		}).find(".picker-switch").remove();	
	
	  
		$('input[type=time]:not(.wrapped):not([disabled])').addClass('wrapped').attr('type','text').attr('autocomplete','OFF').after('<span class="add-on input-group-addon"><i class="icon-time"></i></span>').parent().wrapInner("<div class='input-append time input-group'>")
		.datetimepicker({
			format: 'hh:mm',
			pickTime: true,
			pickDate: false,		
			pickSeconds: false,
		});
		
		$('input[type=datetime]:not(.wrapped):not([disabled])').addClass('wrapped').attr('type','text').attr('autocomplete','OFF').after('<span class="add-on input-group-addon"><i class="icon-calendar"></i></span>').parent().wrapInner("<div class='input-append datetime input-group'>")
		.datetimepicker({
			format: 'yyyy-MM-dd hh:mm:ss',
			pickTime: true,
			pickDate: true,		
		});
		
		
		$("*").scroll(function() {$(".bootstrap-datetimepicker-widget").hide()});
		
		$("#weeklyDatePicker").datetimepicker({
			format: 'MM-DD-YYYY'
		});
		
		$('input[type=multidate]:not(.wrapped):not([disabled])').multiDatesPicker({
			dateFormat: "yy-mm-dd",	
		}).change(function () {
			var dates = $(this).multiDatesPicker('value');
			if($(this).val() == '')		{
				logs($(this).val());
				$(this).val('');
			}
			else{$(this).val(dates);}
			v = dates.split(",");
		}).addClass('wrapped').attr('type','text').attr('autocomplete','OFF').after('<span class="add-on input-group-addon"><i class="icon-calendar"></i></span>').parent().wrapInner("<div class='input-append multidate input-group'>").find('div span').click(function () {$(this).parent().find('input').focus()});
		
	
		$('.input-group.date i,.input-group.datetime i').click(function () {
			if($(this).parent().parent().parent().hasClass("date") || $(this).parent().parent().hasClass("date"))	
				$('.bootstrap-datetimepicker-widget').find(".picker-switch").hide();
			else
				$('.bootstrap-datetimepicker-widget').find(".picker-switch").show();
			
			t = $(this).offset().top;
			hl = $(document).height();
			
			l = $(this).offset().left;
			wl = $(document).width();
			
			h =  $('.bootstrap-datetimepicker-widget').height();


			$('.bootstrap-datetimepicker-widget').css("margin-top" , "");
			if((hl - t) < 320) {			
				$('.bootstrap-datetimepicker-widget').css({ "margin-top" : "-"+ parseInt(h+ 10) +"px"}).addClass("drop-top");
			}
			if((wl - l) < 320) {	
				if((hl - t) < 320) {			
					$('.bootstrap-datetimepicker-widget').css({ "margin-top" : "-"+ parseInt(h+ 45) +"px"}).addClass("drop-top");
				} else {
					$('.bootstrap-datetimepicker-widget').css({ "margin-top" : "2px"}).addClass("drop-top");
				}		
			}
		});
	}

	$("input[required]:not(.required)").wrap("<span class='form-control-wrap'>").addClass('required').after('<div class="required-input"><i title="Required" data-placement="top">*</i></div>');

	$("input[type=text]:not(.required)").wrap("<span class='form-control-wrap'>");

	$("textarea[required]:not(.required)").addClass('required').after('<div class="required-input"><i title="Required" data-placement="top">*</i></div>').parent().wrapInner("<div>");
		
	$("select[required]:not(.wrapped)").addClass('wrapped').addClass('required').parent().append('<div class="required-input"><i title="Required" data-placement="top">*</i></div>').wrapInner("<div>");

	$('.required-input i').tooltip();
	
	$("#editor").attr("required","required");

	if ($.isFunction($.fn.validate)) {
		$("body").find("#content form").validate({ ignore: ":hidden:not(select)" });		
	}
	
	$("form.validate").validate({ ignore: ":hidden:not(select)",});
 
    $('[data-toggle=popover]').popover();
    $('[data-popover=tooltip]').popover();
    $('[data-toggle=tooltip]').tooltip();
    $('[data-tooltip=tooltip]').tooltip();
    $('.tips').tooltip();
	$('.alphanumeric').alphanumeric();
	$('.alphadot').alphanumeric({allow:"."});
	$('.nocaps').alpha({nocaps:true});
	$('.numeric').numeric();
	$('.numericdot').numeric({allow:"."});
	$('.selainchar').alphanumeric({ichars:'.1a'});
	$('.web').alphanumeric({allow:':/.-_'});
	$('.email').alphanumeric({allow:':.-_@'});
	$('form').submit(function() {
		$('.error').parents('.panel-collapse').height('auto').removeClass('collapsed').addClass('in').before().find('a').removeClass('collapsed');
	});
	$('.accordion-toggle').click(function () {
		$(this).parent().next().css("display", "")
	});
	$('.accordion-toggle collapsed').bind(function () {});
	

	 //Get the value of Start and End of Week
	$('#weeklyDatePicker').on('dp.change', function (e) {
		var value = $("#weeklyDatePicker").val();
		var firstDate = moment(value, "MM-DD-YYYY").day(0).format("MM-DD-YYYY");
		var lastDate =  moment(value, "MM-DD-YYYY").day(6).format("MM-DD-YYYY");
		$("#weeklyDatePicker").val(firstDate + " - " + lastDate);
	});
	

	$(".table-scroll").scroll(function() {
		v = $(this).scrollLeft();
		if(v > 1) $(this).addClass('moving_scroll');
		else $(this).removeClass('moving_scroll');
	});

	
	$(".inner").scroll(function() {
		v = $(this).scrollTop();
		if(v > 1) $(this).addClass('moving_scroll');
		else $(this).removeClass('moving_scroll');
	});
	
	

	loadSpinner();
	loadChoosen();
	noticeabs();
}

function selectCheck() {
	$('input[type="checkbox"]').click(function(){	
		var $checked = $(this).is(':checked');
		var $target = $(this).attr('target');
		var $subs = $(this).attr('sub-target');
		if($subs) {
			$target = $(this).attr('value');
			var $checkbox = $('input[data-parent="'+$target+'"]');
		} else {
			var $checkbox = $('input[name="'+$target+'"]');
		}
		$('input[type="checkbox"]').next().removeClass('input-error');
		$('input[type="radio"]').next().removeClass('input-error');		
		if($checked) {			
			$checkbox.prop('checked', 1);					
			$($checkbox).parents('.data tr').addClass('active');					
		}
		else {
			$checkbox.prop('checked', 0);	
			$($checkbox).parents('.data tr').removeClass('active');				
		}
	});
	
	$('[target-radio], label[target], radio-name[target]').click(function(e){			
		var $target = $(this).attr('target-radio');
		var $type = $(this).attr('target-type');
		var $checkbox = $('input[data-name="'+$target+'"]');
		var $checked = $($checkbox).is(':checked');
		if($type == 'multiple')
		var $checkbox = $('input[name="'+$target+'"]');
		$('input[type="checkbox"]').next().removeClass('input-error');
		$('input[type="radio"]').next().removeClass('input-error');
		if($(e.target).is('.switch *, a[href]')) {
		} else {
			$('tr').removeClass('active');	
			if($checked) {
				$checkbox.prop('checked', 0);					
			}
			else {
				$checkbox.prop('checked', 1);	
				if($('tr')) $(this).addClass('active');
			}
		}
	});	
	
}
function loadScrollbar() {
	
}
function loadChoosen() {
	if ($.isFunction($.fn.chosen) ) {
		$("select.deselect").chosen({disable_search_threshold: 10,allow_single_deselect: true});
		$("select").chosen({disable_search_threshold: 10}).change(function(event) {
			var ini = $(this).val();
			$(this).removeClass(function (index, classNames) {
				var current_classes = classNames.split(" "), // change the list into an array
				classes_to_remove = []; // array of classes which are to be removed		
				$.each(current_classes, function (index, class_name) {
				// if the classname begins with bg add it to the classes_to_remove array
					if (/s-.*/.test(class_name)) {
						classes_to_remove.push(class_name);
					}
				});
				// turn the array back into a string
				return classes_to_remove.join(" ");
			}).addClass(function () {
				$(this).removeClass($(this).attr("delete-class"));
				t = $('option:selected', this).attr('class');
				$(this).attr("delete-class",t);
				console.log(t);
				if(t)
				return t;
			});
			
		}).addClass(function () {
			$(this).removeClass($(this).attr("delete-class"));
			t = $('option:selected', this).attr('class');
			$(this).attr("delete-class",t);
			if(t)
			return t;
		});
	}

	$("select").ready(function(){	
		var cl = $(this).val();
		$(this).next('.chosen-container').attr('rel','selected-'+cl);
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			title = $(".app_title").html();
			$(".navbar-logo").html(title);
			$(".app_title").html("");
			
		} else {
			
		}
	});

	
	$(".chosen-container").before(function () {		
		jumlah = $(this).parent().find("select option").length;
		if(jumlah > 12 ) jumlah = 12;
		posisi = $(this).offset().top;


		butuh = 25 * jumlah;
		tinggiDokumen 	= $(document).height();
		tinggiMain 		= $("#mainApps").height();
		tinggiKotak 	= $("#mainApps #app_header").next().height();

		tinggi = Math.max(tinggiDokumen, tinggiKotak, tinggiMain, 600);
		
		if(parseInt(tinggi - posisi)-80 >= butuh) {	
		} else {	
			$(this).prev().addClass("drop-top");
		}
		
	});
}
function loadTable(url,display) {
	if(url) {		
        var tr = true;
        var file = url;
	} else  {
		var tr = false;
        var file = null;
	}
	$('table.data').show();
	var i = 1;
	
	if ($.isFunction($.fn.dataTable)) {
		oTable = $('table.data').dataTable({
			"iDisplayLength": display,
			"bProcessing": tr,
			"bServerSide": tr,
			"sAjaxSource": file,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"fnDrawCallback": function( oSettings ) {
				selectCheck();
				$('[data-toggle=tooltip]').tooltip();
				$('[data-tooltip=tooltip]').tooltip();
				$('.tips').tooltip();				
				loadChoosen();
				$("tr").click(function(e){
					var i =$("td:first-child",this).find("input[type='checkbox']");					
					var c = i.is(':checked');
					if($(e.target).is('.switch *, a[href]')) {					   
					} else if(i.length) {
						if(c) {
							i.prop('checked', 0);		
							$(this).removeClass('active');			
						}
						else {
							i.prop('checked', 1);
							$(this).addClass('active');
							$('.input-error').removeClass('input-error');
							
						}
					}
				});		
				$('input[type="checkbox"],input[type="radio"]').wrap(function() {
					if($(this).closest("label").length == 0)
					return "<label>";
				});
				$('input[type="checkbox"],input[type="radio"]').after("<span class='input-check'>");
				$('table.data tbody a[href]').on('click', function(e){
				   if ($(this).attr('target') !== '_blank'){
					e.preventDefault();	
					loadUrl(this);
				   }				
				});
				i = 0;
			}
		});
		$('table.data th input[type="checkbox"]').parents('th').unbind('click.DT');
	}
}
function loadSpinner() {
	if ($.isFunction($.fn.spinner)) {
		$('.spinner').spinner();
		$('.spinner min-nol').spinner({ min: 0});
		$('#spinnerfast').spinner({ min: -1000, max: 1000, increment: 'fast' });
		$('#spinnerhide').spinner({ min: 0, max: 100, showOn: 'both' });
		$('#spinnernull').spinner({ min: -100, max: 100, allowNull: true });
		$('#spinnerdisable').spinner({ min: -100, max: 100 });
		$('#spinnermaxlen').spinner();
		$('#spinner5').spinner();	
	}
}
function noticeabs(data, text) {
	$("#alert").html("");
	if(text != null) {
		var a = $("<div class='alert "+data+" alert-"+data+"'>"+text+"</div>");	
		if(data) {
			$(".inner .alert").remove();
		} else {
			a = $('.alert');
		}
		a.hide().appendTo("#alert_top");	
		a.fadeIn('slow');
		var a = a.css({margin:'0 auto'});	
		a.on('click', function(e) {
			$(this).fadeOut();		
		}); 
		
		setTimeout(function(){
			a.fadeOut('slow');
		}, 10000);
		setTimeout(function(){				
			a.remove();	
		}, 11000);	
	}
	 else {
		var a = $(data);
		if(data) {
			$(".inner .alert").remove();
		} else {
			a = $('.alert').addClass('alert-big');
		}
		a.hide().appendTo("#alert_top");	
		a.fadeIn('slow');
		var a = a.css({margin:'0 auto'});	
		a.on('click', function(e) {
			$(this).fadeOut();		
		}); 
		
		setTimeout(function(){
			a.fadeOut('slow');
		}, 10000);
		setTimeout(function(){				
			a.remove();	
		}, 11000);	

	}
}

function notice(data, text) {
	$("#alert").html("");
	if(text != null) {
		var a = $("<div class='alert "+data+" alert-"+data+"'>"+text+"</div>").hide().appendTo("#alert").fadeIn().css({display:'block'});	
		$("#alert script").removeAttr('style');
		setTimeout(function(){
			a.fadeOut('slow');
		}, 10000);
		setTimeout(function(){				
			a.remove();	
		}, 11000);	
		a.on('click', function(e) {
			$(this).fadeOut();
		});

	} 
	else if(typeof data === 'object') {
		$("#alert").html("");
		var a = $("<div class='alert "+data.status+" alert-"+data.status+"'>"+data.text+"</div>").hide().appendTo("#alert").fadeIn().css({display:'block'});	
		$("#alert script").removeAttr('style');
		setTimeout(function(){
			a.fadeOut('slow');
		}, 10000);
		setTimeout(function(){				
			a.remove();	
		}, 11000);	
		a.on('click', function(e) {
			$(this).fadeOut();
		});
	}
	else {
		var a = $(data).hide().appendTo("#alert").fadeIn().css({display:'block'});	
		$("#alert script").removeAttr('style');
		setTimeout(function(){
			a.fadeOut('slow');
		}, 10000);
		setTimeout(function(){				
			a.remove();	
		}, 11000);	
		a.on('click', function(e) {
			$(this).fadeOut();
		});
	}
}


(function($) {    
    $.LoadingDot = function(el, options) {        
        var base = this;        
        base.$el = $(el);                
        base.$el.data("LoadingDot", base);        
        base.dotItUp = function($element, maxDots) {
            if ($element.text().length == maxDots) {
                $element.text("");
            } else {
                $element.append(".");
            }
        };
        
        base.stopInterval = function() {    
            clearInterval(base.theInterval);
        };
        
        base.init = function() {
        
            if ( typeof( speed ) === "undefined" || speed === null ) speed = 300;
            if ( typeof( maxDots ) === "undefined" || maxDots === null ) maxDots = 3;            
            base.speed = speed;
            base.maxDots = maxDots;                                    
            base.options = $.extend({},$.LoadingDot.defaultOptions, options);                        
            base.$el.html("<span>" + base.options.word + "<em></em></span>");            
            base.$dots = base.$el.find("em");
            base.$loadingText = base.$el.find("span");
            
            base.$el.css("position", "relative");
            base.$dots.css({"position": "absolute"});
                          
            base.theInterval = setInterval(base.dotItUp, base.options.speed, base.$dots, base.options.maxDots);
            
        };        
        base.init();    
    };
    
    $.LoadingDot.defaultOptions = {
        speed: 300,
        maxDots: 3,
        word: "Loading"
    };
    
    $.fn.LoadingDot = function(options) {        
        if (typeof(options) == "string") {
            var safeGuard = $(this).data('LoadingDot');
			if (safeGuard) {
				safeGuard.stopInterval();
			}
        } else { 
            return this.each(function(){
                (new $.LoadingDot(this, options));
            });
        }         
    };
    
})(jQuery);
