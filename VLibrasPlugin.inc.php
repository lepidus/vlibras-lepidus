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
		
		if ($hookName != 'TemplateManager::display') return false;
		$templateMgr = $args[0];

		$blockVLibrasTpl = $templateMgr->fetch($this->getTemplateResource('block.tpl'));
		$templateMgr->addHeader('blockVLibrasTpl', $blockVLibrasTpl, $args);

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


