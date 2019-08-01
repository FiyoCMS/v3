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
	$('input[type="checkbox"]:not(.wrapped)').addClass('wrapped').wrap(function() {
		if(!$(this).closest("label").length ) 
		return "<label>"});
	$('input[type="radio"]:not(.wrapped)').addClass('wrapped').parent().wrap("<label>");
	$('input[type="number"]').attr("type","text").addClass('spinner').addClass('numeric');
	$('input[type="checkbox"],input[type="radio"]').after("<span class='input-check'>");	
	$("input.form-control[type=password]:not(.wrapped)").addClass('wrapped').parent().wrapInner("<div class='form-control-wrap'>");			


	$('input[type="file"]:not(.wrapped)').addClass('wrapped').wrap("<label class='input-append file input-group'>").wrap("<div class='form-file form-control'>").change(function () {	t = $(this); return t.next().val(basename(t.val()));
	}).after(function () {t = $(this);v = t.attr("value"); return "<input type='text' readonly value= '" + basename(v) + "' class='form-file-text'>";}).parent().before('<span class="add-on input-group-addon"><i class="icon-file-text-o"></i></span>').wrapInner("<div class='form-control-wrap'>");$(".form-file-text").click(function () {t = $(this);t.parent().trigger("click");});

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
	
	
	
	$('input[type=multidate]:not(.wrapped)').multiDatesPicker({
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
	
	$("input[required]:not(.required)").wrap("<span class='form-control-wrap'>").addClass('required').after('<div class="required-input"><i title="Required" data-placement="top">*</i></div>');

	$("input[type=text]:not(.required)").wrap("<span class='form-control-wrap'>");

	$("textarea[required]:not(.required)").addClass('required').after('<div class="required-input"><i title="Required" data-placement="top">*</i></div>').parent().wrapInner("<div class='form-control-wrap'>");
		
	$("select[required]:not(.wrapped)").addClass('wrapped').addClass('required').parent().append('<div class="required-input"><i title="Required" data-placement="top">*</i></div>').wrapInner("<div class='form-control-wrap'>");

	$('.required-input i').tooltip();
	
	$("#editor").attr("required","required");

	if ($.isFunction($.fn.validate)) {
		$("body").find(function(){
			return "form";
		}).validate({ ignore: ":hidden:not(select)" });		
	}
	
	$("form").validate({ ignore: ":hidden:not(select)",});
 
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
	
	$("*").scroll(function() {$(".bootstrap-datetimepicker-widget").hide()});

	$("#weeklyDatePicker").datetimepicker({
		format: 'MM-DD-YYYY'
	});
	
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

	$("input[type='checkbox'][target]").on('change', function () {	
		checkedParent($(this));
	});	
	

	$("input[type='checkbox'][target]").each(function () {		
		checkedParent($(this));
	});	

	$("input[type='checkbox']:not([target])").change(function () {	
		checkedChild($(this));
	});		

	$("input[type='checkbox']:not([target])").each(function () {	
		checkedChild($(this));
	});		

	loadSpinner();
	loadChoosen();
	noticeabs();
}

function checkedParent(target) {
	c = target.is(':checked');
	t = target.attr("target");
	$("input[name='"+ t +"']").prop('checked', c).attr('checked','checked');
	if(!c)
	target.removeClass("checkbox-notmax");
}

function checkedChild(target) {
	c = target.is(':checked');
	t = target.attr("name");

	ok = no = jml = 0;
	$("input[type='checkbox'][name='"+ t +"'").each(function (){
		if($(this).is(':checked')) ok++;
		jml++;
	});
	
	if(c)
	$("input[type='checkbox'][target='"+ t +"'").prop('checked', true);

	if(ok > 0 && ok != jml) {
		if($("input[type='checkbox'][target='"+ t +"'").is(':checked'))
		$("input[type='checkbox'][target='"+ t +"'").addClass("checkbox-notmax");
	} else if(ok > 0 && ok == jml ) {
		$("input[type='checkbox'][target='"+ t +"'").prop('checked', true);
		$("input[type='checkbox'][target='"+ t +"'").removeClass("checkbox-notmax");
	}
	else {			
		$("input[type='checkbox'][target='"+ t +"'").removeClass("checkbox-notmax");
		$("input[type='checkbox'][target='"+ t +"'").prop('checked', false);
	} 
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
		$("select").chosen({disable_search_threshold: 10});
		$("#article .parameter select").change(function(event) {
			var ini = $(this).val();
			$(this).removeClass("s-1 s-0 s-2");
			$(this).addClass("s-"+ini);
			
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
	}).change(function(){
		$(this).next(".error").hide();
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
				if(i == 1)
				$('input[type="checkbox"],input[type="radio"]').wrap("<label>");
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
}

function notice(data, text) {
	
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
