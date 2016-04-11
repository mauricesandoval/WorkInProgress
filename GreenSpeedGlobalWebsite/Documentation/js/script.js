(function(a){jQuery.ts_mobile=/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);
jQuery(document).ready(function($){
	var on_touch = ( $.ts_mobile )? true: false;
	var current_hash = '';
	
	/* Location hash */
	function set_location_hash( hash ){
		if( hash && hash != '#' ){
			if( history.pushState && location.protocol != 'file:' ){
				history.pushState(null, null, '#' + hash);
			}
			else{
				location.hash = hash;
			}
		}
	}
	
	function get_location_hash(){
		if( location.hash ){
			return location.hash.replace('#', '');
		}
		return '';
	}
	
	function remove_location_hash(){
		if( history.pushState && location.protocol != 'file:' ){
			history.pushState(null, null, window.location.pathname);
		}
		else{
			location.hash = '';
		}
	}
	
	function register_lazyload(){
		if( typeof $.fn.unveil == 'function' ){
			$('section img:not(.loaded)').addClass('not-loaded');
			$('section img').unveil(30000, function(){
				$(this).load(function(){
					$(this).removeClass('not-loaded').addClass('loaded');
					scroll_handle();
				});
			});
		}
	}
	
	current_hash = get_location_hash();
	
	/* Hide Loading */
	$(window).bind('load', function(){
		if( current_hash ){
			var first_load = true;
			var img_selector = $('section img[data-src]');
			var num_img = 0;
			var num_loaded_img = 0;
			
			var scroll_top = $(window).scrollTop();
			
			img_selector.bind('load', function(){
				$(this).addClass('loaded');
				num_loaded_img++;
				
				if( num_loaded_img >= num_img && first_load ){
					if( $('main nav a[href=#' + current_hash + ']').length > 0 ){
						$('main nav a[href=#' + current_hash + ']').trigger('click');
					}
					else{
						if( $('a.internal-link[href=#' + current_hash + ']').length > 0 ){
							$('a.internal-link[href=#' + current_hash + ']').trigger('click');
						}
					}
					setTimeout(function(){
						$(window).trigger('scroll');
						$('.loading-wrapper').fadeOut();
					}, 1300);

					register_lazyload();
					
					first_load = false;
				}
			});
			
			img_selector.each(function(){
				var data_src = $(this).data('src');
				var offset_top = $(this).offset().top;
				if( data_src && offset_top <= scroll_top ){
					num_img++;
					$(this).attr('src', data_src);
				}
			});
			
			if( num_img == 0 ){
				$(window).trigger('scroll');
				$('.loading-wrapper').fadeOut();
				register_lazyload();
				first_load = false;
			}
			
		}
		else{
			register_lazyload();
			$(window).trigger('scroll');
			$('.loading-wrapper').fadeOut();
		}
	});
	
	/* Calc top header height */
	function calc_top_header_height(){
		var top_header = $('body > header');
		top_header.height( $(window).height() );
	}
	calc_top_header_height();
	
	/* Calc menu height */
	function calc_menu_height(){
		var menu_obj = $('main nav');
		menu_obj.height( $(window).height() );
	}
	calc_menu_height();
	
	$(window).bind('resize', function(){
		calc_menu_height();
		calc_top_header_height();
		if( !on_touch ){
			reset_mobile_menu();
		}
	});
	
	/* Section detect */
	var all_sections = [];
	function parse_section(){
		var sections = $('main > section');
		for( var i = 0; i < sections.length; i++ ){
			all_sections.push(sections[i]);
		}
	}
	parse_section();
	
	function get_current_section_id(){
		var scroll_top, section_top, section_height;
		for( var i = 0; i < all_sections.length; i++ ){
			scroll_top = $(window).scrollTop();
			section_top = $('#' + all_sections[i].id ).offset().top;
			section_height = $('#' + all_sections[i].id ).height();
			if( scroll_top >= section_top && scroll_top <= section_top + section_height ){
				return all_sections[i].id;
			}
		}
		return '';
	}
	
	function scroll_handle(){
		if( scrolling_by_click ){
			return;
		}
		var current_section_id = get_current_section_id();
		var nav = $('main > nav');
		if( current_section_id ){
			var current_element = nav.find('a[href="#' + current_section_id + '"]');
			if( current_element.length > 0 ){
				var is_parent = current_element.siblings('.sub-menu').length > 0;
				var top_li = current_element.parents('.sub-menu').parent('li');
				var parent_li = current_element.parent('li');
				if( !parent_li.hasClass('current') ){
					if( is_parent ){
						if( !parent_li.hasClass('parent-current') ){
							nav.find('.sub-menu').slideUp();
							parent_li.find('.sub-menu').slideDown();
						}
						nav.find('li').removeClass('current parent-current');
						parent_li.addClass('current parent-current');
					}
					else{
						if( !top_li.hasClass('parent-current') ){
							nav.find('.sub-menu').slideUp();
							top_li.find('.sub-menu').slideDown();
						}
						nav.find('li').removeClass('current parent-current');
						parent_li.addClass('current');
						top_li.addClass('parent-current');
					}
					
					/* Menu scroll */
					var nav_height = nav.outerHeight();
					var item_top = current_element.position().top;
					var item_height = current_element.outerHeight();
					if( item_top + item_height * 2 >= nav_height || item_top < item_height ){
						nav.animate({
							scrollTop: item_top
						}, 1000);
					}
					/* Set location hash */
					set_location_hash( current_section_id );
					
				}
			}
		}
		else{
			//remove_location_hash();
		}
	}
	
	var scrolling_by_click = false;
	$(window).bind('scroll', function(){
		scroll_handle();
		
		if( $(this).scrollTop() > $('body > header').height() ){
			$('main > nav').addClass('nav-fixed');
			$('.menu-icon-toggle').addClass('icon-fixed');
		}
		else{
			$('main > nav').removeClass('nav-fixed');
			$('.menu-icon-toggle').removeClass('icon-fixed');
		}
		
		/* Show Footer */
		var scroll_top = $(this).scrollTop();
		var footer_top = $('footer').offset().top;
		var window_height = $(window).height();
		var offset = scroll_top + window_height - footer_top;
		if( offset > 0 ){
			$('main > nav').css('margin-top', -offset);
		}
		else{
			$('main > nav').css('margin-top', 0);
		}
	});
	
	/* Menu on mobile */
	$('.menu-icon-toggle').bind('click', function(){
		var nav = $('main > nav');
		var nav_width = nav.width();
		var transform = nav.css('transform');
		var matrix = transform.replace(/[^0-9\-.,]/g, '').split(',');
		var translateX = matrix[4];
		var main_padding_left = 0;
		var icon_margin_left = 0;
		if( translateX < 0 ){
			translateX = 0;
			main_padding_left = nav_width;
			icon_margin_left = nav_width;
			$('.menu-icon-toggle').removeClass('open').addClass('close');
		}
		else{
			translateX = '-100%';
			main_padding_left = 0;
			icon_margin_left = 0;
			$('.menu-icon-toggle').removeClass('close').addClass('open');
		}
		
		nav.get(0).style.transform = 'translateX(' + translateX + ')';
		$('main').css('padding-left', main_padding_left);
		$('.menu-icon-toggle').css('margin-left', icon_margin_left);
	});
	
	function reset_mobile_menu(){
		var nav = $('main > nav');
		var nav_width = nav.width();
		nav.get(0).style.transform = '';
		$('main').css('padding-left', '');
		$('.menu-icon-toggle').css('margin-left', '');
		$('.menu-icon-toggle').removeClass('close').addClass('open');
	}
	
	/* Scroll Button */
	$(window).load(function(){
		$('body > header > .scroll-button').bind('click', function(){
			$('body > main nav > ul > li:not(.menu-logo):first > a').trigger('click');
		});
	});
	
	/* Smooth Scroll */
	$('main nav a, a.internal-link').bind('click', function(){
		scrolling_by_click = true;
		$.smoothScroll({
			scrollTarget: $(this).attr('href')
			,speed: 1000
			,offset: 0
			,afterScroll: function(){
				scrolling_by_click = false;
				scroll_handle();
			}
		});
		return false;
	});
	
	/* Code */
	$('.code').attr('readonly', true);
});