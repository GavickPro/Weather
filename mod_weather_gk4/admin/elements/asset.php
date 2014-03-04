<?php





defined('JPATH_BASE') or die;





jimport('joomla.form.formfield');





class JFormFieldAsset extends JFormField {


        protected $type = 'Asset';





        protected function getInput() {


                $doc = JFactory::getDocument();


                $doc->addScript(JURI::root().$this->element['path'].'script.js');


                $doc->addStyleSheet(JURI::root().$this->element['path'].'style.css');        


                return null;


        }


}





?>