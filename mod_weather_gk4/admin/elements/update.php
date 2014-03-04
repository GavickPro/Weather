<?php





defined('JPATH_BASE') or die;





jimport('joomla.form.formfield');





class JFormFieldUpdate extends JFormField {


	protected $type = 'Update';





	protected function getInput() {


		return '<div id="gk_module_updates"></div>';


	}


}





?>