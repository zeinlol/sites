var slider = $('.slider');
			slider.slider();							
			calcProfit();	
			
			slider.on("slide", function(slideEvt) {		
				var unf = accounting.unformat(slideEvt.value);
				var value=accounting.formatNumber(parseInt(unf), 0, " ");
				$(this).parent().parent().parent().find('.price-view').find('.price').text(value);				
			});

			slider.on("change", function() {				
				calcProfit();						
			});
			

			function calcProfit()
			{
				var fee=accounting.unformat($('#fee').text());
				var royalty=accounting.unformat($('#royalty').text());		
				var res1=(parseInt(royalty)*12)+parseInt(fee);	
				res1=accounting.formatNumber(res1, 0, " ");		
				$('#res1').text(res1);				
				var res2=parseInt(royalty)*12+parseInt(royalty)*9+parseInt(royalty)*6+parseInt(royalty)*3+parseInt(fee)*4;
				res2=accounting.formatNumber(res2, 0, " ");
				$('#res2').text(res2);				
			};