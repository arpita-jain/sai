<?php
/**
 * Description of Config
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Admin_Config extends Wpjb_Controller_Admin
{
    public function indexAction()
    {

    }

    public function editAction()
    {
        $section = $this->_request->getParam("section");

        $fArr = array("payment", "posting", "frontend", "seo", "integration", "resume");
        $fList = array();

        if($section === null || !in_array($section, $fArr)) {
            foreach($fArr as $key) {
                $class = "Wpjb_Form_Admin_Config_".ucfirst($key);
                $fList[$key] = new $class;
            }
        } else {
            $class = "Wpjb_Form_Admin_Config_".ucfirst($section);
            $fList[$section] = new $class;
        }

        if($this->isPost()) {
            $isValid = true;
            foreach($fList as $k => $obj) {
                if(!$obj->isValid($this->_request->getAll())) {
                    $isValid = false;
                }
                $fList[$k] = $obj;
            }
            if($isValid) {
                $instance = Wpjb_Project::getInstance();
                foreach($fList as $k => $obj) {
                    // @todo: save config
                    foreach($obj->getValues() as $k => $v) {
                        $instance->setConfigParam($k, $v);
                    }
                }
                $instance->saveConfig();
                $this->_addInfo(__("Configuration saved.", WPJB_DOMAIN));
            } else {
                $this->_addError(__("There are errors in the form.", WPJB_DOMAIN));
            }
        }

        $this->view->fList = $fList;
    }
}

?>