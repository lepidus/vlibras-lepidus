<?php

import('lib.pkp.classes.plugins.GenericPlugin');

class VLibrasPlugin extends GenericPlugin {

	function register($category, $path, $mainContextId = null) {
		if (parent::register($category, $path, $mainContextId)) {
			HookRegistry::register('TemplateManager::display', array(&$this, 'insertVLibrasWidget'));
			return true;
		}
		return false;
	}

	function insertVLibrasWidget($hookName, $args) {
		$templateMgr = $args[0];
		$template = $args[1];

		if ($this->templateIsOnIgnoreList($template) ) return false;

		$VLibrasWidgetTemplate = $templateMgr->fetch($this->getTemplateResource('VLibrasWidget.tpl'));
		$templateMgr->addHeader('blockAddVLibras', $VLibrasWidgetTemplate, $args);

		return false;
	}

	function templateIsOnIgnoreList($template){
		$templatesToIgnore = ["plugins-1-plugins-generic-pdfJsViewer-generic-pdfJsViewer:submissionGalley.tpl",
		"plugins-2-plugins-generic-pdfJsViewer-generic-pdfJsViewer:submissionGalley.tpl",
		"plugins-1-plugins-generic-pdfJsViewer-generic-pdfJsViewer:display.tpl"];

		if(in_array($template,$templatesToIgnore)) return true;
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


