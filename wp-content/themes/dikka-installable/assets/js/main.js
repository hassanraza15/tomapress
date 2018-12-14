/**      
  
  Dikka Wordpress		   								 
  Author: UX-Qode									     

  - DIKKA MAIN JS


/***************************************************************
	SEARCH MOBILE DEVICE
***************************************************************/
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};


/***************************************************************
	GLOBAL ELANO FUNCTIONS
***************************************************************/
jQuery(document).ready(function(){	
	
	"use strict";
	
	/* IE fixes */
	if ((window.BrowserDetect.browser === "Mozilla" && window.BrowserDetect.version == 11) || window.BrowserDetect.browser === "Explorer" && window.BrowserDetect.version < 11){
		jQuery('.overlay-pattern').add(jQuery('.testimonials-slide-content .img-container img')).addClass('ie');
		jQuery('.cbp-item') .mouseenter().mouseleave();
		jQuery(window).resize();
		jQuery("body").addClass("ie10");
	}
	if (window.BrowserDetect.browser === "Explorer" && window.BrowserDetect.version < 10){ jQuery('.navbar').addClass('oldie'); }
	if (window.BrowserDetect.browser === "Explorer"){ jQuery('audio').addClass('ie'); }

	/* initialize the youtube player */
	if (jQuery(".player").length) { jQuery(".player").each(function(){ jQuery(this).mb_YTPlayer(); }); }

	
	jQuery( ".collapse-group .collapse-heading a" ).prepend( "<span class='toggle-icon'><i class='fa fa-angle-right'></i></span>" );
	jQuery('.grid .figcaption a.thumb-link, .socialdiv a, .carousel-item a').tooltip()
	
	/* LightBox for carroussel items */
	
	if (jQuery("a.open-video").length) { 
		jQuery("a.open-video").nivoLightbox()
	};

	jQuery("#blog-tabs").tytabs({
		tabinit:"1",
		fadespeed:"fast"
	});	
	jQuery('.tabs li').eq(0).click();
	
	/* FIT VIDS */
	jQuery(".video-wrapper").fitVids();
	
		
	/* TOP BAR */
	jQuery("a.down-button").click(function () {
	      jQuery(".slidedown").slideToggle("slow");
	});
	
	/* Fix double  */
	jQuery(".cbp-popup-lightbox").css('visibility','hidden');
	
	
	
	jQuery('a.down-button').bind('click', function () {
	  if (jQuery(this).hasClass('current')) {
		  jQuery(this).removeClass('current');
		  jQuery('a.down-button > i').removeClass('fa fa-angle-up');
		  jQuery('a.down-button > i').addClass('fa fa-angle-down');
		  jQuery(this).parent().parent().find('.slidedown').slideUp('slow');
		  
		  return false;
	  } else {
		  jQuery(this).addClass('current');
		  jQuery('a.down-button > i').removeClass('fa fa-angle-down');
		  jQuery('a.down-button > i').addClass('fa fa-angle-up');
		  jQuery(this).parent().parent().find('.slidedown').slideDown('slow');
		  
		  return false;
	  }
	});
	

	/* PARALLAX OVERLAY */
	jQuery('.parallax-overlay-pattern').each(function() {
	jQuery(this).css({'margin-top':'-'+jQuery(this).parent().css('padding-top'),'margin-bottom':'-'+jQuery(this).parent().css('padding-bottom'),'padding-top':jQuery(this).parent().css('padding-top'),'padding-bottom':jQuery(this).parent().css('padding-bottom')});
	});

	
	
	/***************************************************************
		SKILLS BARS
	***************************************************************/
	
	jQuery(window).scroll(function(){
		jQuery('.skillbar').each(function(){
			if (jQuery(this).hasClass('notinview')){
				jQuery(this).find('.pointerval .value').html('0%');
				if (isScrolledIntoView(jQuery(this).attr('id'))){
		    		jQuery(this).removeClass('notinview');
		     		jQuery(this).find('.skill-bar-percent').animate({
						width:jQuery(this).closest('.skillbar').attr('data-percent')
					},{
						duration : 2000, //the duration in ms of the bar animation
						easing: 'easeInOutExpo', //the easing effect of the animation
						step: function(now, fx){
							jQuery(this).siblings('.pointerval').css('left',parseFloat(now, 10)+'%').find('.value').text(parseInt(now, 10)+'%');
						}
					});       
		        }
			}
		});
	});
	 
	function sliding_horizontal_graph(id, speed){
	    jQuery("#" + id + " li span").each(function(i){                                  
	        var cur_li = jQuery("#" + id + " li").eq(i).find("span");
	        var w = cur_li.attr("title");
	        cur_li.animate({width: w + "%"}, speed);
	    })
	}
	function graph_init(id, speed){
	    jQuery(window).scroll(function(){
	    	if (jQuery('#'+id).hasClass('notinview')){	    	
		    	if (isScrolledIntoView(id)){
		    		jQuery('#'+id).removeClass('notinview');
		            sliding_horizontal_graph(id, speed);
		        }
	    	}
	    });
	    
	    if (isScrolledIntoView(id)){
	        sliding_horizontal_graph(id, speed);
	    }
	}
	
    
	/***************************************************************
		PRELOADER CALLING
	***************************************************************/
	
	if (typeof PreloaderParam != 'undefined'){
	window.addEventListener('DOMContentLoaded', function() {
        new QueryLoader2(document.querySelector("body"), {
            barColor: "#444",
            backgroundColor: "#fff",
            percentage: true,
            barHeight: 5,
            minimumTime: 200,
            fadeOutTime: 1000,
            onComplete: function(){
	        jQuery('body > #load').fadeOut(1000, function(){
		        jQuery(this).remove();
	        });
        }
        });
    });
	}
	

	/***************************************************************
		MENU FIX
	***************************************************************/
	jQuery( ".menu-item.has-submenu" ).each(function() {
		if(jQuery( this ).attr('href')!='' && jQuery( this ).attr('href')!="#") {
			jQuery( this ).after('<span class="sub-arrow-go"></span>');
			jQuery( this ).next().bind( "click", function() {
			  var url = jQuery( this ).prev().attr('href');
			  jQuery(location).attr('href',url);
			});
		}
	});

	/***************************************************************
		FLEXSLIDER
	***************************************************************/
	if (jQuery('#slider1.flexslider').length || jQuery('#slider2.flexslider').length){
		jQuery('#slider1.flexslider, #slider2.flexslider').flexslider({						
			animation: "fade",
			slideshow: true,
			slideshowSpeed: 3500,
			animationDuration: 1000,
			directionNav: true,
			controlNav: true,
			smootheHeight:true,
			after: function(slider) {
			  slider.removeClass('loading');
			}
			
		});
	}
	
	if (jQuery('#text-slider.flexslider').length){
		jQuery('#text-slider.flexslider').flexslider({						
			animation: "fade",
			direction: "vertical",
			slideshow: false,
			slideshowSpeed: 3500,
			animationDuration: 1000,
			directionNav: false,
			controlNav: true,
			smootheHeight:true,
			after: function(slider) {
			  slider.removeClass('loading');
			}
		});	
	}

	if ( window.BrowserDetect.browser === "Safari" ) {
		  jQuery('.flexslider').flexslider({						
			animation: "fade",
			slideshow: false,
			slideshowSpeed: 3500,
			animationDuration: 500,
			directionNav: true,
			controlNav: false,						
			useCSS: false
		  });
	 }
	
	/* SCROLL TOP BUTTON */
	jQuery("#back-top").hide();
	
	jQuery(function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 100) {
				jQuery('#back-top').fadeIn();
			} else {
				jQuery('#back-top').fadeOut();
			}
		});

		jQuery('#back-top a').click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 1000);
			return false;
		});
	});
	
});


