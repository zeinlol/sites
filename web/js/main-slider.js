	$(document).ready(function() {

	if( $(window).width() >= 768 ){
		//Slider on main page
		var sliderWidth = $('.main-slider').width(); //Slider container width
		$('.main-slider ul li img').css('width', sliderWidth);
		var numberOfSlides = $('.main-slider ul > li').length; //Number of slides in slider
		$('.main-slider ul').css('width', numberOfSlides*sliderWidth+1000);
		var slideTimer = setInterval(function(){
			var slideIndex = $('.main-slider ul li.slide-active').index()+1; //Number of current slide
			if ( $('.main-slider ul li.slide-active').is(':last-of-type') ) {
				$('.main-slider ul').css('transform', 'translate3d(0,0,0)');
				$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
				setTimeout(function(){
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
				}, 1200);
				$('.main-slider ul li.slide-active').removeClass('slide-active');
				$('.main-slider ul li:first-of-type').addClass('slide-active');
			} else {
				$('.main-slider ul').css('transform', 'translate3d(' + ( -slideIndex*sliderWidth ) + 'px,0,0)');
				$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
				setTimeout(function(){
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
				}, 1200);
				$('.main-slider ul li.slide-active').removeClass('slide-active').next().addClass('slide-active');
			}
		}, 6000);
		$(window).on("resize",function(e){ //Update slider on resize
			sliderWidth = $('.main-slider').width();
			$('.main-slider ul li img').css('width', sliderWidth);
			$('.main-slider ul').css('width', numberOfSlides*sliderWidth);
			$('.main-slider ul li.slide-active').removeClass('slide-active');
			$('.main-slider ul li:first-of-type').addClass('slide-active');
			$('.main-slider ul').css('transform', 'translate3d(0,0,0)');
			slideIndex = $('.main-slider ul li.slide-active').index()+1;
		});
		$('#slider-nav-right').click(function(event) { //Slide right onclick
			var slideIndex = $('.main-slider ul li.slide-active').index()+1;
			if ( $('.main-slider ul li.slide-active').is(':last-of-type') ) {
				$('.main-slider ul').css('transform', 'translate3d(0,0,0)');
				$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
				setTimeout(function(){
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
				}, 1200);
				$('.main-slider ul li.slide-active').removeClass('slide-active');
				$('.main-slider ul li:first-of-type').addClass('slide-active');
			} else {
				$('.main-slider ul').css('transform', 'translate3d(' + ( -slideIndex*sliderWidth ) + 'px,0,0)');
				$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
				setTimeout(function(){
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
				}, 1200);
				$('.main-slider ul li.slide-active').removeClass('slide-active').next().addClass('slide-active');
			}
		});
		$('#slider-nav-left').click(function(event) { //Slide left onclick
			var slideIndex = $('.main-slider ul li.slide-active').index()+1;
			if ( $('.main-slider ul li.slide-active').is(':first-of-type') ) {
				$('.main-slider ul').css('transform', 'translate3d(' + ( -(numberOfSlides - 1)*sliderWidth ) + 'px,0,0)');
				$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
				setTimeout(function(){
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
				}, 1200);
				$('.main-slider ul li.slide-active').removeClass('slide-active');
				$('.main-slider ul li:last-of-type').addClass('slide-active');
			} else {
				$('.main-slider ul').css('transform', 'translate3d(' + ( -(slideIndex - 2)*sliderWidth ) + 'px,0,0)');
				$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
				setTimeout(function(){
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
				}, 1200);
				$('.main-slider ul li.slide-active').removeClass('slide-active').prev().addClass('slide-active');
			}
		});
		$('.main-slider').mouseover(function(){ //Pause slider onhover
			clearInterval(slideTimer);
		}).mouseout(function(){
			slideTimer = setInterval(function(){
				var slideIndex = $('.main-slider ul li.slide-active').index()+1;
				if ( $('.main-slider ul li.slide-active').is(':last-of-type') ) {
					$('.main-slider ul').css('transform', 'translate3d(0,0,0)');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
					setTimeout(function(){
						$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
						$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
					}, 1200);
					$('.main-slider ul li.slide-active').removeClass('slide-active');
					$('.main-slider ul li:first-of-type').addClass('slide-active');
				} else {
					$('.main-slider ul').css('transform', 'translate3d(' + ( -slideIndex*sliderWidth ) + 'px,0,0)');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
					setTimeout(function(){
						$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
						$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
					}, 1200);
					$('.main-slider ul li.slide-active').removeClass('slide-active').next().addClass('slide-active');
				}
			}, 6000);
		})
	}else{

		var sliderWidth = $('.main-slider').width();
		$('.main-slider ul li img, .main-slider').css('height', '300px');
		var slideImgWidth = $('.main-slider ul li img').width();
		var numberOfSlides = $('.main-slider ul > li').length;
		$('.main-slider ul').css('width', numberOfSlides*slideImgWidth+1000);
		var mrgSlideImg = (slideImgWidth - sliderWidth) / 2;
		$('.main-slider ul').css('transform', 'translate3d(-' + mrgSlideImg + 'px,0,0)');
		$('.slide-text').css({
			'width': sliderWidth + 'px',
			'left': mrgSlideImg + 'px'
		});

		$(window).resize(function(event) {
			sliderWidth = $('.main-slider').width();
			$('.main-slider ul li img').css('height', '300px');
			slideImgWidth = $('.main-slider ul li img').width();
			numberOfSlides = $('.main-slider ul > li').length;
			$('.main-slider ul').css('width', numberOfSlides*slideImgWidth+1000);
			mrgSlideImg = (slideImgWidth - sliderWidth) / 2;
			$('.main-slider ul').css('transform', 'translate3d(-' + mrgSlideImg + 'px,0,0)');
			$('.slide-text').css({
				'width': sliderWidth + 'px',
				'left': mrgSlideImg + 'px'
			});

			$('.main-slider ul li.slide-active').removeClass('slide-active');
			$('.main-slider ul li:first-of-type').addClass('slide-active');
			$('.main-slider ul').css('transform', 'translate3d(' + ( -(mrgSlideImg + slideIndex*slideImgWidth)) + 'px,0,0)');
			slideIndex = $('.main-slider ul li.slide-active').index()+1;
		});

		var slideTimer = setInterval(function(){
			var slideIndex = $('.main-slider ul li.slide-active').index()+1; //Number of current slide
			if ( $('.main-slider ul li.slide-active').is(':last-of-type') ) {
				$('.main-slider ul').css('transform', 'translate3d(-' + mrgSlideImg + 'px,0,0)');
				$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
				setTimeout(function(){
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
				}, 1200);
				$('.main-slider ul li.slide-active').removeClass('slide-active');
				$('.main-slider ul li:first-of-type').addClass('slide-active');
			} else {
				$('.main-slider ul').css('transform', 'translate3d(' + ( -(mrgSlideImg + slideIndex*slideImgWidth)) + 'px,0,0)');
				$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
				setTimeout(function(){
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
				}, 1200);
				$('.main-slider ul li.slide-active').removeClass('slide-active').next().addClass('slide-active');
			}
		}, 6000);

		$('.main-slider').on('swipeleft',function(){ //On swipe left
			var slideIndex = $('.main-slider ul li.slide-active').index()+1;
			if ( $('.main-slider ul li.slide-active').is(':last-of-type') ) {
				$('.main-slider ul').css('transform', 'translate3d(-' + mrgSlideImg + 'px,0,0)');
				$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
				setTimeout(function(){
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
				}, 1200);
				$('.main-slider ul li.slide-active').removeClass('slide-active');
				$('.main-slider ul li:first-of-type').addClass('slide-active');
			} else {
				$('.main-slider ul').css('transform', 'translate3d(' + ( -(mrgSlideImg + slideIndex*slideImgWidth)) + 'px,0,0)');
				$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
				setTimeout(function(){
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
				}, 1200);
				$('.main-slider ul li.slide-active').removeClass('slide-active').next().addClass('slide-active');
			}
		});

		$('.main-slider').on('swiperight',function(){ //On swipe right
			var slideIndex = $('.main-slider ul li.slide-active').index()+1;
			if ( $('.main-slider ul li.slide-active').is(':first-of-type') ) {
				$('.main-slider ul').css('transform', 'translate3d(' + ( -((numberOfSlides-1)*slideImgWidth) - mrgSlideImg ) + 'px,0,0)');
				$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
				setTimeout(function(){
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
				}, 1200);
				$('.main-slider ul li.slide-active').removeClass('slide-active');
				$('.main-slider ul li:last-of-type').addClass('slide-active');
			} else {
				$('.main-slider ul').css('transform', 'translate3d(' + ( -(mrgSlideImg + (slideIndex-2)*slideImgWidth) ) + 'px,0,0)');
				$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
				setTimeout(function(){
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
				}, 1200);
				$('.main-slider ul li.slide-active').removeClass('slide-active').prev().addClass('slide-active');
			}
		});

		$('.main-slider').on('swipe', function(){ //Pause slider on swipe
			clearInterval(slideTimer);
			slideTimer = setInterval(function(){
				var slideIndex = $('.main-slider ul li.slide-active').index()+1; //Number of current slide
				if ( $('.main-slider ul li.slide-active').is(':last-of-type') ) {
					$('.main-slider ul').css('transform', 'translate3d(-' + mrgSlideImg + 'px,0,0)');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
					setTimeout(function(){
						$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
						$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
					}, 1200);
					$('.main-slider ul li.slide-active').removeClass('slide-active');
					$('.main-slider ul li:first-of-type').addClass('slide-active');
				} else {
					$('.main-slider ul').css('transform', 'translate3d(' + ( -(mrgSlideImg + slideIndex*slideImgWidth)) + 'px,0,0)');
					$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeOutDown');
					setTimeout(function(){
						$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').removeClass('fadeInUp fadeOutDown');
						$('.slide-text-top, .slide-divider, .slide-text-heading, .slide-text-bottom').addClass('fadeInUp');
					}, 1200);
					$('.main-slider ul li.slide-active').removeClass('slide-active').next().addClass('slide-active');
				}
			}, 6000);
		});
	}
	});