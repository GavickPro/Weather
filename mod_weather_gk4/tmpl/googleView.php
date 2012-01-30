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
			<img src="<?php echo $this->icon($this->parsedData['current_icon'], $this->config['current_icon_size']); ?>" alt="<?php echo $this->parsedData['current_condition']; ?>" />
			<p class="gkwTemp"><?php echo ($this->config['tempUnit'] == 'f') ? $this->parsedData['current_temp_f'].'&deg;F' : $this->parsedData['current_temp_c'].'&deg;C'; ?></p>
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
		<?php for($i = 0; $i < $this->config['amountDays']; $i++) : ?>
		<li class="gkwItems<?php echo $this->config['amountDays']; ?>">
			<div class="gkwFday">
				<span class="gkwDay"><?php echo $this->parsedData['forecast'][$i]['day']; ?></span>
				<img src="<?php echo $this->icon($this->parsedData['forecast'][$i]['icon'], $this->config['forecast_icon_size']); ?>" title="<?php echo $this->parsedData['forecast'][$i]['condition']; ?>" alt="<?php echo $this->parsedData['forecast'][$i]['condition']; ?>" />
				<p class="gkwDayTemp">
					<span class="gkwDayDay"><?php echo $this->temp($this->parsedData['forecast'][$i]['high']); ?></span>
					<span class="gkwDayNight"><?php echo $this->temp($this->parsedData['forecast'][$i]['low']); ?></span>
				</p>
			</div>
		</li>
		<?php endfor; ?>
	</ul>
	<?php endif; ?>
</div>