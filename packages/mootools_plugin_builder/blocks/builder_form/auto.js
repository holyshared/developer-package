var PluginPackage = {};
PluginPackage.PackageList = {

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
PluginPackage.PackageList.initialize.apply(PluginPackage.PackageList, [$("#packageList")]);


PluginPackage.Validater = {

	validate: function() {
		var failed = false;

		var formTitle = $('#title');
		if (formTitle.val() == undefined || formTitle.val() == '') {
			alert(ccm_t('form-title'));
			failed = true;
		}
	
		var downloadFile = $('#javascript');
		if (downloadFile.val() == undefined || downloadFile.val() == '') {
			alert(ccm_t('download-file'));
			failed = true;
		}

		if (failed) {
			ccm_isBlockError = 1;
			return false;
		}
		return true;
	}
};

ccmValidateBlockForm = function() { return PluginPackage.Validater.validate(); }