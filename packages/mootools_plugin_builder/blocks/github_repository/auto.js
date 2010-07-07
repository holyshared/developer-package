var GithubRepository = {};

GithubRepository.Validater = {

	validate: function() {
		var failed = false;

		var formTitle = $('#title');
		if (formTitle.val() == null || formTitle.val() == '') {
			alert(ccm_t('title'));
			failed = true;
		}

		var repository = $('#repos');
		if (repository.val() == null || repository.val() == '') {
			alert(ccm_t('repos'));
			failed = true;
		}

		if (failed) {
			ccm_isBlockError = 1;
			return false;
		}
		return true;
	}
};

ccmValidateBlockForm = function() { return GithubRepository.Validater.validate(); }