/***************************************************************
	SELECT MENU ITEMS WITH WAYPOINTS
***************************************************************/


jQuery(function() {
	
	'use strict';
	
	var nav_container = jQuery(".navbar");
	var nav = jQuery(".navbar");
	var top_spacing = 0;
	var sections = jQuery("div.nav-one-page");
	var navigation_links = jQuery(".nav a");
	
	sections.waypoint({
		handler: function(event, direction) {
			var active_section;
			active_section = jQuery(this);
			var active_link = jQuery('.nav a[href="'+main.home_url+'/#' + active_section.attr("id") + '"]');
			/* window.location.hash = active_section.attr("id")+"/"; */
			navigation_links.removeClass("selected");
			active_link.addClass("selected");
		},
		offset: 80
	});
});

jQuery(window).load(function($){   
	
	'use strict';
	
	/***************************************************************
		MENU NAVIGATION WITH SCROLLTOP ANIMATION
	***************************************************************/
	if(main.template_active=="builder"){
		jQuery('a.nav-to[href*=#]:not([href=#])').each(function() {
			var $this = jQuery(this);
			var isMenu = ($this.parents('.navbar').length) ? true : false;
			if ($this.children('.sub-arrow').length){
				$this.click(function(e){
					e.preventDefault();
					var target = jQuery(this.hash);
				    target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
				    if (target.length) {
						if (!$this.children('.sub-arrow').is(':hover')){
							jQuery('html,body').animate({
					          scrollTop: target.offset().top - 50
					        }, {
						        duration: 1000,
						        easing: "easeOutQuad",
						        complete: function(){
							        if (jQuery('.navbar-toggle').is(':visible') && isMenu){
								        jQuery('.navbar-toggle').trigger('click');
							        } 
						        }
					        });
						}
					}
				});
			} else {
				$this.click(function(e){
					e.preventDefault();
					var target = jQuery(this.hash);
				    target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
				    if (target.length) {
						jQuery('html,body').animate({
						  scrollTop: target.offset().top - 50
						}, {
							duration: 1200,
							easing: "easeOutQuad",
							complete: function(){
								if (jQuery('.navbar-toggle').is(':visible') && isMenu){
									 jQuery('.navbar-toggle').trigger('click');
								}
							}
						});			    
				    }
				});
			}
	    });
	}
    	
	/* fire the youtubeplayer ready event  */
	if (jQuery(".player").length) { jQuery(document).trigger("YTAPIReady"); }
	
	/***************************************************************
		OWL CAROUSELS
	***************************************************************/
	if (jQuery("#logos-carousel").length){
		jQuery("#logos-carousel").owlCarousel({
    		
    		/* This need to be option */
    		nav : false,
    		pagination: false,
			items : 6,
			loop:true,
			autoplay:true,
			autoplayTimeout:3000,
		    autoplayHoverPause:true,
			stopOnHover : true,
			itemsCustom : false,
			responsiveClass:true,
		    responsive:{
		        0:{
		            items:2,
		        },
		        600:{
		            items:4,
		        },
		        1000:{
		            items:6,
		        }
		    }
		});	
	}
	

	/***************************************************************
		TWITTER CALLBACK FUNCTION
	***************************************************************/
	if (typeof MainParam != 'undefined'){
	if (jQuery('#twitter-feed').length) {
		jQuery('#twitter-feed').tweet({
			username: MainParam.twitter_username,
			join_text: 'auto',
			avatar_size: 0,
			count: MainParam.twitter_count
		});

		jQuery('#twitter-feed').find('ul').addClass('slides');
		jQuery('#twitter-feed').find('ul li').addClass('slide');
		jQuery('#twitter-feed').contents().wrapAll('<div class="flexslider">');
	}

	// Twitter feed
	if (jQuery('#twitter-widget').length) {
		jQuery('#twitter-widget').tweet({
			username: MainParam.twitter_username,
			join_text: 'auto',
			avatar_size: 0,
			count: MainParam.twitter_count
		});
	}

	var twitter_slideshow=jQuery('#twitter_data').data('slideshow');
	var twitter_slideshowSpeed=jQuery('#twitter_data').data('slideshowspeed');
    var	twitter_animationDuration=jQuery('#twitter_data').data('animationduration');
	var twitter_directionNav=jQuery('#twitter_data').data('direction');
	var twitter_controlNav=jQuery('#twitter_data').data('control');
	jQuery('.twitter-slider .flexslider').flexslider({						
		animation: "slide",
		slideshow: twitter_slideshow,
		slideshowSpeed: twitter_slideshowSpeed,
		smootheHeight:true,
		animationDuration: twitter_animationDuration,
		directionNav: twitter_directionNav,
		controlNav: twitter_controlNav,
		after: function(slider) {
			slider.removeClass('loading');
		}
	});
	}
});


