$(function() {

	

	var PackageList = {
	
		initialize: function(list) {
			this.list = list;
		},
		
		add: function(key, value) {
			var li = $("<li/>").attr("id", "package-" + key);
			var strong = $("<strong/>").html(value);
			li.append(strong);
			this.list.append(li);
		},

		remove: function(row){
		}
		
	};

	this.PackageSelecter = {
	
		initialize: function(pulldown, button){
			this.pulldown = pulldown;
			this.button = button;
			this.items = $(this.pulldown).children('option');
			$(this.button).click($.proxy(this.addPackage, this));
		},

		addPackage: function(event) {
			event.preventDefault();
			var item = $(this.pulldown).val();
			$.proxy(PackageList.add, PackageList)(item, PluginPackages[item]);
		}
	};
	PackageList.initialize.apply(PackageList, [$("#packageList")]);
	this.PackageSelecter.initialize.apply(this.PackageSelecter, [$("#package"), $("#addFileset")]);
	
});
