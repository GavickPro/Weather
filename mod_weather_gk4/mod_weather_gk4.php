<?php





/**
* Gavick Weather GK4 - main file
* @package Joomla!
* @ Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK4 1.0 $
**/

// access restriction


defined('_JEXEC') or die('Restricted access');
if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
}
// Loading helper class
require_once (dirname(__FILE__).DS.'helper.php');
// initialize the module and get the XML data

$helper = new GKWHelper($params);
$helper->getData();
// try to parse the data

try{
    $helper->parseData();    
} catch (Exception $e) {
	// use backup
    $helper->useBackup();
    // parse the backup data
    $helper->parseData();
}


// render the module output
$helper->renderLayout();


/*eof*/