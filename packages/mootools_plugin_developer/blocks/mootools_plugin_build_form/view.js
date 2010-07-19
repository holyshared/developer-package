$(function() {

	var rows = $(".moduleList tbody tr");
	var checkboxs = $(".moduleList tbody tr input[type=checkbox]");

	this.selectDependences = function(classes) {
		$(classes).each(function(key, className) {
			var ele = $("#" + className).get(0);
			var index = $.inArray(ele, checkboxs);	
			$(ele).attr("checked", "checked");
			$(rows[index]).addClass("selected");
		});
	};

	var onCheckboxClick = $.proxy(function(e) {
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

		$(checkboxs[index]).attr("checked", "checked");
		$(checkboxs[index]).trigger("click");
	}, this);
	rows.click(onClick);


});
