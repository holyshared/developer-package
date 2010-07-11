var GithubTags = {};

GithubTags.Validater = {

	validate: function() {
		var failed = false;

		var formTitle = $('#title');
		if (formTitle.val() == '') {
			alert(ccm_t('title'));
			failed = true;
		}
	
		var downloadFile = $('#repos');
		if (downloadFile.val() == null || downloadFile.val() == '') {
			alert(ccm_t('repos'));
			failed = true;
		}

		var displayCount = $('#displayCount');
		if (displayCount.val() == '') {
			alert(ccm_t('display-count'));
			failed = true;
		}

		if (failed) {
			ccm_isBlockError = 1;
			return false;
		}
		return true;
	}
};

ccmValidateBlockForm = function() { return GithubTags.Validater.validate(); }
