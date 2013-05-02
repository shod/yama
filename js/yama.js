var YamaBy = YamaBy || {};

/**
 * Adds all missing properties from second obj to first obj
 */
YamaBy.extend = function(first, second){
    for (var prop in second){
        first[prop] = second[prop];
    }
};

YamaBy.index = {
	init: function(o){
		
		History.debug.enable = true;
		
		this._openedModals = [] // ids of modals that now are open
		this._urls = []
		this._options = {
			contentBlockSelector: '.list',
			searchField: '#searchYama'
		};
		
		YamaBy.extend(this._options, o)
		
		
		
		window.onpopstate = function(e){
			var State = History.getState()
			if(e.state){
				for(k in YamaBy.index._openedModals){
					$("#"+YamaBy.index._openedModals[k]).dialog("close")
				}
				
				if($(State.data.selector).length == 0){
					window.location = window.location.href
				}
				$(State.data.selector).empty().append(State.data.html)
				
				if(State.data.selector == '.b-market__middle-i'){
					$('.b-market__middle-i').masonry('reload')
				}
				
				if(State.data.modal){
					for(k in State.data.modal){
						if($.inArray(State.data.modal[k], YamaBy.index._openedModals) == -1){
							$("#"+State.data.modal[k]).dialog("open")
						}
					}
				}
				if(State.data.q !== null){
					$(YamaBy.index._options.searchField).attr('value', State.data.q)
				}
				YamaBy.index._openedModals = State.data.modal
			}
		};

		for(var i in this._options.modals){
			this.addModals(this._options.modals[i])
		}
		var url = window.location.origin + window.location.pathname
		var resultAfterParse = this.parseUrl(window.location.search);
		var q = ''
		if(resultAfterParse.q){
			q = decodeURIComponent(resultAfterParse.q)
			url = url + '?q=' + q
		}
		History.replaceState({"html":$(YamaBy.index._options.contentBlockSelector).html(), 'selector': YamaBy.index._options.contentBlockSelector, 'q': q, 'url': url, 'modal': YamaBy.index._openedModals}, '', url)
		/*
		$("#loading").bind("ajaxSend", function(){
			$(this).show();
		}).bind("ajaxComplete", function(){
			$(this).hide();
		});
		*/
	},
	closeModal: function(param, modalId){
		k = jQuery.inArray(modalId, YamaBy.index._openedModals)
		if(k != -1){
			delete YamaBy.index._openedModals[k]
		}
		url = '/'
		if(this._urls[this._urls.length-2]){
			url = this._urls[this._urls.length-2]
		}
		YamaBy.index.addToHistory({'html': jQuery(YamaBy.index._options.contentBlockSelector).html(), 'selector': YamaBy.index._options.contentBlockSelector, 'modal': YamaBy.index._openedModals}, url)
	},
	addModals: function(o){
		jQuery(document).on('click', o.selector, function(){
			url = this.href
			YamaBy.index.getBlock(this.href, function(data){
				$("#"+o.id).dialog("open")
				k = jQuery.inArray(o.id, YamaBy.index._openedModals)
				if(k == -1){
					YamaBy.index._openedModals[YamaBy.index._openedModals.length] = o.id
				}
				response = jQuery.parseJSON(data)
				response.modal = YamaBy.index._openedModals
				YamaBy.index.addToHistory(response, url)
			})
			return false;
		})
	},
	search: function(url, string, offset){
		if(string.length > 0){
			url = url + '/?q=' + string
			if(offset){
				url = url + '&offset=' + offset
			}
		} else if(offset){
			url = url + '/?offset=' + offset
		}
		
		YamaBy.index.getBlock(url, function(data){
			response = jQuery.parseJSON(data)
			if(response.else){
				$('.more-items-btn').show();
			} else {
				$('.more-items-btn').hide();
			}
			YamaBy.index.addToHistory(response, url)
		})
	},
	moreItems: function(url, string, offset){
		if(string.length > 0){
			url = url + '/?q=' + string
			if(offset){
				url = url + '&offset=' + offset
			}
		} else if(offset){
			url = url + '/?offset=' + offset
		}
		
		YamaBy.index.appendToBlock(url, function(data){
			response = jQuery.parseJSON(data)
			if(response.else){
				$('.more-items-btn').show();
			} else {
				$('.more-items-btn').hide();
			}
		})
	},
	appendToBlock: function(url, successFunction){
		$.get(url, function(data){
			response = jQuery.parseJSON(data)
			$(response.selector).append(response.html)
			if(response.selector == '.b-market__middle-i'){
				$('.b-market__middle-i').masonry('reload')
			}
		})
		.done(successFunction)
	},
	getBlock: function(url, successFunction){
		$.get(url, function(data){
			response = jQuery.parseJSON(data)
			YamaBy.index.changeContent(response.selector, response.html)
		})
		.done(successFunction)
	},
	changeContent: function(selector, html){
		$(selector).html(html)
		if(selector == '.b-market__middle-i'){
			$('.b-market__middle-i').masonry('reload')
		}
	},
	addToHistory: function(response, url){
		this._urls[this._urls.length] = url;
		title = ''

		if(response.title){
			title = response.title
		}
		response.q = $(YamaBy.index._options.searchField).attr('value')
		History.pushState(response, title, url)
	},
	createUrl: function(params){
		var ret = [];
		for (var d in params)
			ret.push(encodeURIComponent(d) + "=" + encodeURIComponent(params[d]))
		url = ret.join("&")
		if(!url.length){
			url = "/" + url;
		}
		
	    return url
	},
	parseUrl: function(url){

		var query_string = {};
		var query = url;
		var vars = query.split("&");
		for (var i=0;i<vars.length;i++) {
			vars[i] = vars[i].replace(/^\?/, '')
			var pair = vars[i].split("=");
				// If first entry with this name
			if (typeof query_string[pair[0]] === "undefined") {
			  query_string[pair[0]] = pair[1];
				// If second entry with this name
			} else if (typeof query_string[pair[0]] === "string") {
			  var arr = [ query_string[pair[0]], pair[1] ];
			  query_string[pair[0]] = arr;
			  // If third or later entry with this name
			} else {
				query_string[pair[0]].push(pair[1]);
			}
		}
		return query_string;
	}
}