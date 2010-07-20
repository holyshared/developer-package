$(function() {

	var rows = $(".moduleList tbody tr");
	var checkboxs = $(".moduleList tbody tr input[type=checkbox]");

	this.selectDependences = function(classes) {
		$(classes).each(function(key, className) {
			var ele = $("#" + className).get(0);
			if (!$(ele).attr("checked")) {
				var index = $.inArray(ele, checkboxs);	
				var row = rows[index];	
				$(ele).attr("checked", "checked");
				$(row).addClass("selected");
			}
		});
	};

	var onCheckboxClick = $.proxy(function(e) {
		e.preventDefault();
		var checkbox = e.target;
		var index = $.inArray(checkbox, checkboxs);	
		if ($(checkbox).attr("checked")) {
			$(rows[index]).addClass("selected");
			var classes = $(checkbox).attr("class");
			classes = classes.split(" ");
			this.selectDependences(classes);
		} else {
			$(rows[index]).removeClass("selected");
		}
	}, this);
	checkboxs.click(onCheckboxClick);

	var onClick = $.proxy(function(e) {
		var row = $(e.target).parent().get(0);
		var index = $.inArray(row, rows);
		$(row).addClass("selected");
		var checkbox = checkboxs[index];
		$(checkbox).attr("checked", "checked");
		$(checkbox).trigger("click");
	}, this);
	rows.click(onClick);

});
