<?php
/**
* Gavick Weather GK4 - helper class
* @package Joomla!
* @ Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK4 1.0 $
**/
// no direct access
defined('_JEXEC') or die('Restricted access');
// Main class
class GKWHelper {
	var $config;
	var $content;
	var $error;
	var $icons;
	var $parsedData;
    var $translation;
    var $cond_tmp;
	/**
	 *	INITIALIZATION 
	 **/
	function __construct($params) {		
		// importing JFile class 
		jimport('joomla.filesystem.file');
		// configuration array
		$this->config = array(
			'module_unique_id' => '',				            
            'city' => '',
			'fcity' => '',
            'language' => 'en',
			'latitude' => 'null',
			'longitude' => 'null',
			'timezone' => 0,
			'showCity' => 1,
			'showHum' => 1,
			'showWind' => 1,
			'tempUnit' => 'c',
			'nextDays' => 1,
			'amountDays' => 4,
			'current_icon_size' => 64,
			'forecast_icon_size' => 32,
			'useCSS' => 1,
			'useCache' => 1,
			'cacheTime' => 5,
			'source' => 'yahoo',
			'WOEID' => '',
			'iconset' => 'default',
            't_offset' => '0'
		); 
		// error text
		$this->error = '';
		// icons array
		$this->icons = array(
            "0"                                  => array('other.png'),
            "1"                                  => array('storm.png','storm_night.png'),
            "2"                                  => array('storm.png','storm_night.png'),
            "3"                                  => array('chance_of_storm.png','chance_of_storm_night.png'),
            "4"                                  => array('thunderstorm.png'),          
            "5"                                  => array('rain_and_snow.png'),
            "6"                                  => array('sleet.png'),
            "7"                                  => array('sleet.png'),     
            "8"                                  => array('rain.png'),    
            "9"                                  => array('rain.png'),     
            "10"                                 => array('rain.png'),
            "11"                                 => array('rain.png'),
            "12"                                 => array('rain.png'),
            "13"                                 => array('chance_of_snow.png', 'chance_of_snow_night.png'),                               
            "14"                                 => array('snow.png'),
            "15"                                 => array('snow.png'),
            "16"                                 => array('snow.png'),
            "17"                                 => array('chance_of_storm.png','chance_of_storm_night.png'),  
            "18"                                 => array('rain.png'),
            "19"                                 => array('dusty.png'),
            "20"                                 => array('foggy.png','foggy_night.png'),
            "21"                                 => array('hazy.png','hazy_night.png'),
            "22"                                 => array('smoke.png','smoke_night.png'),
            "23"                                 => array('cloudy.png'),
            "24"                                 => array('cloudy.png'),      
            "25"                                 => array('snow.png'),
            "26"                                 => array('cloudy.png'),
            "27"                                 => array('mostly_cloudy.png','mostly_cloudy_night.png'), 
            "28"                                 => array('mostly_cloudy.png','mostly_cloudy_night.png'), 
            "29"                                 => array('partly_cloudy.png','partly_cloudy_night.png'),
            "30"                                 => array('partly_cloudy.png','partly_cloudy_night.png'),
            "31"                                 => array('sunny.png','sunny_night.png'),
            "32"                                 => array('sunny.png','sunny_night.png'),
            "33"                                 => array('sunny.png','sunny_night.png'),
            "34"                                 => array('partly_cloudy.png','partly_cloudy_night.png'),
            "35"                                 => array('thunderstorm.png'),
            "36"                                 => array('sunny.png','sunny_night.png'),
            "37"                                 => array('thunderstorm.png'),
            "38"                                 => array('chance_of_storm.png','chance_of_storm_night.png'),
            "39"                                 => array('chance_of_storm.png','chance_of_storm_night.png'),
            "40"                                 => array('rain.png'),
            "41"                                 => array('snow.png'),
            "42"                                 => array('snow.png'),
            "43"                                 => array('snow.png'),
            "44"                                 => array('partly_cloudy.png','partly_cloudy_night.png'),
            "45"                                 => array('chance_of_storm.png','chance_of_storm_night.png'),
            "46"                                 => array('chance_of_snow.png', 'chance_of_snow_night.png'),
            "47"                                 => array('chance_of_storm.png','chance_of_storm_night.png'),
            "3200"                               => array('other.png')
 		);
        // translation table
        $this->translation = array(
            "Tornado"                           => JText::_('MOD_WEATHER_GK4_TORNADO'),
            "Tropical Storm"                    => JText::_('MOD_WEATHER_GK4_TROPICAL_STORM'),
            "Hurricane"                         => JText::_('MOD_WEATHER_GK4_HURRICANE'),
            "Severe Thunderstorms"              => JText::_('MOD_WEATHER_GK4_SEVERE_THUNDERSTORMS'),
            "Thunderstorms"                     => JText::_('MOD_WEATHER_GK4_THUNDERSTORMS'),
            "Mixed Rain and Snow"               => JText::_('MOD_WEATHER_GK4_MIXED_RAIN_AND_SNOW'),
            "Mixed Rain and Sleet"              => JText::_('MOD_WEATHER_GK4_MIXED_RAIN_AND_SLEET'),
            "Mixed Snow and Sleet"              => JText::_('MOD_WEATHER_GK4_MIXED_SNOW_AND_SLEET'),
            "Freezing Drizzle"                  => JText::_('MOD_WEATHER_GK4_FREEZING_DRIZZLE'),
            "Drizzle"                           => JText::_('MOD_WEATHER_GK4_DRIZZLE'),
            "Freezing Rain"                     => JText::_('MOD_WEATHER_GK4_FREEZING_RAIN'),
            "Showers"                           => JText::_('MOD_WEATHER_GK4_SHOWERS'),
            "Snow Flurries"                     => JText::_('MOD_WEATHER_GK4_SNOW_FLURRIES'),
            "Light Snow Showers"                => JText::_('MOD_WEATHER_GK4_LIGHT_SNOW_SHOWERS'),
            "Blowing Snow"                      => JText::_('MOD_WEATHER_GK4_BLOWING_SNOW'),
            "Snow"                              => JText::_('MOD_WEATHER_GK4_SNOW'),
            "Hail"                              => JText::_('MOD_WEATHER_GK4_HAIL'),
            "Sleet"                             => JText::_('MOD_WEATHER_GK4_SLEET'),
            "Dust"                              => JText::_('MOD_WEATHER_GK4_DUST'),
            "Foggy"                             => JText::_('MOD_WEATHER_GK4_FOGGY'),
            "Haze"                              => JText::_('MOD_WEATHER_GK4_HAZE'),
            "Smoky"                             => JText::_('MOD_WEATHER_GK4_SMOKY'),
            "Blustery"                          => JText::_('MOD_WEATHER_GK4_BLUSTERY'),
            "Windy"                             => JText::_('MOD_WEATHER_GK4_WINDY'),
            "Cold"                              => JText::_('MOD_WEATHER_GK4_COLD'),
            "Cloudy"                            => JText::_('MOD_WEATHER_GK4_CLOUDY'),
            "Mostly Cloudy"                     => JText::_('MOD_WEATHER_GK4_MOSTLY_CLOUDY'),
            "Partly Cloudy"                     => JText::_('MOD_WEATHER_GK4_PARTLY_CLOUDY'),
            "Clear"                             => JText::_('MOD_WEATHER_GK4_CLEAR'),
            "Sunny"                             => JText::_('MOD_WEATHER_GK4_SUNNY'),
            "Fair"                              => JText::_('MOD_WEATHER_GK4_FAIR'),
            "Mixed Rain and Hail"               => JText::_('MOD_WEATHER_GK4_MIXED_RAIN_AND_HAIL'),
            "Hot"                               => JText::_('MOD_WEATHER_GK4_HOT'),
            "Isolated Thunderstorms"            => JText::_('MOD_WEATHER_GK4_ISOLATED_THUNDERSTORMS'),
            "Scattered Thunderstorms"           => JText::_('MOD_WEATHER_GK4_SCATTERED_THUNDERSTORMS'),
            "Scattered Showers"                 => JText::_('MOD_WEATHER_GK4_SCATTERED_SHOWERS'),
            "Heavy Snow"                        => JText::_('MOD_WEATHER_GK4_HEAVY_SNOW'),
            "Scattered Snow Showers"            => JText::_('MOD_WEATHER_GK4_SCATTERED_SNOW_SHOWERS'),
            "Heavy Snow"                        => JText::_('MOD_WEATHER_GK4_HEAVY_SNOW'),
            "Partly Cloudy"                     => JText::_('MOD_WEATHER_GK4_PARTLY_CLOUDY'),
            "Thundershowers"                    => JText::_('MOD_WEATHER_GK4_THUNDERSHOWERS'),
            "Snow Showers"                      => JText::_('MOD_WEATHER_GK4_SNOW_SHOWERS'),
            "Isolated thundershowers"           => JText::_('MOD_WEATHER_GK4_ISOLATED_THUNDERSHOWERS'),
            "Not Available"                     => JText::_('MOD_WEATHER_GK4_NOT_AVAILABLE'),
            "Mostly Clear"                      => JText::_('MOD_WEATHER_GK4_MOSTLY_CLEAR'),
            "Light Rain"						=> JText::_('MOD_WEATHER_GK4_LIGHT_RAIN'),
            "Fog"								=> JText::_('MOD_WEATHER_GK4_FOG'),
            "Thunder"							=> JText::_('MOD_WEATHER_GK4_THUNDER'),
            "Mist"								=> JText::_('MOD_WEATHER_GK4_MIST'),
            "Rain Shower"						=> JText::_('MOD_WEATHER_GK4_RAIN_SHOWER'),
            "Light Rain Showers"				=> JText::_('MOD_WEATHER_GK4_LIGHT_RAIN_SHOWERS'),
            "Rain/Snow Showers"					=> JText::_('MOD_WEATHER_GK4_RAIN_SNOW_SHOWERS'),
            "PM Rain/Snow Showers"				=> JText::_('MOD_WEATHER_GK4_PM_RAIN_SNOW_SHOWERS'),
            "Light Snow"						=> JText::_('MOD_WEATHER_GK4_LIGHT_SNOW'),
            "Snow Showers Late"					=> JText::_('MOD_WEATHER_GK4_SNOW_SHOWERS_LATE'),
            "AM Showers"						=> JText::_('MOD_WEATHER_GK4_AM_SHOWERS'),
            "PM Rain Snow"						=> JText::_('MOD_WEATHER_GK4_PM_RAIN_SNOW'),
            "Showers Early"						=> JText::_('MOD_WEATHER_GK4_SHOWERS_EARLY'),
            "Rain/Snow"							=> JText::_('MOD_WEATHER_GK4_RAIN_SNOW'),
            "AM Rain"							=> JText::_('MOD_WEATHER_GK4_AM_RAIN'),
            "AM Rain/Snow Showers"				=> JText::_('MOD_WEATHER_GK4_AM_RAIN_SNOW_SHOWERS'),
            "Mostly Sunny"						=> JText::_('MOD_WEATHER_GK4_MOSTLY_SUNNY'),
            "AM Snow Showers"					=> JText::_('MOD_WEATHER_GK4_AM_SNOW_SHOWERS'),
            "Light Snow Grains"					=> JText::_('MOD_WEATHER_GK4_LIGHT_SNOW_GRAINS'),
            "Light Freezing Drizzle"			=> JText::_('MOD_WEATHER_GK4_LIGHT_FREEZING_DRIZZLE'),
            "Sunny/Wind"						=> JText::_('MOD_WEATHER_GK4_LIGHT_SUNNY_WIND'),
            "Rain and Snow"						=> JText::_('MOD_WEATHER_GK4_RAIN_AND_SNOW'),
            "Light Rain with Thunder"			=> JText::_('MOD_WEATHER_GK4_LIGHT_RAIN_WITH_THUNDER')
               
        );
		// parsed from XML data
		$this->parsedData = array(
			'unit' => '',
			'current_condition' => '',
			'current_temp_f' => '',
			'current_temp_c' => '',
			'current_humidity' => '',
			'current_icon' => '',
			'current_wind' => '',
            'sunrise' => '',
            'sunset' => '',
			'forecast' => array()
		);
		// get the config
		$this->config['module_unique_id'] = $params->get('module_unique_id','weather1'); // unique ID
		$this->config['fcity'] = $params->get('fullcity','');
		$this->config['timezone'] = $params->get('timezone',0);
		$this->config['moduleMode'] = $params->get('moduleMode','vertical');
		$this->config['showCity'] = $params->get('showCity',1);
		$this->config['showHum'] = $params->get('showHum',1);
		$this->config['showWind'] = $params->get('showWind',1);
		$this->config['tempUnit'] = $params->get('tempUnit','c');
		$this->config['showPresent'] = $params->get('showPresent',1);
		$this->config['nextDays'] = $params->get('nextDays',1);
		$this->config['amountDays'] = $params->get('amountDays',4);
		$this->config['current_icon_size'] = $params->get('current_icon_size',64);
		$this->config['forecast_icon_size'] = $params->get('forecast_icon_size',32);
		$this->config['useCSS'] = $params->get('useCSS',1);
		$this->config['useCache'] = $params->get('useCache',1);
		$this->config['cacheTime'] = $params->get('cacheTime',5);
		$this->config['source'] = 'yahoo';
		$this->config['WOEID'] = $params->get('WOEID', '');
        $this->config['t_offset'] = $params->get('t_offset', '');
         // new v1.6.5 feature
         $this->config['iconset'] = $params->get('iconset', 'default');
	}
	/**
	 *	GETTING DATA
	 **/	
	function getData() {
		clearstatcache();
		
		if($this->config['useCache'] == 1) {
                  if(filesize(realpath(JPATH_BASE.'/modules/mod_weather_gk4/cache/mod_weather.bxml')) == 0 || ((filemtime(realpath(JPATH_BASE.'/modules/mod_weather_gk4/cache/mod_weather.bxml')) + $this->config['cacheTime'] * 60) < time())) {
                        if(function_exists('curl_init')) {
					// initializing connection
					$curl = curl_init();
					// saves us before putting directly results of request
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
					// url to get
				    // check the source of request
				    if($this->config['source'] == 'google'){
				    	curl_setopt($curl, CURLOPT_URL, 'http://www.google.com/ig/api?weather='.$this->config['city'].'&hl='.$this->config['language'].$encoding_url);
				    } else {
				    	curl_setopt($curl, CURLOPT_URL, 'http://xml.weather.yahoo.com/forecastrss?w='.$this->config['WOEID']."&u=".$this->config['tempUnit']);
				    }
					// timeout in seconds
					curl_setopt($curl, CURLOPT_TIMEOUT, 5);
					// useragent
					curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
					// reading content
					$this->content = curl_exec($curl);
					// closing connection
					curl_close($curl);
				} 
                // check file_get_contents function enable and allow external url's'
                else if( file_get_contents(__FILE__) && ini_get('allow_url_fopen') && !function_exists('curl_init')) {
	                if($this->config['source'] == 'google'){
	                    $encoding_url = ($this->config['encoding'] != '') ? '&oe='.$this->config['encoding'] : '';
	                    $this->content = file_get_contents('http://www.google.com/ig/api?weather='.$this->config['city'].'&hl='.$this->config['language'].$encoding_url);
	                } else {
	                    $this->content = file_get_contents('http://xml.weather.yahoo.com/forecastrss?w='.$this->config['WOEID']."&u=".$this->config['tempUnit']);
	                }
                } else {
					$this->error = 'cURL extension and file_get_content method is not available on your server';
				}
				// if error doesn't exist
				if($this->error == '') {
					// saving cache
					if($this->content !='') {
						JFile::write(JPATH_SITE.DS.'modules/mod_weather_gk4/cache/mod_weather.bxml', $this->content);
					}
				} else {
				    $this->content = JFile::read(JPATH_SITE.DS.'modules/mod_weather_gk4/cache/mod_weather.backup.bxml');
				}
			} else {
				$this->content = JFile::read(JPATH_SITE.DS.'modules/mod_weather_gk4/cache/mod_weather.backup.bxml');
			}
		} else {
			if(function_exists('curl_init')) {
				// initializing connection
				$curl = curl_init();
				// saves us before putting directly results of request
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
				// url to get
				$encoding_url = ($this->config['encoding'] != '') ? '&oe='.$this->config['encoding'] : '';
				// check the source of query
				if($this->config['source'] == 'google'){
					$encoding_url = ($this->config['encoding'] != '') ? '&oe='.$this->config['encoding'] : '';    
					curl_setopt($curl, CURLOPT_URL, 'http://www.google.com/ig/api?weather='.$this->config['city'].'&hl='.$this->config['language'].$encoding_url);
				} else {
					curl_setopt($curl, CURLOPT_URL, 'http://xml.weather.yahoo.com/forecastrss?w='.$this->config['WOEID']."&u=".$this->config['tempUnit']); 
				}
				// timeout in seconds
				curl_setopt($curl, CURLOPT_TIMEOUT, 20);
				// useragent
				curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
				// reading content
				$this->content = curl_exec($curl);
				// closing connection
				curl_close($curl);
			} 
            // check file_get_contents function enable and allow external url's'
            else if( file_get_contents(__FILE__) && ini_get('allow_url_fopen') && !function_exists('curl_init')) {
                if($this->config['source'] == 'google'){
                    $this->content = file_get_contents('http://www.google.com/ig/api?weather='.$this->config['city'].'&hl='.$this->config['language'].$encoding_url);
                } else {
                    $this->content = file_get_contents('http://xml.weather.yahoo.com/forecastrss?w='.$this->config['WOEID']."&u=".$this->config['tempUnit'].$encoding_url);
                }
            } else {
				$this->error = 'cURL extension and file_get_content method is not available on your server';
			}
		}
	}
	/**
	 *	PARSING DATA
	 **/
	function parseData() {
		if($this->error !== '') {
                  $this->error = 'Parse error in downloaded data (400)'; // set error
            }
            // checking for 400 Bad request page
            if(strpos($this->content, '400 Bad') !== FALSE) {	
                  return;
            }

            if($this->config['source'] != 'yahoo'){
                  return;
            }

            $this->content = str_replace('yweather:','', $this->content);
            $this->content = str_replace('geo:','', $this->content);
            
            // load the XML content
            if($this->content == '') {
                  $this->useBackup();
            }

            $xml = JFactory::getXML($this->content, false);

            if(!$xml) {
                  $this->error = 'Parse error in downloaded data'; // set error
            }
            
            if(strpos(current($xml->channel[0]->description), "Error") != FALSE) {
                  $this->error = 'An error occured - you set wrong location or data for your location are unavailable';
            }

            $problem = false;
            $current_info = $xml->channel[0];
            $current_info2 = $xml->channel[0]->item[0];
            $forecast_info = $xml->channel[0]->item[0];

            if(
                  isset($current_info->units[0]) &&
                  isset($current_info2->condition[0]) &&
                  isset($current_info->atmosphere[0]) &&
                  isset($current_info->image[0]) &&
                  isset($current_info->location[0]) &&
                  isset($current_info->wind[0])
            ) {
                  // loading data from feed
                  if(isset($this->translation[current($current_info2->condition[0]->attributes()->text)])){
                        $this->parsedData['current_condition'] = $this->translation[current($current_info2->condition[0]->attributes()->text)];
                  } else {
                        $this->parsedData['current_condition'] = current($current_info2->condition[0]->attributes()->text);  
                  }

                  $this->parsedData['current_temp'] = current($current_info2->condition[0]->attributes()->temp)."&deg;".current($current_info->units[0]->attributes()->temperature);
                  $this->parsedData['current_humidity'] = JText::_('MOD_WEATHER_GK4_HUMIDITY') ." " .current($current_info->atmosphere[0]->attributes()->humidity)."%";
                  $this->parsedData['current_icon'] = current($current_info2->condition[0]->attributes()->code);
                  $this->parsedData['current_wind'] = JText::_('MOD_WEATHER_GK4_WIND') ." ".current($current_info->wind[0]->attributes()->speed)." ".current($current_info->units[0]->attributes()->speed);
                  $this->parsedData['sunrise'] = current($current_info->astronomy[0]->attributes()->sunrise);
                  $this->parsedData['sunset'] = current($current_info->astronomy[0]->attributes()->sunset);
                  // parsing forecast
                  for($i = 0; $i < 2; $i++) {
                        if(isset($this->translation[current($forecast_info->forecast[$i]->attributes()->text)])){
                              $this->cond_tmp = $this->translation[current($forecast_info->forecast[$i]->attributes()->text)];
                        } else {
                              $this->cond_tmp = current($forecast_info->forecast[$i]->attributes()->text);
                        }

                        $this->parsedData['forecast'][$i] = array(
                              "day" => $this->translateDate(current($forecast_info->forecast[$i]->attributes()->date)),
                              "low" => current($forecast_info->forecast[$i]->attributes()->low)."&deg;".current($current_info->units[0]->attributes()->temperature),
                              "high" => current($forecast_info->forecast[$i]->attributes()->high)."&deg;".current($current_info->units[0]->attributes()->temperature),
                              "icon" => current($forecast_info->forecast[$i]->attributes()->code),
                              "condition" => $this->cond_tmp,
                        );
                  }
            } else {
                  $problem = true; // set the problem 
                  $this->error = 'An error occured during parsing XML data. Please try again.';
            }
            // if problem detected
            if($problem == true) {
                  $this->error = 'An error occured during parsing XML data. Please try again.';
            } else {
                  // prepare a backup
                  JFile::write(JPATH_SITE.DS.'modules/mod_weather_gk4/cache/mod_weather.backup.bxml', $this->content);
            }
      }
	/** 
	 *	RENDERING LAYOUT
	 **/
	function renderLayout() {	
		// if any error exists
		if($this->error === '') {
			
			// create instances of basic Joomla! classes
			$document = JFactory::getDocument();
			$uri = JURI::getInstance();
			// add stylesheets to document header
			if($this->config["useCSS"] == 1){
				$document->addStyleSheet( $uri->root().'modules/mod_weather_gk4/style/style.css', 'text/css' );
			}
			if(
				$this->config['iconset'] == 'meteocons_font_dark' ||
				$this->config['iconset'] == 'meteocons_font_light'
			) {
				$document->addStyleSheet( $uri->root().'modules/mod_weather_gk4/icons/meteocons_font/stylesheet.css', 'text/css' );
			}
			// include necessary view
			require(JModuleHelper::getLayoutPath('mod_weather_gk4', ($this->config['source'] == 'google') ? 'googleView' : 'yahooView'));
		} else { // else - output error information
			$this->useBackup();
			$document = JFactory::getDocument();
			$uri = JURI::getInstance();
				if($this->config["useCSS"] == 1){
				$document->addStyleSheet( $uri->root().'modules/mod_weather_gk4/style/style.css', 'text/css' );
			}
			if(
				$this->config['iconset'] == 'meteocons_font_dark' ||
				$this->config['iconset'] == 'meteocons_font_light'
			) {
				$document->addStyleSheet( $uri->root().'modules/mod_weather_gk4/icons/meteocons_font/stylesheet.css', 'text/css' );
			}
			// include necessary view
			require(JModuleHelper::getLayoutPath('mod_weather_gk4', ($this->config['source'] == 'google') ? 'googleView' : 'yahooView'));
		}
	}
	/*
     * Function to get the backup data
     */
    function useBackup() {
        $this->error = '';
        $this->content = JFile::read(JPATH_SITE.DS.'modules/mod_weather_gk4/cache/mod_weather.backup.bxml');
    }
    
    
    /*
     *
     */
    function translateDate($date) {
    
    	preg_match('/[A-Za-z]{3,}/', $date, $month);
     	$replace = '';
   		
    	switch($month[0]) {
    		case 'Jan' : $replace = JText::_('MOD_WEATHER_GK4_JAN'); break;
    		case 'Feb' : $replace = JText::_('MOD_WEATHER_GK4_FEB'); break;
    		case 'Mar' : $replace = JText::_('MOD_WEATHER_GK4_MAR'); break;
    		case 'Apr' : $replace = JText::_('MOD_WEATHER_GK4_APR'); break;
    		case 'May' : $replace = JText::_('MOD_WEATHER_GK4_MAY'); break;
    		case 'Jun' : $replace = JText::_('MOD_WEATHER_GK4_JUN'); break;
    		case 'Jul' : $replace = JText::_('MOD_WEATHER_GK4_JUL'); break;
    		case 'Aug' : $replace = JText::_('MOD_WEATHER_GK4_AUG'); break;
    		case 'Sep' : $replace = JText::_('MOD_WEATHER_GK4_SEP'); break;
    		case 'Oct' : $replace = JText::_('MOD_WEATHER_GK4_OCT'); break;
    		case 'Nov' : $replace = JText::_('MOD_WEATHER_GK4_NOV'); break;
    		case 'Dec' : $replace = JText::_('MOD_WEATHER_GK4_DEC'); break;
    		default: $replace = $month[0];
    	}
    	
    	$date = str_replace($month[0], $replace, $date);
    	
    	return $date;
    } 
     