/***************************************************************
		ANIMATED CONTENTS
***************************************************************/

wow = new WOW(
    {
      boxClass:     'animated',      // default
      animateClass: 'animateddone', // default
      offset:       100          // default
    }
  )
  wow.init();


/***************************************************************
	PARALLAX STUFF
***************************************************************/		
jQuery(window).bind('load', function() { 
	
	'use strict';
						  
	parallaxInit();	
	jQuery.waypoints("refresh");
	var t=setTimeout(function(){jQuery.waypoints("refresh");},3000);
	
	if ((window.BrowserDetect.browser === "Mozilla" && window.BrowserDetect.version == 11) || window.BrowserDetect.browser === "Explorer" && window.BrowserDetect.version == 10){
		jQuery('.team img').each(function(){ jQuery(this).hoverizr(); });
		jQuery('.team canvas').css('left','2px');
	}
	
	if (window.BrowserDetect.browser === "Explorer"){
		jQuery('.gm-style img').css('max-width','1000px');
	}
	
	if (isMobile.any()){
		jQuery('.panel-row-style-parallax, .panel-row-style-parallax-wide, .panel-row-style-parallax-overlay,.panel-row-style-parallax-overlay-wide, .pagetitle.panel-row-style-parallax').css('background-attachment','inherit');
	}
	
	/* WPML */
	jQuery(".submenu-languages").addClass('dropdown-menu  sm-nowrap');
	
	
});
function parallaxInit(){
	if (!isMobile.any()){
		jQuery('.panel-row-style-parallax ').each(function(){
			jQuery(this).parallax();
		});
		jQuery('.panel-row-style-parallax-wide ').each(function(){
			jQuery(this).parallax();
		});
		jQuery('.panel-row-style-parallax-overlay ').each(function(){
			jQuery(this).parallax();
		});
		jQuery('.panel-row-style-parallax-overlay-wide ').each(function(){
			jQuery(this).parallax();
		});
	}
}



