<?php

/**
 * Contao Open Source CMS
 */

/**
 * @file StreamModel.php
 * @class StreamModel
 * @author Sascha Weidner
 * @version 3.0.0
 * @package sioweb.contao.extensions.switchstream
 * @copyright Sascha Weidner, Sioweb
 */


if(!class_exists('StreamModel')) {
class StreamModel extends \Model {
  
  /**
   * Table name
   * @var string
   */
  protected static $strTable = 'tl_stream';
  
}}