	/*
	 * Function to get correct icon
	 */
	function icon($icon, $size = 128, $font = false) {
		// creating JURI instance
		$uri = JURI::getInstance();
		$icon_path = $uri->root().'modules/mod_weather_gk4/icons/'.$this->config['iconset'].'/'.(($size == 128) ? '' : $size.'/');
		
		if($this->config['iconset'] != 'yahoo') {
			// if selected icon exists
			if(is_array($this->icons[$icon])) {
	            // if user use PHP5 and google feed
				if(function_exists('date_sunrise') && function_exists('date_sunset') && $this->config['source']=='google') {
					// if user set values for his position
					if($this->config['latitude'] !== 'null' && $this->config['longitude'] !== 'null') {
						// getting informations about sunrise and sunset time
						$sunrise = date_sunrise( time(), SUNFUNCS_RET_TIMESTAMP , $this->config['latitude'], $this->config['longitude'], ini_get("date.sunrise_zenith"), $this->config['timezone'] )+$this->config['t_offset']*3600;
						$sunset = date_sunset( time(), SUNFUNCS_RET_TIMESTAMP , $this->config['latitude'], $this->config['longitude'], ini_get("date.sunrise_zenith"), $this->config['timezone'] )+$this->config['t_offset']*3600;
						// flag for night ;)
						$night = false;
						// night check ;)
						if(time() < $sunrise || time() > $sunset) {
							$night = true; // now is night! :P
						}
						// getting final icon - if selected icon has two icons - for day and night - return correct icon					
						if($font) {
							return $this->icons[$icon][(count($this->icons[$icon]) > 1 && $night) ? 1 : 0];
						}
						return $icon_path . $this->icons[$icon][(count($this->icons[$icon]) > 1 && $night) ? 1 : 0];
					} else {
						if($font) {
							return $this->icons[$icon][0];
						}
						return $icon_path . $this->icons[$icon][0];
					}
				} 
	            // if user use yahoo feed
	            else if ($this->config['source']=='yahoo' && isset($this->parsedData['sunrise']) && isset($this->parsedData['sunset'])){
	                    $sunrise = $this->prepareTime($this->parsedData['sunrise'])+$this->config['t_offset']*3600;
	                    $sunset = $this->prepareTime($this->parsedData['sunset'])+$this->config['t_offset']*3600;
	                    // flag for night ;)
						$night = false;
						// night check ;)
						if(time() < $sunrise || time() > $sunset) {
							$night = true; // now is night! :P
						}
						if($font) {
							return $this->icons[$icon][(count($this->icons[$icon]) > 1 && $night) ? 1 : 0];
						}
						// getting final icon - if selected icon has two icons - for day and night - return correct icon
						return $icon_path . $this->icons[$icon][(count($this->icons[$icon]) > 1 && $night) ? 1 : 0];
	            } else {
	            	if($font) {
						return $this->icons[$icon][0];
					}
					return $icon_path . $this->icons[$icon][0];
				}
			} else { // else - return "?" icon
				if($font) {
					return 'other.png';
				}
				return $icon_path . 'other.png';
			}
		} else {
			return 'http://l.yimg.com/a/i/us/we/52/'.$icon.'.gif';
		}
	}
	/*
	 * Function to get correct temperature
	 */
	function temp($temp) {
		if($this->parsedData['unit'] == 'US' && $this->config['tempUnit'] == 'c') return $this->F2Cel($temp);
		else if($this->parsedData['unit'] == 'SI' && $this->config['tempUnit'] == 'f') return $this->Cel2F($temp);
		else return $temp.(($this->config['tempUnit'] == 'c') ? '&deg;C' : '&deg;F' );		
	}
    /*
     * Function to parse sunrise/sunset time to timestamp
     */
    function prepareTime($time) {
        $f_date = date("Y-m-d")." ".$time;
        $pos = strpos($f_date, "pm");
        $f_date = preg_replace('/ [a-z][a-z]/', ':00', $f_date);
        return strtotime($f_date) + (($pos !== FALSE) ? 12*3600 : 0); // if pm add 12 hours
    }
    /*
     * function to parse Celsius to Farhenheit
     */
    function Cel2F($value) {
    	return round(32 + ((5/9) * $value)).'&deg;F';
    }
	/*
 	 * function to parse Farhenheit to Celsius
 	 */    
    function F2Cel($value) {
    	return round((5/9) * ($value - 32)).'&deg;C';
    }
}
/*eof*/
