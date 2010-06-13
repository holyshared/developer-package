(function($){

	$.fn.importWizard = function(container, options){
	
		this.initialize = function(container, options){
			this.options = options;
			this.container = container;
			this.current = 1;
			$(this.container).bind('progress', this.options.progress);
		},
		
		this.start = function(){
			this.send();
		},
		
		this.success = function(json, statusText, xhr, form){
alert(json);
			if (this.current < this.options.step + 1) {
				var response = json.response;
				if (response.status) {
					$(this.container).trigger('progress', [this.current]);

					var prevAction = "step" + this.current.toString();
					var nextAction = "step" + this.next().toString();
					var action = $(this.container).attr("action").replace(prevAction, nextAction);
					$(this.container).attr("action", action);
					
					$(".stepParameter").remove();
					var parameters = response.parameters;
					for (var name in parameters) {
						var input = $("<input/>").attr("type", "hidden").attr("name", name).attr("value", parameters[name]).attr("class", "stepParameter");
						$(this.container).append(input);
					}
					this.send();
				}
				$("#message").html(response.message);
			}
		},
		
		this.send = function(){
			var self = this;
			var options = {
				"url": $(this.container).attr("action"),
				"dataType": "json",
				"success": function(){
					self.success.apply(self, arguments);
				}
			};
			$(this.container).ajaxForm(options);
			$(this.container).trigger("submit");
		}
		
		this.next = function(){
			this.current++;
			return this.current;
		}
		
		this.initialize.apply(this, [container, options]);
		
		return this;
	};
	
})(jQuery);