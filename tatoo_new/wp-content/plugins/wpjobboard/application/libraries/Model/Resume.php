<?php
/**
 * Description of Employer
 *
 * @author greg
 * @package
 */

class Wpjb_Model_Resume extends Daq_Db_OrmAbstract
{
    const ACCOUNT_ACTIVE = 1;

    const ACCOUNT_INACTIVE = 0;


    const RESUME_PENDING  = 1;
    const RESUME_DECLINED = 2;
    const RESUME_APPROVED = 3;

    protected $_name = "wpjb_resume";

    protected static $_current = null;

    protected $_fields = null;

    protected $_textareas = null;

    protected function _init()
    {
        $this->_reference["users"] = array(
            "localId" => "user_id",
            "foreign" => "Wpjb_Model_User",
            "foreignId" => "ID",
            "type" => "ONE_TO_ONE"
        );
        $this->_reference["category"] = array(
            "localId" => "category_id",
            "foreign" => "Wpjb_Model_Category",
            "foreignId" => "id",
            "type" => "ONE_TO_ONE"
        );

    }

    public function hasActiveProfile()
    {

        if(!$this->is_active) {
            return false;
        }

        if(!$this->is_approved) {
            return false;
        }

        return true;
    }

    /**
     * Returns currently loggedin user employer object
     *
     * @return Wpjb_Model_Employer
     */
    public static function current()
    {
        if(self::$_current instanceof self) {
            return self::$_current;
        }

        $current_user = wp_get_current_user();

        if($current_user->ID < 1) {
            return new self;
        }

        $query = new Daq_Db_Query();
        $object = $query->select()->from(__CLASS__." t")
            ->where("user_id = ?", $current_user->ID)
            ->limit(1)
            ->execute();

        if($object[0]) {
            self::$_current = $object[0];
            return self::$_current;
        }

        // quick create
        $object = new self();
        $object->user_id = $current_user->ID;

        $object->save();

        self::$_current = $object;

        return $object;
    }

