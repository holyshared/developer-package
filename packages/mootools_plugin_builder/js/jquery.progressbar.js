(function($){
	$.fn.progressbar = function(container, options){
	
		this.initialize = function(container, options) {
			this.text = $("<strong/>");
			this.options = options;
			this.container = container;
			this.container.append(this.text);
			var width = $(this.container).css("width").replace("px", "");
			this.maxWidth = parseInt(width);
			this.stepValue = this.maxWidth / 100;
			this.set(0);
		},

		this.set = function(persent) {
			var width = this.stepValue * persent; 
			this.text.html(persent + "% complete");
			if (persent == 100) {
				this.text.addClass("complete");
				this.text.css("background-position", "");
			} else {
				this.text.css("background-position", -(this.maxWidth - width) + "px top");
			}
		}

		this.reset = function() {
			var width = 0;
			this.text.html(0 + "% complete");
			this.text.removeClass("complete");
			this.text.css("background-position", -(this.maxWidth) + "px top");
		}

		this.initialize.apply(this, [container, options]);
		return this;
	};
})(jQuery);