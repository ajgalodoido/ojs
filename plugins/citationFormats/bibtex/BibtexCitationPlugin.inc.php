<?php

/**
 * @file plugins/citationFormats/bibtex/BibtexCitationPlugin.inc.php
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2003-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class BibtexCitationPlugin
 * @ingroup plugins_citationFormats_bibtex
 *
 * @brief BibTeX citation format plugin
 */

import('classes.plugins.CitationPlugin');

class BibtexCitationPlugin extends CitationPlugin {
	function register($category, $path) {
		$success = parent::register($category, $path);
		$this->addLocaleData();
		return $success;
	}

	/**
	 * Get the name of this plugin. The name must be unique within
	 * its category.
	 * @return String name of plugin
	 */
	function getName() {
		return 'BibtexCitationPlugin';
	}

	function getDisplayName() {
		return __('plugins.citationFormats.bibtex.displayName');
	}

	function getCitationFormatName() {
		return __('plugins.citationFormats.bibtex.citationFormatName');
	}

	function getDescription() {
		return __('plugins.citationFormats.bibtex.description');
	}

	/**
	 * Return an HTML-formatted citation. Default implementation displays
	 * an HTML-based citation using the citation.tpl template in the plugin
	 * path.
	 * @param $article object
	 * @param $issue object
	 */
	function fetchCitation($article, $issue, $journal) {
		$templateMgr = TemplateManager::getManager($this->getRequest());
		$templateMgr->register_modifier('bibtex_escape', array($this, 'bibtexEscape'));
		return parent::fetchCitation($article, $issue, $journal);
	}

	/**
	 * @function bibtex_escape Escape strings for inclusion in BibTeX cites
	 * @param $arg string
	 * @return string
	 */
	function bibtexEscape($arg) {
		return htmlspecialchars($returner = str_replace(
			array('{', '}', '$','"', '&apos;'),
			array('\\{', '\\}', '\\$', '\\"', '\''),
			html_entity_decode($arg, ENT_QUOTES, 'UTF-8')
		));
	}
}

?>
