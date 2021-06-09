<?php

import('lib.pkp.classes.plugins.GenericPlugin');

class VLibrasPlugin extends GenericPlugin {

	function register($category, $path, $mainContextId = null) {
		if (parent::register($category, $path, $mainContextId)) {
			HookRegistry::register('TemplateManager::display', array($this, 'loadJsAsyncInHead'));
			HookRegistry::register('Templates::Common::Footer::PageFooter', array($this, 'insertTemplateVLibrasIconInFooter'));
			return true;
		}
		return false;
	}

	function insertTemplateVLibrasIconInFooter($hookName, $args) {
		$request = Application::get()->getRequest();
		$templateMgr = TemplateManager::getManager($request);
		$output =& $args[2];		

		if(!empty($templateMgr->getTemplateVars()['galley']) || !empty($templateMgr->getTemplateVars()['submissionFile'])) return false;

		$VLibrasWidgetTemplate = $templateMgr->fetch($this->getTemplateResource('VLibrasWidget.tpl'));
		$output .= $VLibrasWidgetTemplate;

		return false;
	}

	function loadJsAsyncInHead($hookName, $args) {
		$template =& $args[1];
		$templateMgr =& $args[0];

		if(!empty($templateMgr->getTemplateVars()['galley']) || !empty($templateMgr->getTemplateVars()['submissionFile'])) return false;
		
		$templateMgr->addHeader('addLoadAsync', '<script async src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>' , $args);
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


