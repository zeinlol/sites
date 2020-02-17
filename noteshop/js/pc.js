$(function() {
			var current;
			function rotate() {
				if (current == 1) {
					$("#block-1").removeClass().addClass("active");
					$("#block-2").removeClass().addClass("non-active-left");
					$("#block-3").removeClass().addClass("non-active-right");
                    $("#block-4").removeClass().addClass("non-active-bottom");
				} else if (current == 2) {
					$("#block-1").removeClass().addClass("non-active-right");
					$("#block-2").removeClass().addClass("active");
					$("#block-3").removeClass().addClass("non-active-bottom");
                    $("#block-4").removeClass().addClass("non-active-left");
				} else if (current == 3) {
                    $("#block-1").removeClass().addClass("non-active-left");
                    $("#block-2").removeClass().addClass("non-active-bottom");
                    $("#block-3").removeClass().addClass("active");
                    $("#block-4").removeClass().addClass("non-active-right");
				} else {
                    $("#block-1").removeClass().addClass("non-active-bottom");
					$("#block-2").removeClass().addClass("non-active-right");
					$("#block-3").removeClass().addClass("non-active-left");
                    $("#block-4").removeClass().addClass("active");
                }
			}
			$("#rotator div").click(function() {
	// Enables reversing, idea via Andrea Canton: 
				current = this.id.substr(6);
				rotate();
			});
		});