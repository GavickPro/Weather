jQuery(document).ready(function() {
	getUpdates();
	// check Joomla! version and add suffix
	if(parseFloat((jQuery('#gk_about_us').data('jversion')).substr(0,3)) >= '3.2') {
		jQuery('#module-form').addClass('j32');
	}
	// other form operations
	jQuery('.input-minutes').each(function(i, el){jQuery(el).parent().html("<div class=\"input-prepend\">" + jQuery(el).parent().html() + "<span class=\"add-on\">minutes</span></div>");});
	jQuery('#gk_module_updates').parent().css('margin-left', '20px');	
	jQuery('#gk_about_us').parent().css('margin-left', '20px');
	
	// WOEID link
	var woeidLink = jQuery('<a>', { 'href' : 'http://isithackday.com/geoplanet-explorer/', 'target' : '_blank',  'id' : 'gkDemoLink', 'html' : 'WOEID'});
	jQuery('#jform_params_WOEID').after(woeidLink);
	// help link
	var link = jQuery('<small>', { 'class' : 'gkHelpLink', 'href' : 'https://www.gavick.com/weather-gk4.html', 'target' : '_blank' });
	jQuery(jQuery('ul.nav-tabs li')[6]).find('a').append(link);
	link.click( function(e) { 
		e.preventDefault(); 
		e.stopPropagation(); 
		document.location.href = link.attr('href');
	});
});



function getUpdates() {
	jQuery('#jform_params_template_updates-lbl').remove(); // remove unnecesary label
	var update_url = 'https://www.gavick.com/updates.raw?task=json&tmpl=component&query=product&product=mod_weather_gk4_j30';
	var update_div = jQuery('#gk_module_updates');
	update_div.html('<div id="gk_update_div"><span id="gk_loader"></span>Loading update data from GavicPro Update service...</div>');
	var content='';
	
	jQuery.getScript(update_url, function(data, textStatus, jqxhr) {
		jQuery($GK_UPDATE).each(function(i,el) {					        
			content += '<li><span class="gk_update_version"><strong>Version:</strong> ' + el.version + ' </span><span class="gk_update_data"><strong>Date:</strong> ' + el.date + ' </span><span class="gk_update_link"><a href="' + el.link + '" target="_blank">Download</a></span></li>';
		});
	
		update_div.html('<ul class="gk_updates">' + content + '</ul>');
		if(update_div.html() == '<ul class="gk_updates"></ul>') {
			update_div.html('<p>There is no available updates for this module</p>'); 
		}
		if(update_div.html() == '<ul class="gk_updates"></ul>') {
			update_div.html('<p>There is no available updates for this module</p>'); 
		}
	});	
}