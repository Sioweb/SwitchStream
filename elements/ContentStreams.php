<?php

/**
 * Contao Open Source CMS
 */

namespace sioweb\contao\extensions\streamswitch;
use Contao;

/**
 * @file ContentStreams.php
 * @class ContentStreams
 * @author Sascha Weidner
 * @version 3.0.0
 * @package sioweb.contao.extensions.streamswitch
 * @copyright Sascha Weidner, Sioweb
 */


class ContentStreams extends \ContentElement {
  
  /**
   * Template
   * @var string
   */
  protected $strTemplate = 'ce_streams';


  /**
   * Return if there are no files
   * @return string
   */
  public function generate() {
    return parent::generate();
  }

  public function compile() {
    $Stream = \StreamModel::findAll();
    if(empty($Stream))
      return;

    $time = time();
    $arrStreams = array();
    $Streams = $Stream->fetchAll();
    $MasterTime = 0;

    $this->Template->autoplay = ($this->autoplay_stream);
    $StreamIndex = 0;
    if($this->fromTime > $this->toTime)
      $this->toTime += (60*60*24);

    if($this->mainstream && $time >= $this->fromTime && $time <= $this->toTime) {
      foreach($Streams as $key => $stream) {
        if($stream['fallback']) {
          array_unshift($arrStreams,$stream);
        }
      }
    } else {
      if($this->random_stream)
        $StreamIndex = rand(1,(count($Streams)-1));

      // && (!$stream['timelimit'] || ($stream['timelimit'] && $time > $stream['fromTime'] && $time < $stream['toTime']))

      foreach($Streams as $stream) {
        if($stream['fromTime'] > $stream['toTime'])
          $stream['toTime'] += (60*60*24);
        if(!$stream['fallback'] && (!$stream['timelimit'] || ($stream['timelimit'] && $time >= $stream['fromTime'] && $time <= $stream['toTime'])))
          if($stream['permanent'])
            array_unshift($arrStreams,$stream);
          else $arrStreams[] = $stream;
      }
      foreach($Streams as $key => $stream) {
        if($stream['fallback'])
          array_unshift($arrStreams,$stream);
      }
    }
    $this->Template->from     = $this->fromTime;
    $this->Template->to       = $this->toTime;
    $this->Template->index    = $StreamIndex;
    $this->Template->streams  = $arrStreams;

  }
}