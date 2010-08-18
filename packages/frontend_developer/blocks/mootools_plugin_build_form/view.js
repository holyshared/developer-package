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
		e.stopPropagation();
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
		e.preventDefault();
		var row = $(e.target).parent().get(0);
		var index = $.inArray(row, rows);
		var checkbox = checkboxs[index];
		if ($(row).hasClass("selected")) {
			$(row).removeClass("selected");
			$(checkbox).attr("checked", "");
		} else {
			$(row).addClass("selected");
			$(checkbox).attr("checked", "checked");
			var classes = $(checkbox).attr("class");
			classes = classes.split(" ");
			this.selectDependences(classes);
		}
	}, this);
	rows.click(onClick);

});
