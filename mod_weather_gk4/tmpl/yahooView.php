<?php
/**
* Gavick Weather GK4 - layout
* @package Joomla!
* @ Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK4 1.0 $
**/
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="gkwMain<?php if($this->config['moduleMode'] == 'horizontal') echo ' horizontal'; ?>" id="<?php echo $this->config['module_unique_id']; ?>">
	<?php if($this->config['showPresent'] == 1) : ?>
    <div class="gkwCurrent">
		<div class="gkwMainLeft">
			<?php if(
				$this->config['iconset'] == 'meteocons_font_dark' ||
				$this->config['iconset'] == 'meteocons_font_light'
			) : ?>
				<i class="meteocons-<?php echo str_replace('.png', '', $this->icon($this->parsedData['current_icon'], 32, true)); ?><?php if($this->config['iconset'] == 'meteocons_font_dark') : ?> dark<?php else: ?> light<?php endif; ?> size-<?php echo $this->config['current_icon_size']; ?>"></i>
			<?php else : ?>
				<img src="<?php echo $this->icon($this->parsedData['current_icon'], $this->config['current_icon_size']); ?>" alt="<?php echo $this->parsedData['current_condition']; ?>" />
			<?php endif; ?>
			<p class="gkwTemp"><?php echo $this->parsedData['current_temp'] ?></p>
		</div>
		<div class="gkwMainRight">
			<?php if($this->config['showCity'] == 1) : ?><h2><?php echo $this->config['fcity']; ?></h2><?php endif; ?>
			<p class="gkwCondition"><?php echo $this->parsedData['current_condition']; ?></p>
			<?php if($this->config['showHum'] == 1) : ?><p class="gkwHumidity"><?php echo $this->parsedData['current_humidity']; ?></p><?php endif; ?>
			<?php if($this->config['showWind'] == 1) : ?><p class="gkwWind"><?php echo $this->parsedData['current_wind']; ?></p><?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
	
	<?php if($this->config['nextDays'] == 1) : ?>
	<ul class="gkwNextDays">
        <?php for($i = 0; $i < 2; $i++) : ?>
		<li class="gkwItems2">
			<div class="gkwFday">
				<span class="gkwDay"><?php echo $this->parsedData['forecast'][$i]['day']; ?></span>
				<p class="gkwDayTemp">
                	<?php if(
                		$this->config['iconset'] == 'meteocons_font_dark' ||
                		$this->config['iconset'] == 'meteocons_font_light'
                	) : ?>
                		<i class="meteocons-<?php echo str_replace('.png', '', $this->icon($this->parsedData['current_icon'], 32, true)); ?><?php if($this->config['iconset'] == 'meteocons_font_dark') : ?> dark<?php else: ?> light<?php endif; ?> size-<?php echo $this->config['forecast_icon_size']; ?>"></i>
                	<?php else : ?>
                		<img src="<?php echo $this->icon($this->parsedData['forecast'][$i]['icon'], $this->config['forecast_icon_size']); ?>" title="<?php echo $this->parsedData['forecast'][$i]['condition']; ?>" alt="<?php echo $this->parsedData['forecast'][$i]['condition']; ?>" />
                	<?php endif; ?>
					<span class="gkwDayDay"><?php echo $this->parsedData['forecast'][$i]['high']; ?></span>
					<span class="gkwDayNight"><?php echo $this->parsedData['forecast'][$i]['low']; ?></span>
				</p>
			</div>
		</li>
        <?php endfor; ?>
	</ul>
	<?php endif; ?>
</div>