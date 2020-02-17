$(function () {
	$(".btn-in-list").click(function(){
		$(".btn-in-block").removeClass("active-in-btns");
		$(".btn-in-list").addClass("active-in-btns");
		
		if($(".align-row").hasClass("in-block")){
		$(".align-row").removeClass("in-block");	
		
		
	} 
		
		
		$(".align-row").addClass("in-list");
		 
		
	});
	
		$(".btn-in-block").click(function(){
		
		$(".btn-in-list").removeClass("active-in-btns");
			$(".btn-in-block").addClass("active-in-btns");
			
			
		if($(".align-row").hasClass("in-list")){
		$(".align-row").removeClass("in-list");	
	
		
	} 
		$(".align-row").addClass("in-block");	
		 
		
	});
	

	
	
	$('.multiple-items').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		dots: true,accessibility:true,
			 responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    }],
	});
	
	
	
	
	$('.slider-posts').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		dots: true,
		responsive: [{
			breakpoint: 640,
			settings: {
				slidesToShow: 1
			}
		}, {
			breakpoint: 320,
			settings: {
				infinite: true
			}
		}]
	});
	
	
	
	
	
	
	$('.slider-post-min').slick({
		infinite: true,
		slidesToShow: 3,
		slidesToScroll: 3,
		arrows: false,
		dots: true,
		responsive: [{
			breakpoint: 640,
			settings: {
				slidesToShow: 1
			}
		}, {
			breakpoint: 320,
			settings: {
				infinite: true
			}
		}]
	});
	
	
	
	
	
	
	
	
	
	
	
	 
	
	
	
	
});