    public function hasImage()
    {
        if(strlen($this->image_ext)>0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteImage()
    {
        if($this->hasImage()) {
            $file = $this->getImagePath();
            if(file_exists($file)) {
                unlink($file);
            }
            $this->image_ext = "";
        }
    }

    public function getImageUrl()
    {
        if($this->hasImage()) {
            $url = site_url();
            $url.= "/wp-content/plugins/wpjobboard";
            $url.= Wpjb_List_Path::getRawPath("resume_photo");
            $url.= "/photo_".$this->getId().".".$this->image_ext;
            return $url;
        }
        return null;
    }

    public function getImagePath()
    {
        if($this->hasImage()) {
            $url = Wpjb_List_Path::getPath("resume_photo");
            $url.= "/photo_".$this->getId().".".$this->image_ext;
            return $url;
        }
        return null;
    }

    public function delete()
    {
        $this->deleteImage();
        parent::delete();
    }

    /**
     * Returns additional field
     *
     * @param int $id
     * @return Wpjb_Model_AffitionalField
     * @throws Exception If field with given id does not exist
     */
    public function getFieldById($id)
    {
        $this->_loadAdditionalFields();
        
        foreach($this->_fields as $field) {
            if($field->getId() == $id) {
                return $field;
            }
        }

        foreach($this->_textareas as $field) {
            if($field->getId() == $id) {
                return $field;
            }
        }

        throw new Exception("Field identified by ID: $id does not exist.");
    }
    
    public function getFieldValue($id)
    {
        try {
            $field = $this->getFieldById($id);
            return $field->value;
        } catch(Exception $e) {
            return null;
        }
    }
    
    public function getFields()
    {
        if($this->_fields == null) {
            $this->_loadAdditionalFields();
        }
        return $this->_fields;
    }
    
    public function getNonEmptyFields()
    {
        $fields = $this->getFields();
        $fArr = array();
        foreach($fields as $field) {
            /* @var $field Wpjb_Model_FieldValue */
            $value = trim($field->getTextValue());
            if(!empty($value)) {
                $fArr[] = $field;
            }
        }
        return $fArr;
    }

    public function getTextareas()
    {
        if($this->_textareas == null) {
            $this->_loadAdditionalFields();
        }
        return $this->_textareas;
    }
    
    public function getNonEmptyTextareas()
    {
        $textareas = $this->getTextareas();
        $fArr = array();
        foreach($textareas as $field) {
            /* @var $field Wpjb_Model_FieldValue */
            $value = trim($field->value);
            if(!empty($value)) {
                $fArr[] = $field;
            }
        }
        return $fArr;
    }

    public function _loadAdditionalFields()
    {
        $query = new Daq_Db_Query();
        $fields = $query->select("*")
            ->from("Wpjb_Model_FieldValue t")
            ->join("t.field t3")
            ->where("t3.field_for = 3")
            ->where("t3.is_active = 1")
            ->where("t.job_id = ?", $this->getId())
            ->execute();

        $this->_fields = array();
        $this->_textareas = array();

        foreach($fields as $field) {
            if($field->getField()->type != Daq_Form_Element::TYPE_TEXTAREA) {
                $this->_fields[] = $field;
            } else {
                $this->_textareas[] = $field;
            }
        }
    }
    
    public function allToArray()
    {
        $arr = parent::toArray();
        
        $field = (array)$this->getNonEmptyFields();
        $txtar = (array)$this->getNonEmptyTextareas();
        
        foreach($field as $f) {
            $arr["field_".$f->field_id] = $f->value;
        }
        
        foreach($txtar as $f) {
            $arr["field_".$f->field_id] = $f->value;
        }
        
        return $arr;
    }

    /**
     * Renders and returns HTML plain version of resume
     *
     * @return string
     */
    public function renderHTML()
    {
        $instance = Wpjb_Project::getInstance();
        $resume = $this;
        $name = $resume->firstname." ".$resume->lastname;
        $view = new Daq_View($instance->env("template_base")."resumes");
        $view->set("resume", $resume);
        $view->set("can_browse", true);
        $instance->placeHolder = $view;
        ob_start();
        $view->render("resume-min.php");
        $rendered = ob_get_clean();

        return $rendered;
    }

    public function save()
    {
        
        static $called = 0;
        $called++;
        if ($called > 1) return;

        $toSave = array();
        foreach($this->_field as $key => $value) {
            if($value['modified']) {
                $toSave[$key] = maybe_serialize($value['value']);
            }
        }

        if (!array_key_exists('category_id', $_POST)) {
            $toSave['category_id'] = serialize(array());
        }

        // print_r($_POST);
        // echo ' -------------------------------**---------------------------------- ';
        // print_rr($this->_field);
        // echo ' ------------------------------------------------------------------ ';
        // print_rr($toSave);
        // die('DEAD MAN');

        $table = $this->tableName();
        $wp = Daq_Db::getInstance()->getDb();
        if($this->getId() > 0) {

            if (count($_POST) > 0) {
                if (!array_key_exists('category_id', $_POST)) {
                    $toSave['category_id'] = serialize(array());
                }
            } else if ( !array_key_exists('category_id', $this->_field) ) {
                $toSave['category_id'] = serialize(array());
            }

            $wp->update($table, $toSave, array($this->_primary => $this->getId()));
            return $this->getId();
        } else {

            if (array_key_exists('category_id', $this->_field)) {
                if (!array_key_exists('value', $this->_field['category_id']) || !$this->_field['category_id']['value'])
                    $toSave['category_id'] = serialize(array());
            }

            $wp->insert($table, $toSave);
            $this->set($this->_primary, $wp->insert_id);
            return $wp->insert_id;
        }

    }

    public function getCategory($param) {
        $value = $this->_reference['category'];
        if(!isset($this->_loaded[$value['foreign']])) {
            if($param == true) {
                $class = $value['foreign'];
                $local = $value['localId'];
                
                $query = new Daq_Db_Query();
                $query->select()->from($class." t");
                $category_ids = maybe_unserialize($this->$local);
                if (is_array($category_ids)) {
                    foreach ($category_ids as $category_id) {
                        $query->orWhere('t.'.$value['foreignId']." = ?", (int)$category_id);
                    }
                }
                
                //echo "SQL: ".$query->toString();

                if(isset($value['with'])) {
                    $query->where($value['with']);
                }

                $result = $query->execute();
                $this->_loaded[$value['foreign']] = new $class;
                $final_result = array();
                if(!empty($result)) {

                    foreach($result as $row) $final_result[] = $row;
                    $this->_loaded[$value['foreign']] = $final_result;
                }
            } else {
                throw new Exception("Object {$value['foreign']} not loaded for class ".__CLASS__);
            }
        }
        return $this->_loaded[$value['foreign']];
    }

}

?>