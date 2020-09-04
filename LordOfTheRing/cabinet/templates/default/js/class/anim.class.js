

function _anim() {
	
	this.anim_enable = true;
	
	this.show = function( elem ) {
		elem.style.display = 'block';
	};
	
	this.hide = function( elem ) {
		elem.style.display = 'none';
	};
	
	this.image_update = function( elem ) {
		elem.src = elem.src.replace(/update=\d/, 'update=' + (Math.random() * 1000) . toFixed(0));
	};
	
	//this.animations(menu, {time: 5000, fps: 30}, {{css: "marginTop", end: "px", min: 2, max: 5}});
	this.timers = new Array();
	this.animations = function( elem, speed, styles ) {
		if ( !this.anim_enable ) return 1;
		var elemid = 'id-' + elem.className + elem.nodeName + elem.id;
		
		if ( this.timers[elemid] != null ) {
			for ( var i = 0, Max = this.timers[elemid].length; i < Max; i ++ ) {
				clearInterval(this.timers[elemid][i]);
				this.timers[elemid][i] = null;
			}
		}
		
		this.timers[elemid] = new Array();
		
		var i = 0, _this = this;
		for ( var key in styles ) {
			
			var style = styles[key],
				time_delay = 1000 / speed.fps,
				delay = (style.max - style.min) / (speed.time / 1000 * speed.fps),
				progress = style.min;
			
			if ( style.min != false ) elem.style[style.css] = style.min + style.end;
			
			this.timers[elemid][i] = setInterval(function() {
				
				if ( style.max <= progress ) {
					elem.style[style.css] = style.max + style.end;
					clearInterval(_this.timers[elemid][i - 1]);
				} else {
					progress += delay;
					elem.style[style.css] = progress + style.end;
				}
				
			}, time_delay);
			
			i ++;
		}
	};
};