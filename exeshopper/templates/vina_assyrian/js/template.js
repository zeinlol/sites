/**
* @package Helix3 Framework
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2015 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
jQuery(function($) {
	
	
	$('.carousel').carousel({
	  interval: 3000
	})
	
	 $(document).click(function(e) {
        if (e.target.className == 'sp-vmsearch-box') {
		   $(".sp-vmsearch").addClass('show');
        } else {
           $(".sp-vmsearch").removeClass('show');
        }
    });
	
	/*  [ Page loader]
	- - - - - - - - - - - - - - - - - - - - */
	setTimeout(function() {
		$( 'body' ).addClass( 'loaded' );
		setTimeout(function () {
			$('#pageloader').remove();
		}, 1500);
	}, 1500);

	/* Goto Top */		
	$(window).scroll(function(event) {	
		if ($(this).scrollTop() > 300) {
			$('.sp-totop').addClass('active');
		} else {
			$('.sp-totop').removeClass('active');
		}
	});
	
	$('.sp-totop').on('click', function() {
		$('html, body').animate({
			scrollTop: $("body").offset().top
		}, 500);
	});
	
		/*Fix Carousel*/
	$(".carousel").each( function() {
		$(this).parent().addClass("wrap-carousel");
	});
	
	$(".vina-vmtreeview .sp-module-title h3").click(function() {
		$(this).parents(".vina-vmtreeview").find(".vina-treeview-virtuemart").slideToggle();
	});
	
	$(".vina-carousel-virtuemart").each( function() {
		$vmcr_pright = parseInt($(this).find(".item").css('padding-right'),10);
		$vmcr_pleft = parseInt($(this).find(".item").css('padding-left'),10);
		$mod_featured = $(this).parents(".sp-module").width();
		$(this).css({
			"width"  :  $vmcr_pright + $vmcr_pleft + $mod_featured,	
		});
		
		if($(this).parents("body.rtl").length){
			$(this).css({
				"margin-right": - ($vmcr_pright + $vmcr_pleft)/2 ,
				"margin-left": 0,
			});
		} else {
			$(this).css({
				"margin-left"	: - ($vmcr_pright + $vmcr_pleft)/2 ,
			});
		}
	});		
	
	$(".vina-carousel-content").each( function() {
		$vmcr_pright = parseInt($(this).find(".item-col").css('padding-right'),10);
		$vmcr_pleft = parseInt($(this).find(".item-col").css('padding-left'),10);
		$mod_featured = $(this).parents(".sp-module").width();
		$(this).css({
			"width"  :  $vmcr_pright + $vmcr_pleft + $mod_featured,	
		});
		
		if($(this).parents("body.rtl").length){
			$(this).css({
				"margin-right": - ($vmcr_pright + $vmcr_pleft)/2 ,
				"margin-left": 0,
			});
		} else {
			$(this).css({
				"margin-left"	: - ($vmcr_pright + $vmcr_pleft)/2 ,
			});
		}
	});	
	
	$(window).load(function(){
		$(".vina-carousel-virtuemart").each( function() {
			$vmcr_pright = parseInt($(this).find(".item").css('padding-right'),10);
			$vmcr_pleft = parseInt($(this).find(".item").css('padding-left'),10);
			$mod_featured = $(this).parents(".sp-module").width();
			$(this).css({
				"width"  :  $vmcr_pright + $vmcr_pleft + $mod_featured,	
			});
			
			if($(this).parents("body.rtl").length){
				$(this).css({
					"margin-right": - ($vmcr_pright + $vmcr_pleft)/2 ,
					"margin-left": 0,
				});
			} else {
				$(this).css({
					"margin-left"	: - ($vmcr_pright + $vmcr_pleft)/2 ,
				});
			}
		});	
		$(".vina-carousel-content").each( function() {
			$vmcr_pright = parseInt($(this).find(".item-col").css('padding-right'),10);
			$vmcr_pleft = parseInt($(this).find(".item-col").css('padding-left'),10);
			$mod_featured = $(this).parents(".sp-module").width();
			$(this).css({
				"width"  :  $vmcr_pright + $vmcr_pleft + $mod_featured,	
			});
			
			if($(this).parents("body.rtl").length){
				$(this).css({
					"margin-right": - ($vmcr_pright + $vmcr_pleft)/2 ,
					"margin-left": 0,
				});
			} else {
				$(this).css({
					"margin-left"	: - ($vmcr_pright + $vmcr_pleft)/2 ,
				});
			}
		});	
	});
		
	$(window).resize(function(){	
		$(this).load();
	});
	
});

function viewMode(mode)
{
	jQuery('#vina-product-category .view-mode').find('a').removeClass('active');
	if(mode == 'list') {
		jQuery('#vina-product-category').addClass('list');
		jQuery('#vina-product-category').find('a.view-list').addClass('active');
	}
	else {
		jQuery('#vina-product-category').removeClass('list');
		jQuery('#vina-product-category').find('a.view-grid').addClass('active');
	}
	jQuery.cookie('listing', mode);
}