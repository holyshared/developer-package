$(function() {

	this.selectDependences = function(checkbox) {
		var classes = $(checkbox).attr("class");
		classes = classes.split(" ");
		$(classes).each(function(key, className) {
			var ele = $("#" + className);
			$(ele).attr("checked", "checked");
			var row = $(ele).parent("tr").get().shift();
			$(checkbox).attr("checked", "checked");
		});
	};

	var rows = $(".moduleList tbody tr");
	var checkboxs = $(".moduleList tbody tr input[type=checkbox]");
	var selt = this;

	var onClick = $.proxy(function(e) {
		var row = $(e.target).parent("tr").get().shift();
		$(row).toggleClass("selected");
		var index = $.inArray(row, rows);
		var checkbox = checkboxs[index];

		if ($(checkbox).attr("checked")) {
			$(checkbox).attr("checked", "");
		} else {
			$(checkbox).attr("checked", "checked");
			this.selectDependences(checkbox);
		}

	}, this);

	rows.click(onClick);

});
