<?php
/**
 * Description of Index
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Admin_Job extends Wpjb_Controller_Admin
{
    public function init()
    {
       $this->_virtual = array(
            "editAction" => array(
                "form" => "Wpjb_Form_Admin_AddJob",
                "info" => __("Form saved.", WPJB_DOMAIN),
                "error" => __("There are errors in your form.", WPJB_DOMAIN)
            ),
            "_delete" => array(
                "model" => "Wpjb_Model_Job",
                "info" => __("Job deleted.", WPJB_DOMAIN),
                "error" => __("Job could not be deleted.", WPJB_DOMAIN)
            ),
            "_multi" => array(
                "delete" => array(
                    "success" => __("Number of deleted jobs: {success}", WPJB_DOMAIN)
                ),
                "activate" => array(
                    "success" => __("Number of activated jobs: {success}", WPJB_DOMAIN)
                ),
                "deactivate" => array(
                    "success" => __("Number of deactivated jobs: {success}", WPJB_DOMAIN)
                ),
                "approve" => array(
                    "success" => __("Number of approved jobs: {success}", WPJB_DOMAIN)
                )
            ),
            "_multiDelete" => array(
                "model" => "Wpjb_Model_Job"
            )
        );
    }

    private function _employers()
    {
        
    }

    public function indexAction()
    {
        $this->_delete();
        $this->_multi();
        $this->_employers();

        $page = (int)$this->_request->get("page", 1);
        if($page < 1) {
            $page = 1;
        }
        $perPage = $this->_getPerPage();
        $qstring = array();

        $employer = 0;
        if($this->_request->get("employer") > 0) {
            $emp = new Wpjb_Model_Employer($this->_request->get("employer"));
            if($emp->getId() > 0) {
                $employer = $emp->getId();
                $this->view->company = $emp;
                $this->view->repr = $emp->getUsers(true);
                $qstring['employer'] = $employer;
            }
        }
        //die(' I COME HERE');
        $show = $this->_request->get("show", "all");
        $days = $this->_request->post("days", null);
        if($days === null) {
            $days = $this->_request->get("days", "");
        }

        $query1 = new Daq_Db_Query();
        $query1->select("*")->from("Wpjb_Model_Job t1")
            ->join("t1.category t2")
            ->join("t1.type t3");

        $query2 = new Daq_Db_Query();
        $query2->select("COUNT(*) AS total")
            ->from("Wpjb_Model_Job t1")
            ->join("t1.category t2")
            ->join("t1.type t3");

        if($show == "active") {
            $query1->where("t1.is_active = 1");
            $query1->where("(t1.job_created_at > DATE_SUB(NOW(), INTERVAL t1.job_visible DAY)");
            $query1->orWhere("t1.job_visible = 0)");
            $query2->where("t1.is_active = 1");
            $query2->where("(t1.job_created_at > DATE_SUB(NOW(), INTERVAL t1.job_visible DAY)");
            $query2->orWhere("t1.job_visible = 0)");
        } elseif($show == "inactive") {
            $query1->where("t1.is_active = 0");
            $query1->orWhere("(t1.job_created_at < DATE_SUB(NOW(), INTERVAL t1.job_visible DAY)");
            $query1->Where("t1.job_visible > 0)");
            $query2->where("t1.is_active = 0");
            $query2->orWhere("(t1.job_created_at < DATE_SUB(NOW(), INTERVAL t1.job_visible DAY)");
            $query2->Where("t1.job_visible > 0)");
        } elseif($show == "awaiting") {
            $query1->where("t1.is_approved = 0");
            $query1->where("t1.is_active = 0");
            $query2->where("t1.is_approved = 0");
            $query2->where("t1.is_active = 0");
        }

        if(is_numeric($days)) {
            $query1->where("t1.job_created_at > DATE_SUB(NOW(), INTERVAL ? DAY)", $days);
            $query2->where("t1.job_created_at > DATE_SUB(NOW(), INTERVAL ? DAY)", $days);
        }
        if($employer > 0) {
            $query1->where("t1.employer_id = ?", $employer);
            $query2->where("t1.employer_id = ?", $employer);
        }
        //echo $query1->toString();

        $sql1 = <<<SQL
        SELECT t1.id AS t1__id, t1.company_name AS t1__company_name, t1.company_website AS t1__company_website, t1.company_email AS t1__company_email, 
        t1.company_logo_ext AS t1__company_logo_ext, t1.job_type AS t1__job_type, t1.job_category AS t1__job_category, t1.job_source AS t1__job_source, 
        t1.job_country AS t1__job_country, t1.job_state AS t1__job_state, t1.job_zip_code AS t1__job_zip_code, t1.job_location AS t1__job_location, 
        t1.job_limit_to_country AS t1__job_limit_to_country, t1.job_title AS t1__job_title, t1.job_slug AS t1__job_slug, t1.job_visible AS t1__job_visible, 
        t1.job_created_at AS t1__job_created_at, t1.job_expires_at AS t1__job_expires_at, t1.job_modified_at AS t1__job_modified_at, 
        t1.job_description AS t1__job_description, t1.is_approved AS t1__is_approved, t1.is_active AS t1__is_active, t1.is_filled AS t1__is_filled, 
        t1.is_featured AS t1__is_featured, t1.payment_sum AS t1__payment_sum, t1.payment_paid AS t1__payment_paid, t1.payment_currency AS t1__payment_currency, 
        t1.payment_discount AS t1__payment_discount, t1.stat_views AS t1__stat_views, t1.stat_unique AS t1__stat_unique, t1.stat_apply AS t1__stat_apply, 
        t1.employer_id AS t1__employer_id, t1.discount_id AS t1__discount_id, t1.geo_status AS t1__geo_status, t1.geo_latitude AS t1__geo_latitude, 
        t1.geo_longitude AS t1__geo_longitude, t2.id AS t2__id, t2.slug AS t2__slug, t2.title AS t2__title, t2.description AS t2__description, 
        t3.id AS t3__id, t3.slug AS t3__slug, t3.title AS t3__title, t3.description AS t3__description, t3.color AS t3__color 
        FROM `wpjb_job` AS `t1` INNER JOIN `wpjb_category` AS `t2` ON `t1`.`job_category` REGEXP CONCAT('i:[[:digit:]]+;s:[[:digit:]]+:"', t2.id, '"') 
        INNER JOIN `wpjb_type` AS `t3` ON `t1`.`job_type`=`t3`.`id`
        #WHERE#
        GROUP BY t1.id
        #ORDER#
        #LIMIT#
SQL;


        $result = $query1
            ->order("t1.job_created_at DESC")
            ->limitPage($page, $perPage)
            ->execute($sql1);

        /*$total = $query2
            ->limit(1)
            ->fetchColumn();*/

        $total = $query2
            ->limit(1)
            ->fetchCount($sql1);

        //echo 'TOTAL'. $total;
        $this->view->employer = $employer;

        $this->view->days = $days;
        $this->view->show = $show;
        $this->view->current = $page;
        $this->view->total = ceil($total/$perPage);
        $this->view->data = $result;

        $query = new Daq_Db_Query();
        $list = array(
            "COUNT(*) AS c_total",
            "SUM(t1.is_approved) AS c_awaiting"
        );
        $query->select(join(", ", $list));
        $query->from("Wpjb_Model_Job t1");

        if(is_numeric($days)) {
            $query->where("t1.job_created_at > DATE_SUB(NOW(), INTERVAL ? DAY)", $days);
            $qstring['days'] = $days;
        }
        if($employer > 0) {
            $query->where("t1.employer_id = ?", $employer);
        }
        $summary1 = $query->fetch();

        $query = new Daq_Db_Query();
        $query = $query->select("COUNT(*) AS c_active")
            ->from("Wpjb_Model_Job t1")
            ->where("t1.is_active = 1")
            ->where("t1.is_approved = 1")
            ->where("(t1.job_created_at > DATE_SUB(NOW(), INTERVAL t1.job_visible DAY)")
            ->orWhere("t1.job_visible = 0)");

        if(is_numeric($days)) {
            $query->where("t1.job_created_at > DATE_SUB(NOW(), INTERVAL ? DAY)", $days);
        }
        if($employer > 0) {
            $query->where("t1.employer_id = ?", $employer);
        }

        $summary2 = $query->fetch();

        $stat = new stdClass;
        $stat->total = $summary1->c_total;
        $stat->active = $summary2->c_active;
        $stat->inactive = $summary1->c_total - $summary2->c_active;
        $stat->awaiting = $summary1->c_total - $summary1->c_awaiting;

        $this->view->stat = $stat;

        $qs = "";
        foreach($qstring as $k => $v) {
            $qs.= $k."/".esc_html((string)$v);
        }
        $this->view->qstring = $qs;

    }

    public function editAction()
    {
        if($this->_request->post("remove_image") == 1) {
            $id = $this->_request->post("id");
            $job = new Wpjb_Model_Job($id);
            $job->deleteImage();
            $job->save();
            
            Wpjb_Form_Admin_AddJob::$isAdmin = true;
            $form = new Wpjb_Form_Admin_AddJob($id);
            $form->init();
            $this->view->form = $form;
            Wpjb_Form_Admin_AddJob::$isAdmin = false;
        } else {
            Wpjb_Form_Admin_AddJob::$isAdmin = true;
            parent::editAction();
            Wpjb_Form_Admin_AddJob::$isAdmin = false;
        }
    }

    public function introAction()
    {
        
    }

    protected function _multiActivate($id)
    {
        $object = new Wpjb_Model_Job($id);
        $object->is_approved = 1;
        $object->is_active = 1;
        $object->save();
        return true;
    }

    protected function _multiDeactivate($id)
    {
        $object = new Wpjb_Model_Job($id);
        $object->is_active = 0;
        $object->save();
        return true;
    }

    protected function _multiApprove($id)
    {
        $object = new Wpjb_Model_Job($id);
        $object->is_approved = 1;
        $object->save();
        return true;
    }
}

?>