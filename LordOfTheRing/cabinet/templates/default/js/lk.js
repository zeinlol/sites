
function _lk( csrf_key, ajax, ddos ) {

	this.anim = new _anim();
	this.req = new _req(ajax, csrf_key, ddos);
	this.username = '';
	this.money = 0;
	this.icmoney = false;
	this.server = new Array();
	this.status = new Array();
	this.cur = new Array();
	this.prefix = new Array();
	this.iconomy = new Array();
	this.alert_window = false;
	this.linkParams = new Array();
	this.path = '';
	this.MouseCoords = {
		getX: function(e)
		{
			if (e.pageX)
			{
				return e.pageX - (document.documentElement.scrollLeft || document.body.scrollLeft);
			}
			else if (e.clientX)
			{
				return e.clientX+(document.documentElement.scrollLeft || document.body.scrollLeft) - document.documentElement.clientLeft;
			}

			return 0;
		},
		
		getY: function(e)
		{
			if (e.pageY)
			{
				return e.pageY - (document.documentElement.scrollTop || document.body.scrollTop);
			}
			else if (e.clientY)
			{
				return e.clientY+(document.documentElement.scrollTop || document.body.scrollTop) - document.documentElement.clientTop;
			}

			return 0;
		}
	}
	
	this.init = function() {
		
		_this = this;
		document.getElementById('alert_bg_dark').addEventListener("click", function(e) {
			
			var elem = e.target;
			
			if ( _this.alert_window )
			{
				_this.alert_window_close();
			}
			
		});
		
		var linkParams_ = location.hash.split('#');
		
		for ( var i = 1, Max = linkParams_.length; i < Max; i ++ ) {
			var values = linkParams_[i].split('=');
			this.linkParams[values[0]] = values[1];
		}
		
		
		if ( this.linkParams['page'] != null ) {
			
			if ( 0 < this.linkParams['page'] < 6 ) {
				this.menu(this.linkParams['page']);
			}
			
		}
		
		if ( this.linkParams['alert'] != null ) {
			switch ( this.linkParams['alert'] ) {
				
				case 'catalogSkins': {
					this.catalogSkins();
					break;
				}
				
				case 'buyStatus': {
					this._selectServer = this.linkParams['server'];
					this.selStatus(this.linkParams['id']);
					break;
				}
				
				default: {
					this.alert('Такого диалогового окна нет!', 5000);
				}
				
			}
		}
		
		this.req.ddos *= 1000;
	};
	
	this.indexByValue = function(array, value) {
		
		for( var i = 0, Max = array.length; i < Max; i ++ )
			if ( array[i] == value ) return i;
		
		return -1;
	};
	
	this.menu_show_last = 1;
	
	this.menu = function( id ) {
		
		if ( id == this.menu_show_last ) return 1;
		
		var content = document.getElementById('lk-body-block-' + id), elem = document.getElementById('menu-' + id);
		elem.classList.add('lk-menu-nav-active');
		elem.parentNode.children[this.menu_show_last - 1].classList.remove('lk-menu-nav-active');
		this.anim.show(content);
		this.anim.hide(document.getElementById('lk-body-block-' + this.menu_show_last));
		
		this.anim.animations(content, {time: 2000, fps: 90}, [
			{css: "opacity", end: "", min: 0, max: 10}
		]);
		
		this.menu_show_last = id;
	};
	
	
	this.skin = function( mouse ) {
		
		if ( mouse == 1 )
		{
			this.anim.hide(document.getElementById('lk-body-block-1-skin-1'));
			this.anim.show(document.getElementById('lk-body-block-1-skin-2'));
		} else {
			this.anim.hide(document.getElementById('lk-body-block-1-skin-2'));
			this.anim.show(document.getElementById('lk-body-block-1-skin-1'));
		}
	};
	
	this.upload_skin = function( type ) {
		
		var efile = document.getElementById('lk-body-block-1-skin-upload_skin'), file = efile.files[0], _this = this;
		var filetype = (type == 1 ? 'Скин' : 'Плащ');
		
		if ( file )
		{
			var progress_bar = document.getElementById('lk-progress-upload'), bar = progress_bar.lastChild;
			this.anim.show(progress_bar);
			this.anim.animations(progress_bar, {time: 2000, fps: 90}, [
				{css: "opacity", end: "", min: 0, max: 10}
			]);
			
			this.req.upload(file, { type: "upload", type_upload: type, serverid: (efile.previousElementSibling != null ? efile.previousElementSibling.value : -1) }, function(e) {
				
				var value = 100 / (e.total / e.loaded);
				bar.style.width = value + '%';
				bar.innerHTML = value.toFixed(0) + '%';
				
			}, function (e) {
				if ( e.status == 200 )
				{
					var json = JSON.parse(e.responseText);
					
					if ( json.status != 'error' )
					{
						_this.updateSkin();
					} else
						_this.alert('<b>Ошибка:</b> ' + json.message, 5000);
				} else
					_this.alert('Ошибка при загрузке ' + filetype + 'а', 3000);
				
				_this.anim.hide(progress_bar);
			});
		} else {
			this.alert('Загрузите ' + filetype + '!', 3000);
		}	
	};
	
	this._selectServer = -1;
	
	this.selectServer = function( elem, server_id ) {
		
		if ( server_id == this._selectServer ) return false;
		
		elem.style.border = '2px solid #FF9292';
		
		var opt = document.getElementById('lk-body-block-2-server-opt');
		if ( opt.style.display == 'none' )
		{
			opt.style.display = 'block';
			this.anim.animations(opt, {time: 3000, fps: 90}, [
				{css: "opacity", end: "", min: 0, max: 10}
			]);
		}
		
		var server_e = document.getElementById('lk-body-block-2-server-opt-status').children;
		server_e[this.server[server_id][0]].style.border = '1px solid #FF9292';
		
		var prefix_input = document.getElementById('lk-body-block-2-server-opt-prefix-inputes').children;
		for ( var i = 0; i < 4; i ++ ) {
			prefix_input[i].value = this.server[server_id][3][i];
		}
		
		if ( this.server[server_id][0] > 0 ) server_e[this.server[server_id][0]].children[1].innerHTML = 'Продлить';
		
		if ( this._selectServer != -1 )
		{
			elem.parentElement.children[this._selectServer].style.border = '';
			
			if ( this.server[server_id][0] != this.server[this._selectServer][0] ) {
				server_e[this.server[this._selectServer][0]].style.border = '';
				if ( this.server[this._selectServer][0] > 0 ) server_e[this.server[this._selectServer][0]].children[1].innerHTML = 'Купить';
			}	
		}
		
		this._selectServer = server_id;
	};
	
	this.updateServer = function( server_id, status_id, time ) {
		var server_e = document.getElementById('lk-body-block-2-servers').children[server_id];
		
		if ( this.server.length > 1 ) {
			if ( server_id ) {
				this.selectServer(server_e, 0);
			} else {
				this.selectServer(server_e, 1);
			}	
			this.server[server_id][0] = status_id;
			this.server[server_id][1] = time;
			this.selectServer(server_e, server_id);
		}
		
		this.server[server_id][0] = status_id;
		this.server[server_id][1] = time;
			
		var time_end = new Date(time), mounth = time_end.getMonth() + 1;
		server_e.lastElementChild.firstElementChild.innerHTML = this.status[status_id][0];
		server_e.lastElementChild.lastElementChild.innerHTML = '(Закончится '+ time_end.getDate() + '.' + (mounth > 9 ? mounth : '0' + mounth) + '.' + time_end.getFullYear() +')';
	};
	
	this.giveMoney = function( money ) {
		this.money += money;
		
		for ( var i = 1, Max = 3; i <= Max; i ++ )
		{
			if ( document.getElementById('lk-money-' + i) != null )
				document.getElementById('lk-money-' + i).innerHTML = this.money + ' ' + this.cur[1] + '.';
		}
	};
	
	this.giveMoneyIC = function( money ) {
		if ( this.icmoney == false ) return 1;
		this.icmoney += money;
		
		for ( var i = 1, Max = 3; i <= Max; i ++ )
		{
			if ( document.getElementById('lk-icmoney-' + i) != null )
				document.getElementById('lk-icmoney-' + i).innerHTML = this.icmoney + ' монет';
		}
	};
	
	this.selStatus = function( status_id ) {
		
		var selServer = this._selectServer;
		
		if ( status_id != this.server[selServer][0] ) {
			this.alert_window_open('Покупка статуса <b>' + this.status[status_id][0] + '</b> на сервер ' + this.server[selServer][2], '<p>' + this.status[status_id][1] + '</p>\
			<input type="text" class="lk-input_text-1" onkeyup="this.nextElementSibling.value = \'Купить статус за \' + ('+ this.status[status_id][2] +' / '+ this.status[status_id][3] +' * this.value).toFixed(0) + \''+ this.cur[1] +'.\'" style="width: 100px;" value="30" '+ (!this.status[status_id][4] ? 'disabled=""' : '') +'\> дней\
			<input type="button" onclick="lk.buyStatus('+ status_id +', this.previousElementSibling.value)" class="lk-button-1" style="width: 200px; float: right;" value="Купить статус за '+ this.status[status_id][2] +' '+ this.cur[1] +'."\>', 500, 300);
		} else {
			this.alert_window_open('Продление статуса <b>' + this.status[status_id][0] + '</b> на сервере ' + this.server[selServer][2], '<p>' + this.status[status_id][1] + '</p>\
			<input type="text" class="lk-input_text-1" onkeyup="this.nextElementSibling.value = \'Продлить статус за \' + ('+ this.status[status_id][2] +' / '+ this.status[status_id][3] +' * this.value).toFixed(0) + \''+ this.cur[1] +'.\'" style="width: 100px;" value="30" '+ (!this.status[status_id][4] ? 'disabled=""' : '') +'\> дней\
			<input type="button" onclick="lk.extendStatus('+ status_id +', this.previousElementSibling.value)" class="lk-button-1" style="width: 250px; float: right;" value="Продлить статус за '+ this.status[status_id][2] +' '+ this.cur[1] +'."\>', 500, 300);
		}
	};
	
	this.buyStatus = function( status_id, days ) {
		
		this.alert_window_close();
		
		if ( !(days * days) || (days+"").indexOf(".") > 0 )
		{
			this.alert('<b>Ошибка:</b> Укажите кол-во дней целым числовым значением!', 3000);
			return 1;
		}
		
		var price_status = this.status[status_id][2] / this.status[status_id][3] * days;
		
		if ( this.money < price_status )
		{
			this.alert('<b>Ошибка:</b> Не хватает денег для покупки данного статуса.', 3000);
			return 1;
		}
		
		this.alert('Подождите...', 0);
		var _this = this, selServer = this._selectServer;
		this.req.send_post({type: "buy_status", serverid: selServer, statusid: status_id, time_day: days}, function( json ) {
			
			if ( json.status == 'success' ) {
				
				_this.giveMoney(-price_status);
				_this.updateServer(selServer, status_id, _this.time() + days * 86400000);
				//document.getElementById('lk-server-' + selServer).lastElementChild.lastElementChild.innerHTML = _this.status[status_id][0];
				
				_this.alert('Статус '+ _this.status[status_id][0] +' успешно приобретен на '+ days +' дн!', 5000);
				
			} else _this.alert('Ошибка: ' + json.message, 0);
			
		});
		
	};
	
	this.extendStatus = function( status_id, days ) {
		
		this.alert_window_close();
		
		if ( !(days * days) || (days+"").indexOf(".") > 0 )
		{
			this.alert('<b>Ошибка:</b> Укажите кол-во дней целым числовым значением!', 3000);
			return 1;
		}
		
		var price_status = this.status[status_id][2] / this.status[status_id][3] * days;
		
		if ( this.money < price_status )
		{
			this.alert('<b>Ошибка:</b> Не хватает денег для продления данного статуса.', 3000);
			return 1;
		}
		
		this.alert('Подождите...', 0);
		var _this = this;
		this.req.send_post({type: "extend_status", serverid: this._selectServer, time_day: days}, function( json ) {
			
			if ( json.status == 'success' ) {
				
				_this.giveMoney(-price_status);
				_this.updateServer(_this._selectServer, status_id, _this.server[_this._selectServer][1] + days * 86400000);
				
				_this.alert('Статус '+ _this.status[status_id][0] +' успешно продлен на '+ days +' дн!', 5000);
				
			} else _this.alert('Ошибка: ' + json.message, 0);
			
		});
		
	};
	
	this.prefix = function() {
		
		// 0 - цвет префикса, 1 - префикс, 2 - цвет ника, 3 - цвет сообщения
		var prefix_input = document.getElementById('lk-body-block-2-server-opt-prefix-inputes').children;
		
		if ( prefix_input[1].value.length < this.prefix[0] || prefix_input[1].value.length > this.prefix[1] )
		{
			this.alert('<b>Ошибка:</b> Префикс должен быть длиной от ' + this.prefix[0] + ' до '+ this.prefix[1] +' символов.', 5000);
			return 1;
		}
		
		this.alert('Подождите...', 0);
		var _this = this;
		this.req.send_post({type: "set_prefix",
			serverid: this._selectServer,
			color_prefix: prefix_input[0].value,
			name_prefix: prefix_input[1].value,
			color_nickname: prefix_input[2].value,
			color_message: prefix_input[3].value}, function( json ) {
			
			if ( json.status == 'success' ) {
				
				for ( var i = 0; i < 4; i ++ ) {
					_this.server[_this._selectServer][3][i] = prefix_input[i].value;
				}	
				_this.alert('Префикс успешно установлен на сервере '+ _this.server[_this._selectServer][2] +'!', 5000);
				
			} else _this.alert('Ошибка: ' + json.message, 0);
			
		});
	};
	
	this.exchange_iconomy = function( server_id, type, value ) {
		
		if ( !(value * value) || (value+"").indexOf(".") > 0 || value < 1 )
		{
			this.alert('<b>Ошибка:</b> Укажите целое число больше нуля!', 3000);
			return 1;
		}
		
		this.alert('Подождите...', 0);
		var _this = this;
		this.req.send_post({type: 'exchange_iconomy', type_exchange: type, serverid: server_id, value: value}, function( json ) {
			
			if ( json.status == 'success' ) {
				
				_this.giveMoney(json.money);
				_this.giveMoneyIC(json.icmoney);
				_this.alert('Обмен успешно произведен!', 5000);
				
			} else _this.alert('Ошибка: ' + json.message, 0);
			
		});
	};
	
	this.updateSkin = function() {
		
		var image1 = document.getElementById('lk-body-block-1-skin-1').children,
			image2 = document.getElementById('lk-body-block-1-skin-2').children;
		this.anim.image_update(image1[0]);
		this.anim.image_update(image1[1]);
		this.anim.image_update(image2[0]);
		this.anim.image_update(image2[1]);
		
		this.anim.animations(document.getElementById('lk-body-block-1-skin-1'), {time: 3000, fps: 90}, [
			{css: "opacity", end: "", min: 0, max: 10}
		]);
	};
	
	this.unban = function( server_id ) {
		
		this.alert('Подождите...', 0);
		var _this = this;
		this.req.send_post({
			type: 'unban',
			serverid: server_id
		}, function( json ) {
			
			if ( json.status == 'success' ) {
				
				if ( server_id != -1 ) {
					_this.alert('Вы успешно разбанены на сервере '+ _this.server[server_id][2] +'!', 5000);
				} else _this.alert('Вы успешно разбанены!', 5000);
				
				_this.giveMoney(-json.money);
			} else _this.alert('Ошибка: ' + json.message, 0);
			
		});
	};
	
	this.vaucher = function( vaucher ) {
		
		if ( !vaucher.length )
		{
			this.alert('<b>Ошибка:</b> Введите ваучер!', 3000);
			return 1;
		}
		
		this.alert('Подождите...', 0);
		var _this = this;
		this.req.send_post({
			type: 'vaucher',
			name: vaucher
		}, function( json ) {
			
			if ( json.status == 'success' ) {
				
				_this.alert('Ваучер действителен!<br/>' + json.message, 5000);
				
			} else _this.alert('Ошибка: ' + json.message, 0);
			
		});
	};
	
	this.buyRight = function( id, money ) {
		
		if ( !confirm('Вы действительно хотите приобрести данное право?') ) return 1;
		
		this.alert('Подождите...', 0);
		var _this = this;
		this.req.send_post({
			type: 'buyright',
			right_id: id
		}, function( json ) {
			
			if ( json.status == 'success' ) {
				
				var elem = document.getElementById('lk-rights').children;
				_this.anim.show(elem[id].firstElementChild);
				_this.anim.hide(elem[id].lastElementChild);
				_this.giveMoney(-json.money);
				_this.alert('Вы приобрели данное право!', 5000);
				
			} else _this.alert('Ошибка: ' + json.message, 0);
			
		});
	};
	
	this.skin_update = function( server_id ) {
		var skin = new Array(document.getElementById('lk-body-block-1-skin-1').children, document.getElementById('lk-body-block-1-skin-2').children);
		
		for ( var i = 0; i < 2; i ++ ) {
			for ( var j = 0; j < 2; j ++ ) {
				skin[i][j].src = skin[i][j].src.replace(/server=(\d)/, 'server=' + server_id);
			}
		}	
	};
	
	this.outputServers = function() {
		
		var output = '';
		
		for( var i = 0, Max = this.server.length; i < Max; i ++ )
		{
			output += '<option value="'+ i +'">Сервер '+ this.server[i][2] +'</option>';
		}
		
		return output;
	};
	
	this.time = function() {
		return new Date().getTime();
	};
	
	this.alert_window_key = '';
	this.alert_window_open = function( head, msg, width, height ) {
		
		var alert_w = document.getElementById('lk-body-alert_window');
		
		if ( head != this.alert_window_key ) {
			alert_w.firstElementChild.firstElementChild.innerHTML = head;
			alert_w.lastElementChild.innerHTML = msg;
			alert_w.style.width = width + 'px';
			alert_w.style.height = height + 'px';
			alert_w.style.left = (window.screen.width / 2 - width / 2) + 'px';
			alert_w.style.top = (window.screen.height / 2 - height / 2 - 100) + 'px';
			this.alert_window_key = head;
		}
		
		this.anim.show(alert_w);
		this.anim.show(document.getElementById('alert_bg_dark'));
		this.alert_window = true;
	};
	
	this.alert_window_close = function() {
		
		var alert_w = document.getElementById('lk-body-alert_window');
		
		this.anim.hide(alert_w);
		this.anim.hide(document.getElementById('alert_bg_dark'));
		this.alert_window = false;
	};
	
	this.normalScreen = new Array(0, 0, 0, 0);
	
	this.alert_window_fullscreen = function() {
		
		var alert_w = document.getElementById('lk-body-alert_window');
		
		if ( this.normalScreen[0] == 0 ) {
			this.normalScreen[0] = alert_w.style.left;
			this.normalScreen[1] = alert_w.style.top;
			this.normalScreen[2] = alert_w.style.width;
			this.normalScreen[3] = alert_w.style.height;
			alert_w.style.left = '0px';
			alert_w.style.top = '0px';
			alert_w.style.width = window.screen.width + 'px';
			alert_w.style.height = window.screen.height + 'px';
		} else {
			alert_w.style.left = this.normalScreen[0];
			alert_w.style.top = this.normalScreen[1];
			alert_w.style.width = this.normalScreen[2];
			alert_w.style.height = this.normalScreen[3];
			this.normalScreen[0] = 0;
			this.normalScreen[1] = 0;
			this.normalScreen[2] = 0;
			this.normalScreen[3] = 0;
		}
	};
	
	this.alert_window_text = function(text) {
		
		document.getElementById('lk-body-alert_window').lastElementChild.innerHTML = text;
	};
	
	this.alert_window_addtext = function(text) {
		
		document.getElementById('lk-body-alert_window').lastElementChild.innerHTML += text;
	};
	
	this.alertMove = function(elem) {
		
		var alert = document.getElementById('lk-body-alert_window'), _this = this;
		
		alert.style.opacity = '0.9';
		
		var W = Math.abs(this.MouseCoords.getX(window.event) - alert.offsetLeft), H = Math.abs(this.MouseCoords.getY(window.event) - alert.offsetTop);
		var wW = window.innerWidth
		|| document.documentElement.clientWidth
		|| document.body.clientWidth;
		var hW = window.innerHeight
		|| document.documentElement.clientHeight
		|| document.body.clientHeight;
		
		document.onmousemove = function(e) {
			if (!e) e = window.event;
			
			var X = _this.MouseCoords.getX(e) - W, Y = _this.MouseCoords.getY(e) - H;
			
			if ( X >= 0 && Y >=0 ) {
				if ( X + alert.offsetWidth <= wW && Y + alert.offsetHeight <= hW ) {
					alert.style.left = X + 'px';
					alert.style.top = Y + 'px';
				} else {
					return 1;
				}
			} else {
				return 1;
			}
		}
		
		alert.onmouseup = function() {
			document.onmousemove = null;
			alert.onmouseup = null;
			alert.style.opacity = '1.0';
		}
	};
	
	this.alert_timeout = false;
	
	this.alert = function( msg, time ) {
		var alert = document.getElementById('lk-body-alert');
		
		alert.innerHTML = msg;
		this.anim.animations(alert, {time: 1000, fps: 90}, [
			{css: "opacity", end: "", min: 0, max: 10}
		]);
		
		if ( time > 0 )
		{
			var this_ = this;
			
			clearTimeout(this.alert_timeout);
			
			this.alert_timeout = setTimeout(function() {
				this_.anim.hide(alert);
				clearTimeout(this_.alert_timeout);
				this_.alert_timeout = false;
			}, time);
		}
		
		this.anim.show(alert);
	};
	
	this.dump = function( obj ) {
		var out = "";
		if(obj && typeof(obj) == "object"){
			for (var i in obj) {
				out += i + ": " + obj[i] + "\n";
			}
		} else {
			out = obj;
		}
		alert(out);
	};
};