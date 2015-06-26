<?php

/**
* Contao Open Source CMS
*  
* @file autoload.php
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.streamswitch
* @copyright Sascha Weidner, Sioweb
*/


ClassLoader::addNamespaces(array(
  'sioweb\contao\extensions\streamswitch'
));

/**
 * Register the classes
 */
ClassLoader::addClasses(array(
  // elements
  'sioweb\contao\extensions\streamswitch\ContentStreams'  => 'system/modules/StreamSwitch/elements/ContentStreams.php',
  // models
  'StreamModel'      => 'system/modules/StreamSwitch/models/StreamModel.php',

));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array(
  'ce_streams'    => 'system/modules/StreamSwitch/templates',
));
