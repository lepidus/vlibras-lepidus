<?php

import('lib.pkp.classes.plugins.GenericPlugin');

class VLibrasPlugin extends GenericPlugin {

	function register($category, $path, $mainContextId = null) {
		if (parent::register($category, $path, $mainContextId)) {
			HookRegistry::register('TemplateManager::display', array(&$this, 'callbackTemplateDisplay'));
			return true;
		}
		return false;
	}

	function callbackTemplateDisplay($hookName, $args) {
		$templateMgr = $args[0];
		$template = $args[1];

		if ($hookName != 'TemplateManager::display' || $this->filterTemplatesToOmit($template) ) return false;

		$blockVLibrasTpl = $templateMgr->fetch($this->getTemplateResource('block.tpl'));
		$templateMgr->addHeader('blockVLibrasTpl', $blockVLibrasTpl, $args);

		return false;
	}

	function filterTemplatesToOmit($template){
		$templatesDiscarted = "pdfJsViewer:submissionGalley.tpl";
		$templateDiscartedOMP = "pdfJsViewer:display.tpl";

		if(strpos($template,$templatesDiscarted) || strpos($template,$templateDiscartedOMP)) return true;

		return false;		
	}

	/**
	 * Install default settings on system install.
	 * @return string
	 */
	function getInstallSitePluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}

	/**
	 * Install default settings on journal creation.
	 * @return string
	 */
	function getContextSpecificPluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}

	/**
	 * Get the display name of this plugin.
	 * @return String
	 */
	function getDisplayName() {
		return __('plugins.generic.vlibras.displayName');
	}

	/**
	 * Get a description of the plugin.
	 */
	function getDescription() {
		return __('plugins.generic.vlibras.description');
	}
}


