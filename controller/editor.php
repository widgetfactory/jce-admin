<?php

/**
 * @package   	JCE
 * @copyright 	Copyright (c) 2009-2012 Ryan Demmer. All rights reserved.
 * @license   	GNU/GPL 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
defined('_JEXEC') or die('RESTRICTED');

wfimport('admin.classes.controller');
wfimport('admin.classes.error');
wfimport('admin.helpers.xml');
wfimport('admin.helpers.extension');

class WFControllerEditor extends WFControllerBase {

    public function execute($task) {
        // Load language
        $language = JFactory::getLanguage();
        $language->load('com_jce', JPATH_ADMINISTRATOR);

        $layout = JRequest::getCmd('layout');
        $plugin = JRequest::getCmd('plugin');

        if ($layout) {
            switch ($layout) {
                case 'editor':
                    if ($task == 'pack' || $task == 'loadlanguages') {
                        jimport('joomla.application.component.model');

                        require_once(WF_EDITOR_CLASSES . '/editor.php');

                        wfimport('admin.models.editor');
                        $model = new WFModelEditor();

                        if ($task == 'loadlanguages') {
                            if (method_exists($model, 'loadLanguages')) {
                                $model->loadLanguages(array(), array(), '(^dlg$|_dlg$)', true);
                            }
                        } else {
                            $model->pack();
                        }
                    }

                    break;
                case 'theme':
                    $theme = JRequest::getWord('theme');

                    if ($theme && is_dir(WF_EDITOR_THEMES . '/' . $theme)) {
                        require_once(WF_EDITOR_THEMES . '/' . $theme . '/theme.php');
                    } else {
                        throw new InvalidArgumentException('Theme not found!');
                    }

                    break;
                case 'plugin':
                    $file = basename(JRequest::getCmd('file', $plugin));
                    $path = WF_EDITOR_PLUGINS . '/' . $plugin;

                    if (is_dir($path) && file_exists($path . '/' . $file . '.php')) {                        
                        include_once($path . '/' . $file . '.php');
                    } else {
                        throw new InvalidArgumentException('File ' . $file . ' not found!');
                    }

                    break;
            }
            exit();
        } else {
            throw new InvalidArgumentException('No Layout');
        }
    }

}

?>