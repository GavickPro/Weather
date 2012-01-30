window.addEvent("domready",function(){
	getUpdates();
	// other form operations
	$$('.input-pixels').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">px</span>"});
	$$('.input-percents').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">%</span>"});
	$$('.input-minutes').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">minutes</span>"});
	$$('.input-ms').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">ms</span>"});
	// switchers
	$$('.gk_switch').each(function(el){
		el.setStyle('display','none');
		var style = (el.value == 1) ? 'on' : 'off';
		var switcher = new Element('div',{'class' : 'switcher-'+style});
		switcher.inject(el, 'after');
		switcher.addEvent("click", function(){
			if(el.value == 1){
				switcher.setProperty('class','switcher-off');
				el.value = 0;
			}else{
				switcher.setProperty('class','switcher-on');
				el.value = 1;
			}
		});
	});
	// hiding
	if(document.id('jform_params_source').value == 'google') {
		document.id('jform_params_WOEID').getParent().setStyle('display','none');
		document.id('jform_params_yahoo_icons').getParent().setStyle('display','none');
	} else {
		[document.id('jform_params_city'), 
		document.id('jform_params_language'), 
		document.id('jform_params_encoding'),
		document.id('jform_params_lat'),
		document.id('jform_params_lon'),
		document.id('jform_params_amountDays')].each(function(el){
		 	el.getParent().setStyle('display', 'none');
		 });
	}
	
	document.id('jform_params_source').addEvent('change', function(){
		if(document.id('jform_params_source').value == 'google') {
			document.id('jform_params_WOEID').getParent().setStyle('display','none');
			document.id('jform_params_yahoo_icons').getParent().setStyle('display','none');
			 [document.id('jform_params_city'), 
			 document.id('jform_params_language'), 
			 document.id('jform_params_encoding'),
			 document.id('jform_params_lat'),
			 document.id('jform_params_lon'),
			 document.id('jform_params_amountDays')].each(function(el){
			  	el.getParent().setStyle('display', 'block');
			  });
		} else {
			[document.id('jform_params_city'), 
			document.id('jform_params_language'), 
			document.id('jform_params_encoding'),
			document.id('jform_params_lat'),
			document.id('jform_params_lon'),
			document.id('jform_params_amountDays')].each(function(el){
			 	el.getParent().setStyle('display', 'none');
			 });
			document.id('jform_params_WOEID').getParent().setStyle('display','block');
			document.id('jform_params_yahoo_icons').getParent().setStyle('display','block');
		}	
	});
	
	document.id('jform_params_source').addEvent('blur', function(){
		if(document.id('jform_params_source').value == 'google') {
			document.id('jform_params_WOEID').getParent().setStyle('display','none');
			document.id('jform_params_yahoo_icons').getParent().setStyle('display','none');
			 [document.id('jform_params_city'), 
			 document.id('jform_params_language'), 
			 document.id('jform_params_encoding'),
			 document.id('jform_params_lat'),
			 document.id('jform_params_lon'),
			 document.id('jform_params_amountDays')].each(function(el){
			  	el.getParent().setStyle('display', 'block');
			  });
		} else {
			[document.id('jform_params_city'), 
			document.id('jform_params_language'), 
			document.id('jform_params_encoding'),
			document.id('jform_params_lat'),
			document.id('jform_params_lon'),
			document.id('jform_params_amountDays')].each(function(el){
			 	el.getParent().setStyle('display', 'none');
			 });
			document.id('jform_params_WOEID').getParent().setStyle('display','block');
			document.id('jform_params_yahoo_icons').getParent().setStyle('display','block');
		}	
	});
	// demo link
	new Element('a', { 'href' : 'http://sigizmund.info/woeidinfo/', 'target' : '_blank',  'id' : 'gkDemoLink', 'html' : 'WOEID'  }).inject(document.id('jform_params_WOEID'), 'after');
	// help link
	var link = new Element('a', { 'class' : 'gkHelpLink', 'href' : 'http://tools.gavick.com/weather.html', 'target' : '_blank' })
	link.inject($$('div.panel')[$$('div.panel').length-1].getElement('h3'), 'bottom');
	link.addEvent('click', function(e) { e.stopPropagation(); });
});
// function to generate the updates list
function getUpdates() {
	document.id('jform_params_module_updates-lbl').destroy(); // remove unnecesary label
	var update_url = 'https://www.gavick.com/updates.raw?task=json&tmpl=component&query=product&product=mod_gk_weather_j16';
	var update_div =document.id('gk_module_updates');
	update_div.innerHTML = '<div id="gk_update_div"><span id="gk_loader"></span>Loading update data from GavicPro Update service...</div>';
	
	new Asset.javascript(update_url,{
		id: "new_script",
		onload: function(){
			content = '';
			$GK_UPDATE.each(function(el){
				content += '<li><span class="gk_update_version"><strong>Version:</strong> ' + el.version + ' </span><span class="gk_update_data"><strong>Date:</strong> ' + el.date + ' </span><span class="gk_update_link"><a href="' + el.link + '" target="_blank">Download</a></span></li>';
			});
			update_div.innerHTML = '<ul class="gk_updates">' + content + '</ul>';
			if(update_div.innerHTML == '<ul class="gk_updates"></ul>') update_div.innerHTML = '<p>There is no available updates for this module</p>';	
		}
	});
}