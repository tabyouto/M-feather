// window.onload = function() {
// 	var obtn = document.getElementById('go-top');
// 	//获取页面可视区的高度
// 	var clientHeight = document.documentElement.clientHeight;
// 	var timer = null;
// 	var isTop = true;

// 	window.onscroll = function() {
// 		var osTop = document.documentElement.scrollTop || document.body.scrollTop;
// 		if(osTop >= clientHeight) {
// 			obtn.style.display = 'block';
// 		} else {
// 			obtn.style.display = 'none';
// 		}
// 		if(!isTop){
// 			clearInterval(timer);
// 		}
// 		isTop = false;
// 	};

// 	obtn.onclick = function() {
// 		timer = setInterval(function() {
// 			var osTop = document.documentElement.scrollTop || document.body.scrollTop;
// 			var ispeed = Math.floor(-osTop/6);
// 			document.documentElement.scrollTop = document.body.scrollTop = osTop +ispeed;
// 			isTop = true;
// 			if(osTop == 0) {
// 				clearInterval(timer);
// 			}
// 		},30);
// 	};
// }

(function($) {
	'use strict';
	
	/*----------------------------------------------------------------------*/
	/* #Post Rating
	/*----------------------------------------------------------------------*/
	var PostRating = (function() {
		var s,
		settings = {
			$els: $('.js-rating'),
			flag: false
		};
		
		/**
		 * 初始化模块
		 */
		var fire = function() {
			s = settings;
			_bindUIActions();
		};
		
		/**
		 * 绑定UI事件
		 */
		var _bindUIActions = function() {
			var cookies = _getCookie("postRating");//获取cookie
			console.log("is_cookie"+cookies);
			if( cookies ) {
				s.$els.each(function(index, el) {
					$.each( cookies, function(index, value) {
						console.log(index+"--"+value+"  index and value");
						console.log($(el).data('post')+"   this is");
						if($(el).data('post') == value) {
							$(el).addClass('is-active');
							return false;
						}
					});
				});
			}

			s.$els.on('click', function(event) {
				event.preventDefault();
				var p = $(this).data('post');
				_ratingPost(p, this);
			});
		}
		
		var _ratingPost = function(p, that) {
			var rated = false,
				cookies = _getCookie("postRating");
			if( s.flag ) {
				return;
			}

			if( cookies ) {
				$.each( cookies, function(index, value) {
					if(p == value) {
						rated = true;
					}
				});
			}

			if( rated ) {
				alert(ajaxcomment.liked_text);
				s.flag = false;
				$(that).addClass('is-active');
				return;
			}

			s.flag = true;
			$.ajax({
				url: ajaxcomment.ajax_url,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'ajax_rating_post',
					post_id: p,
					nonce: ajaxcomment.rating_nonce
				},
			})
			.done(function(res) {
				if( res.status == 1 ) {
					$(that).find('.js-count').text(res.count);
					$(that).addClass('is-active');//wrong
				}
			})
			.always(function() {
				s.flag = false;
			});
			
		}

		var _getCookie = function(key) {
			var c, s, j, cookies;
		    c = document.cookie.split('; ');//分解cookie
		    // console.log(c+"whats this");
		    cookies = {};

		    for( var i = c.length-1; i>=0; i-- ){
		       s = c[i].split('=');
		       // cookies[s[0]] = unescape(s[1]);

		    }
			// console.log(cookies[s[0]]+"   this is array");
			console.log(cookies["hacker"] +"  cookie hacker");
			if( cookies["hacker"] ) {
				// alert(1);
				j = $.parseJSON( cookies['hacker'] );
				if( j[key] )
					return j[key];
				else
					return false;
			} else {
				return false;
			}
		}

		return {
			fire: fire
		}
		
	})();
	PostRating.fire();
	
})(jQuery);

(function() {
	var RelTitle = document.title;
var hidden, visibilityChange; 
if (typeof document.hidden !== "undefined") {
  hidden = "hidden";
  visibilityChange = "visibilitychange";
} else if (typeof document.mozHidden !== "undefined") { // Firefox up to v17
  hidden = "mozHidden";
  visibilityChange = "mozvisibilitychange";
} else if (typeof document.webkitHidden !== "undefined") { // Chrome up to v32, Android up to v4.4, Blackberry up to v10
  hidden = "webkitHidden";
  visibilityChange = "webkitvisibilitychange";
}
function handleVisibilityChange() {
  if (document[hidden]) {
    document.title = ' (●––●) Hi, Tabyouto';
  } else {
    document.title = RelTitle;
  }
}
if (typeof document.addEventListener !== "undefined" || typeof document[hidden] !== "undefined") {
    document.addEventListener(visibilityChange, handleVisibilityChange, false);
}
})();