<?php

/**
 * Contao Open Source CMS
 */

/**
 * @file tl_content.php
 * @author Sascha Weidner
 * @version 3.0.0
 * @package sioweb.contao.extensions.streamswitch
 * @copyright Sascha Weidner, Sioweb
 */

if(empty($GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback']))
  $GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'] = array();
$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = array('tl_stream_content', 'adjustTime');

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'mainstream';
$GLOBALS['TL_DCA']['tl_content']['palettes']['stream_player'] = '{type_legend},type,autoplay_stream,random_stream,mainstream';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['mainstream'] = 'fromTime,toTime';

$GLOBALS['TL_DCA']['tl_content']['fields']['autoplay_stream'] = array(
  'label'       => &$GLOBALS['TL_LANG']['tl_content']['autoplay_stream'],
  'exclude'     => true,
  'inputType'   => 'checkbox',
  'sql'         => "char(1) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['random_stream'] = array(
  'label'       => &$GLOBALS['TL_LANG']['tl_content']['random_stream'],
  'exclude'     => true,
  'inputType'   => 'checkbox',
  'sql'         => "char(1) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['mainstream'] = array(
  'label'       => &$GLOBALS['TL_LANG']['tl_content']['mainstream'],
  'exclude'     => true,
  'inputType'   => 'checkbox',
  'eval'        => array('submitOnChange'=>true),
  'sql'         => "char(1) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['fromTime'] = array(
  'label'       => &$GLOBALS['TL_LANG']['tl_content']['fromTime'],
  'default'     => '0',
  'exclude'     => true,
  'inputType'   => 'text',
  'eval'        => array('rgxp'=>'time', 'doNotCopy'=>true, 'tl_class'=>'w50'),
  'sql'         => "int(10) unsigned NOT NULL default '0'"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['toTime'] = array(
  'label'       => &$GLOBALS['TL_LANG']['tl_content']['toTime'],
  'exclude'     => true,
  'inputType'   => 'text',
  'eval'        => array('rgxp'=>'time', 'doNotCopy'=>true, 'tl_class'=>'w50'),
  'sql'         => "int(10) unsigned NOT NULL default '0'"
);

class tl_stream_content extends Backend {

  /**
   * Import the back end user object
   */
  public function __construct()
  {
    parent::__construct();
    $this->import('BackendUser', 'User');
  }

  /**
   * Adjust start end end time of the event based on date, span, startTime and endTime
   *
   * @param DataContainer $dc
   */
  public function adjustTime(DataContainer $dc)
  {
    // Return if there is no active record (override all)
    if (!$dc->activeRecord)
    {
      return;
    }

    $arrSet['fromTime'] = strtotime(date('H:i', $dc->activeRecord->fromTime));
    $arrSet['toTime'] = strtotime(date('H:i', $dc->activeRecord->toTime));

    $this->Database->prepare("UPDATE tl_content %s WHERE id=?")->set($arrSet)->execute($dc->id);
  }
}