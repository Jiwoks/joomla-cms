<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_cpanel
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * HTML View class for the Cpanel component
 *
 * @package     Joomla.Administrator
 * @subpackage  com_cpanel
 * @since       1.0
 */
class CpanelViewCpanel extends JViewLegacy
{
	protected $modules = null;

	public function display($tpl = null)
	{
		// Set toolbar items for the page
		JToolbarHelper::title(JText::_('COM_CPANEL'), 'cpanel.png');
		JToolbarHelper::help('screen.cpanel');

		$input = JFactory::getApplication()->input;

		/*
		 * Set the template - this will display cpanel.php
		 * from the selected admin template.
		 */
		$input->set('tmpl', 'cpanel');

		// Display the cpanel modules
		$this->modules = JModuleHelper::getModules('cpanel');

		// Load the RAD layer and count the number of post-installation messages
		if (!defined('FOF_INCLUDED'))
		{
			require_once JPATH_LIBRARIES . '/fof/include.php';
		}

		$messages_model = FOFModel::getTmpInstance('Messages', 'PostinstallModel',
			array('input'=> array('eid'	=> 700,))
		);
		$messages = $messages_model->getItemList();

		$this->postinstall_message_count = count($messages);

		if ($this->postinstall_message_count)
		{
			$js = <<< ENDJS
jQuery(document).ready(function(){
	jQuery('#messagesModal').modal({
		backdrop: true,
		keyboard: true,
		show: true
	});
});
ENDJS;

			JFactory::getDocument()->addScriptDeclaration($js);
		}

		parent::display($tpl);
	}
}
