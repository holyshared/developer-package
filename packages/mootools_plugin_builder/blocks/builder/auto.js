$(function() {

	var PackageList = {
		initialize: function(list) {
			this.list = list;
			$(this.list).sortable({
				start: $.proxy(this.start, this),
				stop: $.proxy(this.stop, this)
			});
			$(this.list).disableSelection();
			this.lists = $(this.list).find('li a');
			$(this.lists).mouseup($.proxy(this.remove, this));
		},

		remove: function(event) {
			event.preventDefault();
			if (this.isDraging) return true;

			var a = $(event.target);
			var href = $(a).attr("href");
			var index = href.substr(href.indexOf("#") + 1);
			var li = $(this.list).find(".r" + index);
			$(li).toggleClass("selected");

			var p = $(this.list).find(".r" + index + " input");
			if ($(p).attr("disabled")) {
				$(p).attr("disabled", "")
			} else {
				$(p).attr("disabled", "disabled");
			}
		},

		start: function(event, ui) { this.isDraging = true; },
		stop: function(event, ui) { this.isDraging = false; }
	};
	PackageList.initialize.apply(PackageList, [$("#packageList")]);

});
