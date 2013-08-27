
// Visualizer
$.visualizer = {

	settings : {
		increaser : 80,
		show_delay_speed : 40,
		rotate_interval_delay : 4000
	},

	sections : $('.main-container .main section'),

	sections_total : function() {
		return this.sections.length;
	},

	layout : function () {
		var input = this.sections_total();
		output = new Array(input, 1);
		for ( var i = input; i>0; i-- ) {
			var res = input%i;
			var div = input/i;
			if (res == 0) {
				if (i >= div) {
					output[0] = i;		// rows
					output[1] = div; 	// columns
				}
			}
		}
		return output;
	},

	rows : function() { return this.layout()[0]; },
	columns : function() { return this.layout()[1]; },

	column_width : function() { return Math.floor(100/this.columns()); },
	column_adjust : function() { return 100-(this.column_width()*this.columns()); },

	row_height : function() { return Math.floor(100/this.rows()); },
	row_adjust : function() { return 100-(this.row_height()*this.rows()); },

	restore_layout : function() {
		
		$('.main-container .main article').css('width', this.column_width()+'%');
		$('.main-container .main article:last-child').css('width', (this.column_width()+this.column_adjust())+'%');

		this.sections.css('height', this.row_height()+'%').removeClass('big-section');
		$('.main-container .main article section:last-child').css('height', (this.row_height()+this.row_adjust())+'%');

	},

	highlight : function(element, increaser, columns, rows) {

		var small_column_width = (columns-1 > 0) ? Math.floor((100-increaser)/(columns-1)) : 100;
		var big_column_width = (columns-1 > 0) ? 100 - (small_column_width*(columns-1)) : 100;
		$('.main-container .main article').css('width', small_column_width+'%');
		$(element).parent().css('width', big_column_width+'%');

		var small_row_height = Math.floor( (100-increaser)/(rows-1) );
		var big_row_height = 100 - (small_row_height*(rows-1));

		small_row_height = ( small_row_height<=0 ) ? 1 : small_row_height;
		big_row_height = ( big_row_height>=100 ) ? increaser : big_row_height;

		$(element).siblings().css('height', small_row_height+'%');
		$(element).css('height', big_row_height+'%').addClass('big-section');
	},

	items_shuffled : function() {

		var item_num = new Array();
		for ( var i=0; i<this.sections_total(); i++ ) {
			item_num[i] = i;
		}
		var randomize = function(arr) {
			for(var j, x, i = arr.length; i; j = parseInt(Math.random() * i), x = arr[--i], arr[i] = arr[j], arr[j] = x);
			return arr;
		};

		return randomize(item_num);

	},

	construct : function() {
		this.sections.hide();
		var t = this.sections_total();
		var r = this.rows();
		var s = this.sections;
		for(var i = 0; i < t; i+=r) {
			s.slice(i, i+r).wrapAll("<article />");
		}
		this.restore_layout();
		
		var delayer = this.settings.show_delay_speed;
		var last_item = this.sections_total()-1;

		var callback = this.highlight;
		var increaser = this.settings.increaser;
		var columns = this.columns();
		var rows = this.rows();

		var random_first = Math.floor((Math.random()*this.sections_total()));
		var starting_element = this.sections[random_first];

		var restore = this.restore_layout;

		this.sections.each(function(i) {
			$(this).delay(i*delayer).fadeIn(function(){
				if (i == last_item) { 
					callback(starting_element, increaser, columns, rows);
					$.visualizer.rotate();
				}
			});	

			$(this).click(function() {
				$.visualizer.restore_layout();
				$.visualizer.highlight(this, increaser, columns, rows);
				if (!!$.visualizer.refreshId) {
					clearInterval($.visualizer.refreshId);					
				}
			});
		});		

	},

	rotate : function() {
		var item_count = 0;
		var item_total = this.sections_total();
		var sections = this.sections;
		var increaser = this.settings.increaser;
		var columns = this.columns();
		var rows = this.rows();
		var shuffled_items = this.items_shuffled();

		this.refreshId = setInterval(function() {

			$.visualizer.restore_layout();
			$.visualizer.highlight(sections[shuffled_items[item_count]], increaser, columns, rows);			
			item_count++;
			if (item_count >= item_total) { item_count = 0; }

		}, this.settings.rotate_interval_delay);
	},

	init : function() {
		this.construct();
	}

};

// Sharer
var sharer = function(sharrre_curl) {

	$('#twitter').sharrre({
		share: {
			twitter: true
		},
		enableHover: false,
		enableTracking: true,
		buttons: { twitter: {via: 'alterebro'}},
		click: function(api, options){
			api.simulateClick();
			api.openPopup('twitter');
		}
	});
	$('#facebook').sharrre({
		share: {
			facebook: true
		},
		enableHover: false,
		enableTracking: true,
		click: function(api, options){
			api.simulateClick();
			api.openPopup('facebook');
		}
	});
	$('#googleplus').sharrre({
		share: {
			googlePlus: true
		},
		enableHover: false,
		enableTracking: true,
		urlCurl: sharrre_curl,
		click: function(api, options){
			api.simulateClick();
			api.openPopup('googlePlus');
		}
	});
	$('#stumbleupon').sharrre({
		share: {
			stumbleupon: true
		},
		enableHover: false,
		enableTracking: true,
		urlCurl: sharrre_curl,
		click: function(api, options){
			api.simulateClick();
			api.openPopup('stumbleupon');
		}
	});
}

