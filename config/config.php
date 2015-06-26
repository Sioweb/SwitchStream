<?php

/**
* Contao Open Source CMS
*  
* @file config.php
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.streamswitch
* @copyright Sascha Weidner, Sioweb
*/

if(TL_MODE == 'FE')
	$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/StreamSwitch/assets/streamswitch.min.js';

array_insert($GLOBALS['BE_MOD']['sioweb'], 4, array(
	'stream' => array(
		'tables' => array('tl_stream'),
		'icon' => 'system/modules/StreamSwitch/assets/sioweb16x16.png'
	)
));

$GLOBALS['TL_CTE']['media']['stream_player'] = 'ContentStreams';

if(Input::get('stream_mastertime') == 1) {
  echo json_encode(array('mastertime'=>time()));
  die();
}