/***************************************************************
	CLASSIE
***************************************************************/
( function( window ) {
	'use strict';
	function classReg( className ) {
	  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
	}
	var hasClass, addClass, removeClass;
	
	if ( 'classList' in document.documentElement ) {
	  hasClass = function( elem, c ) {
	    return elem.classList.contains( c );
	  };
	  addClass = function( elem, c ) {
	    elem.classList.add( c );
	  };
	  removeClass = function( elem, c ) {
	    elem.classList.remove( c );
	  };
	}
	else {
	  hasClass = function( elem, c ) {
	    return classReg( c ).test( elem.className );
	  };
	  addClass = function( elem, c ) {
	    if ( !hasClass( elem, c ) ) {
	      elem.className = elem.className + ' ' + c;
	    }
	  };
	  removeClass = function( elem, c ) {
	    elem.className = elem.className.replace( classReg( c ), ' ' );
	  };
	}
	
	function toggleClass( elem, c ) {
	  var fn = hasClass( elem, c ) ? removeClass : addClass;
	  fn( elem, c );
	}
	
	var classie = {
	  hasClass: hasClass,
	  addClass: addClass,
	  removeClass: removeClass,
	  toggleClass: toggleClass,
	  has: hasClass,
	  add: addClass,
	  remove: removeClass,
	  toggle: toggleClass
	};
	
	if ( typeof define === 'function' && define.amd ) {
	  define( classie );
	} else {
	  window.classie = classie;
	}
})( window );



jQuery(window).load(function(){
	'use strict';
	jQuery(window).trigger( 'hashchange' );
	jQuery(window).trigger( 'resize' );
	jQuery('[data-spy="scroll"]').each(function () {
    	var $spy = jQuery(this).scrollspy('refresh');
	
  	});  	 	
});

