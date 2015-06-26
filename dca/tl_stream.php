<?php

/**
* Contao Open Source CMS
*  
* @file tl_stream.php
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.streamswitch
* @copyright Sascha Weidner, Sioweb
*/

/**
 * Table tl_stream 
 */
$GLOBALS['TL_DCA']['tl_stream'] = array
(
  // Config
  'config' => array(
    'dataContainer'       => 'Table',
    'enableVersioning'    => true,
    'sql' => array (
      'keys' => array(
        'id' => 'primary'
      )
    ),
    'onsubmit_callback' => array(
      array('tl_stream', 'adjustTime'),
    ),
  ),

  // List
    'list' => array(
    'sorting' => array
    (
      'mode'      => 1,
      'fields'    => array('tstamp'),
      'flag'      => 6,
      'panelLayout'     => 'sort,filter;search,limit',
    ),
    'label' => array(
      'fields'      => array('title', 'streamurl'),
      'format'      => '%s<span style="color:#b3b3b3; padding-left:3px;">[%s]</span>'
    ),
    'global_operations' => array
    (
      'all' => array(
        'label'       => &$GLOBALS['TL_LANG']['MSC']['all'],
        'href'        => 'act=select',
        'class'       => 'header_edit_all',
        'attributes'  => 'onclick="Backend.getScrollOffset();" accesskey="e"'
      )
    ),
    'operations' => array(
      'edit' => array(
        'label'       => &$GLOBALS['TL_LANG']['tl_stream']['edit'],
        'href'        => 'act=edit',
        'icon'        => 'edit.gif'
      ),
      'delete' => array(
        'label'       => &$GLOBALS['TL_LANG']['tl_stream']['delete'],
        'href'        => 'act=delete',
        'icon'        => 'delete.gif',
        'attributes'  => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
      ),
      'show' => array(
        'label'       => &$GLOBALS['TL_LANG']['tl_stream']['show'],
        'href'        => 'act=show',
        'icon'        => 'show.gif'
      )
    )
  ),

  // Palettes
  'palettes' => array(
    '__selector__'    => array('timelimit'),
    'default'         => '{title_legend},title,streamurl,fallback,permanent;{time_legend},timelimit'
  ),
  'subpalettes' => array(
    'timelimit' => 'fromTime,toTime',
  ),


  // Fields
  'fields' => array(
    'id' => array(
      'sql'       => "int(10) unsigned NOT NULL auto_increment"
    ),
    'sorting' => array(
      'sql'       => "int(10) unsigned NOT NULL default '0'"
    ),
    'tstamp' => array(
      'sql'       => "int(10) unsigned NOT NULL default '0'"
    ),
    'title' => array(
      'label'       => &$GLOBALS['TL_LANG']['tl_stream']['title'],
      'exclude'     => true,
      'inputType'   => 'text',
      'eval'        => array('mandatory'=>true,'maxlength'=>255,'tl_class'=>'w50 clr'),
      'sql'         => "varchar(255) NOT NULL default ''"
    ),
    'streamurl' => array(
      'label'       => &$GLOBALS['TL_LANG']['tl_stream']['streamurl'],
      'exclude'     => true,
      'inputType'   => 'text',
      'eval'        => array('mandatory'=>true,'maxlength'=>255,'tl_class'=>'w50 clr'),
      'sql'         => "varchar(255) NOT NULL default ''"
    ),
    'fallback' => array(
      'label'       => &$GLOBALS['TL_LANG']['tl_stream']['fallback'],
      'exclude'     => true,
      'inputType'   => 'checkbox',
      'eval'        => array('tl_class'=>'clr'),
      'sql'         => "char(1) NOT NULL default ''"
    ),
    'permanent' => array(
      'label'       => &$GLOBALS['TL_LANG']['tl_stream']['permanent'],
      'exclude'     => true,
      'inputType'   => 'checkbox',
      'eval'        => array('tl_class'=>'clr'),
      'sql'         => "char(1) NOT NULL default ''"
    ),
    'timelimit' => array(
      'label'       => &$GLOBALS['TL_LANG']['tl_stream']['timelimit'],
      'exclude'     => true,
      'inputType'   => 'checkbox',
      'eval'        => array('submitOnChange'=>true),
      'sql'         => "char(1) NOT NULL default ''",
    ),
    'fromTime' => array
    (
      'label'       => &$GLOBALS['TL_LANG']['tl_stream']['fromTime'],
      'default'     => '0',
      'exclude'     => true,
      'inputType'   => 'text',
      'eval'        => array('rgxp'=>'time', 'doNotCopy'=>true, 'tl_class'=>'w50'),
      'sql'         => "int(10) unsigned NOT NULL default '0'"
    ),
    'toTime' => array
    (
      'label'       => &$GLOBALS['TL_LANG']['tl_stream']['toTime'],
      'exclude'     => true,
      'inputType'   => 'text',
      'eval'        => array('rgxp'=>'time', 'doNotCopy'=>true, 'tl_class'=>'w50'),
      'sql'         => "int(10) unsigned NOT NULL default '0'"
    ),
  )
);

class tl_stream extends Backend {

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

    $this->Database->prepare("UPDATE tl_stream %s WHERE id=?")->set($arrSet)->execute($dc->id);
  }
}