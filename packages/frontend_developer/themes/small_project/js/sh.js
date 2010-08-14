$(function() {

	var shRootDir = "/packages/frontend_developer/themes/small_project";
	var shPath = "/js/syntax_highlighter/";

	function path() {
		var args = arguments, result = [];
		for (var i = 0; i < args.length; i++) {
			result.push(args[i].replace('@', shRootDir + shPath));
		}
		return result
	};


	SyntaxHighlighter.autoloader.apply(null, path(
		"bash					@shBrushBash.js",
		"css					@shBrushCss.js",
		"diff                   @shBrushDiff.js",
		"html xml xhtml         @shBrushXml.js",
		"js jscript javascript  @shBrushJScript.js",
		"perl pl                @shBrushPerl.js",
		"plain                  @shBrushPlain.js",
		"python py              @shBrushPython.js",
		"sql                    @shBrushSql.js",
		"tt tt2                 @shBrushTT2.js",
		"yaml yml               @shBrushYAML.js"
	));
	SyntaxHighlighter.all();

});