/*
jQuery(window).load(function(){
  	jQuery('.lang_sel_sel').siblings().find('a').attr('href','#demo-purpose');
  	 	
});
*/


/***************************************************************
	ANIMATE HEADER
***************************************************************/
var cbpAnimatedHeader = (function() {
	
	
	var docElem = document.documentElement,
		header = document.querySelector( '.navbar' ),
		didScroll = false,
		changeHeaderOn = 0;

	function init() {
		window.addEventListener( 'scroll', function( event ) {
			if( !didScroll ) {
				didScroll = true;
				setTimeout( scrollPage, 250 );
			}
		}, false );
	}

	function scrollPage() {
		'use strict';
		var sy = scrollY();
		if ( sy >= changeHeaderOn ) {
			classie.add( header, 'navbar-shrink' );
// 			jQuery('.hide-on-start.oldie').animate({ top: '0px' },1000);
		}
		else {
			if (!jQuery('body').hasClass('multipage') && jQuery('.navbar').hasClass('hide-on-start')) {
				classie.remove( header, 'navbar-shrink' );
			}
// 			jQuery('.hide-on-start.oldie').animate({ top: '0px' },1000);
		}
		didScroll = false;
	}

	function scrollY() {
		return window.pageYOffset || docElem.scrollTop;
	}
	init();
})();


/* On Scroll Change header background */
jQuery(window).scroll(function() {    
    var scroll = jQuery(window).scrollTop();

    if (scroll >= 50) {
        jQuery(".tLight").addClass("lightHeader");
        jQuery(".tdark").addClass("darkHeader");
        jQuery(".navbar-default").addClass("nav-shrink");
        jQuery(".hide-on-start").addClass("hide-off");    
        
    } else {
        jQuery(".tLight").removeClass("lightHeader");
        jQuery(".tdark").removeClass("darkHeader");
        jQuery(".navbar-default").removeClass("nav-shrink");
        jQuery(".hide-on-start").removeClass("hide-off");
    }
});



/***************************************************************
	TABS BLOG
***************************************************************/
(function() {
	
	'use strict';
	
	$.fn.tytabs = function(options) {
		var defaults = {
				prefixtabs: "tab",
				prefixcontent: "content",
				classcontent: "tabscontent",
				tabinit: "1",
				catchget: "tab",
				fadespeed: "normal"
			},
			opts = $.extend({}, defaults, options);
		return this.each(function() {
			var obj = jQuery(this);
			opts.classcontent = "." + opts.classcontent;
			opts.prefixcontent = "#" + opts.prefixcontent;

			function showTab(id) {
				jQuery(opts.classcontent, obj).stop(true, true);
				var contentvisible = jQuery(opts.classcontent + ":visible", obj);
				if (contentvisible.length > 0) {
					contentvisible.fadeOut(opts.fadespeed, function() {
						fadeincontent(id)
					})
				} else {
					fadeincontent(id)
				}
				jQuery("#" + opts.prefixtabs + opts.tabinit).removeAttr("class");
				jQuery("#" + opts.prefixtabs + id).attr("class", "current");
				opts.tabinit = id
			}

			function fadeincontent(id) {
				jQuery(opts.prefixcontent + id, obj).fadeIn(opts.fadespeed)
			}
			jQuery("ul.tabs li", obj).click(function() {
				showTab(jQuery(this).attr("id").replace(opts.prefixtabs, ""));
				return false
			});
			var tab = getvars(opts.catchget);
			showTab(((tab && jQuery(opts.prefixcontent + tab).length == 1) ? tab : (
					jQuery(opts.prefixcontent + opts.tabinit).length == 1) ? opts.tabinit :
				"1"))
		})
	};

	function getvars(q, s) {
		s = (s) ? s : window.location.search;
		var re = new RegExp("&" + q + "=([^&]*)", "i");
		return (s = s.replace(/^\?/, "&").match(re)) ? s = s[1] : s = ""
	}
});
	

/***************************************************************
	BLOG ISOTOPE
***************************************************************/
(function(e) {
	"use strict";
	
	e.Isotope.prototype._getMasonryGutterColumns = function() {
		var e = this.options.masonry && this.options.masonry.gutterWidth || 0;
		var t = this.element.width();
		this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
			this.$filteredAtoms.outerWidth(true) || t;
		this.masonry.columnWidth += e;
		this.masonry.cols = Math.floor((t + e) / this.masonry.columnWidth);
		this.masonry.cols = Math.max(this.masonry.cols, 1)
	};
	e.Isotope.prototype._masonryReset = function() {
		this.masonry = {};
		this._getMasonryGutterColumns();
		var e = this.masonry.cols;
		this.masonry.colYs = [];
		while (e--) {
			this.masonry.colYs.push(0)
		}
	};
	e.Isotope.prototype._masonryResizeChanged = function() {
		var e = this.masonry.cols;
		this._getMasonryGutterColumns();
		return this.masonry.cols !== e
	};
	e(document).ready(function() {
		var t = e(".journal.iso");
		var n = 0;
		var r = 0;
		var i = function() {
			var e = parseInt(t.data("columns"));
			var i = t.data("gutterSpace");
			var s = t.width();
			var o = 0;
			if (isNaN(i)) {
				i = .02
			} else if (i > .05 || i < 0) {
				i = .02
			}
			if (s < 568) {
				e = 1
			} else if (s < 768) {
				e -= 2
			} else if (s < 991) {
				e -= 1;
				if (e < 2) {
					e = 2
				}
			}
			if (e < 1) {
				e = 1
			}
			r = Math.floor(s * i);
			var u = r * (e - 1);
			var a = s - u;
			n = Math.floor(a / e);
			o = r;
			if (1 == e) {
				o = 20
			}
			t.children(".journal-post").css({
				width: n + "px",
				marginBottom: o + "px"
			})
		};
		i();
		t.isotope({
			itemSelector: ".journal-post",
			resizable: false,
			masonry: {
				columnWidth: n,
				gutterWidth: r
			}
		});
		t.imagesLoaded(function() {
			i();
			t.isotope({
				itemSelector: ".journal-post",
				resizable: false,
				masonry: {
					columnWidth: n,
					gutterWidth: r
				}
			})
		});
		e(window).smartresize(function() {
			i();
			t.isotope({
				masonry: {
					columnWidth: n,
					gutterWidth: r
				}
			})
		});
		var s = e(".wc-shortcodes-filtering .wc-shortcodes-term");
		s.click(function(i) {
			i.preventDefault();
			s.removeClass("wc-shortcodes-term-active");
			e(this).addClass("wc-shortcodes-term-active");
			var o = e(this).attr("data-filter");
			t.isotope({
				filter: o,
				masonry: {
					columnWidth: n,
					gutterWidth: r
				}
			});
			return false
		})
	})
})(jQuery)

jQuery(window).bind('resize', function () { 
  if (jQuery(this).width() > 768) {
	  jQuery('a.down-button').removeClass('current');
	  jQuery('.slidedown').removeAttr('style');
  }
});



/***************************************************************
	WAYPOINTS SCROLL INTO VIEW
***************************************************************/
function isScrolledIntoView(id){
	'use strict';
    var elem = "#" + id;
    var docViewTop = jQuery(window).scrollTop();
    var docViewBottom = docViewTop + jQuery(window).height();

    if (jQuery(elem).length > 0){
        var elemTop = jQuery(elem).offset().top;
        var elemBottom = elemTop + jQuery(elem).height();
    }

    return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom)
      && (elemBottom <= docViewBottom) &&  (elemTop >= docViewTop) );
}
function incrementNumerical(id, percent, speed){
	setTimeout(function(){
		var newVal = parseInt(jQuery(id+' .value').html(),10)+speed;

		if (newVal > percent) newVal = percent;
		jQuery(id+' .value').html(newVal);
		if (newVal < percent){
			incrementNumerical(id, percent, speed);
		}
	}, 1);
}

