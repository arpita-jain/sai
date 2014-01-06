<?php
/**
 * Description of Index
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Frontend_Index extends Wpjb_Controller_Frontend
{
    private $_query = null;

    private $_perPage = 20;

    public function init()
    {
        $this->_perPage = Wpjb_Project::getInstance()->conf("front_jobs_per_page", 20);
        $this->_query = Wpjb_Model_Job::activeSelect();
        
    }

    private function _setTitle($text, $param = array())
    {
        $k = array();
        $v = array();
        foreach($param as $key => $value) {
            $k[] = "{".$key."}";
            $v[] = $value;
        }

        Wpjb_Project::getInstance()->title = rtrim(str_replace($k, $v, $text))." ";
    }

    private function _countAll(Daq_Db_Query $query)
    {
        $q = clone $query;
        return (int)$q->select("COUNT(*) AS cnt")->limit(1)->fetchColumn();
    }

    private function _exec(Daq_Db_Query $query, $sql = '')
    {
        $page = $this->_request->getParam("page", 1);

        // @todo: filter

        $this->view->jobPage = $page;
        $this->view->jobCount = ceil($this->_countAll($query)/$this->_perPage);

        if ($sql) {
            $this->view->jobCount = ceil($query->fetchCount($sql)/$this->_perPage);
        }

        $query->limitPage($page, $this->_perPage);
        $this->view->jobList = $query->execute($sql);
    }

    public function indexAction()
    {
        $text = Wpjb_Project::getInstance()->conf("seo_job_board_name", __("Job Board", WPJB_DOMAIN));
        $this->_setTitle($text);
        $router = $this->_getRouter();
        $this->setCanonicalUrl(Wpjb_Project::getInstance()->getUrl());

        $query = clone $this->_query;
        $query->join("t1.category t2")->join("t1.type t3");
        $sql = <<<SQL
         SELECT t1.id AS t1__id, t1.company_name AS t1__company_name, t1.company_website AS t1__company_website,
         t1.company_email AS t1__company_email, t1.company_logo_ext AS t1__company_logo_ext, t1.job_type AS t1__job_type,
         t1.job_category AS t1__job_category, t1.job_source AS t1__job_source, t1.job_country AS t1__job_country,
         t1.job_state AS t1__job_state, t1.job_zip_code AS t1__job_zip_code, t1.job_location AS t1__job_location,
         t1.job_limit_to_country AS t1__job_limit_to_country, t1.job_title AS t1__job_title, t1.job_slug AS t1__job_slug,
         t1.job_visible AS t1__job_visible, t1.job_created_at AS t1__job_created_at, t1.job_expires_at AS t1__job_expires_at,
         t1.job_modified_at AS t1__job_modified_at, t1.job_description AS t1__job_description, t1.is_approved AS t1__is_approved,
         t1.is_active AS t1__is_active, t1.is_filled AS t1__is_filled, t1.is_featured AS t1__is_featured, t1.payment_sum AS t1__payment_sum,
         t1.payment_paid AS t1__payment_paid, t1.payment_currency AS t1__payment_currency, t1.payment_discount AS t1__payment_discount,
         t1.stat_views AS t1__stat_views, t1.stat_unique AS t1__stat_unique, t1.stat_apply AS t1__stat_apply, t1.employer_id AS t1__employer_id,
         t1.discount_id AS t1__discount_id, t1.geo_status AS t1__geo_status, t1.geo_latitude AS t1__geo_latitude,
         t1.geo_longitude AS t1__geo_longitude, t2.id AS t2__id, t2.slug AS t2__slug, t2.title AS t2__title, t2.description AS t2__description,
         t3.id AS t3__id, t3.slug AS t3__slug, t3.title AS t3__title, t3.description AS t3__description, t3.color AS t3__color
         FROM `wpjb_job` AS `t1` INNER JOIN `wpjb_category` AS `t2` ON `t1`.`job_category` REGEXP CONCAT('i:[[:digit:]]+;s:[[:digit:]]+:"', t2.id, '"') OR `t1`.`job_category` = 'a:0:{}'
         INNER JOIN `wpjb_type` AS `t3` ON `t1`.`job_type`=`t3`.`id`
         #WHERE#
         GROUP BY t1.id
         #ORDER#
         #LIMIT#
SQL;

        //echo "SQL: ".$query->toString();
        $this->view->cDir = "";
        $this->_exec($query, $sql);
    }

    public function companyAction()
    {
        $company = $this->getObject();
        /* @var $company Wpjb_Model_Employer */

        $text = Wpjb_Project::getInstance()->conf("seo_job_employer", __("{company_name}", WPJB_DOMAIN));
        $param = array(
            'company_name' => $this->getObject()->company_name
        );
        $this->_setTitle($text, $param);

        if($company->is_active == Wpjb_Model_Employer::ACCOUNT_INACTIVE) {
            $this->view->_flash->addError(__("Company profile is inactive.", WPJB_DOMAIN));
        } elseif(!$company->is_public) {
            $this->view->_flash->addInfo(__("Company profile is hidden.", WPJB_DOMAIN));
        } elseif(!$company->isVisible()) {
            $this->view->_flash->addError(__("Company profile will be visible once employer will post at least one job.", WPJB_DOMAIN));
            return false;
        }

        $this->view->company = $company;

        $jList = clone $this->_query;
        $jList->order("job_created_at DESC");
        $this->view->jobList = $jList->where("employer_id = ?", $company->getId())->execute();
    }

    public function categoryAction()
    {
        $text = Wpjb_Project::getInstance()->conf("seo_category", __("Primary Style: {category}", WPJB_DOMAIN));
        $param = array(
            'category' => $this->getObject()->title
        );

        $url = Wpjb_Project::getInstance()->getUrl()."/";
        $url.= $this->_getRouter()->linkTo("category", $this->getObject());
        $this->setCanonicalUrl($url);

        $this->view->current_category = $this->getObject();
        $this->_setTitle($text, $param);

        $object = $this->getObject();
        $query = clone $this->_query;
        $query->join("t1.category t2", "t2.id=".$object->getId())->join("t1.type t3");
        $sql = <<<SQL
        SELECT t1.id AS t1__id, t1.company_name AS t1__company_name, t1.company_website AS t1__company_website,
        t1.company_email AS t1__company_email, t1.company_logo_ext AS t1__company_logo_ext, t1.job_type AS t1__job_type,
        t1.job_category AS t1__job_category, t1.job_source AS t1__job_source, t1.job_country AS t1__job_country,
        t1.job_state AS t1__job_state, t1.job_zip_code AS t1__job_zip_code, t1.job_location AS t1__job_location,
        t1.job_limit_to_country AS t1__job_limit_to_country, t1.job_title AS t1__job_title, t1.job_slug AS t1__job_slug,
        t1.job_visible AS t1__job_visible, t1.job_created_at AS t1__job_created_at, t1.job_expires_at AS t1__job_expires_at,
        t1.job_modified_at AS t1__job_modified_at, t1.job_description AS t1__job_description, t1.is_approved AS t1__is_approved,
        t1.is_active AS t1__is_active, t1.is_filled AS t1__is_filled, t1.is_featured AS t1__is_featured, t1.payment_sum AS t1__payment_sum,
        t1.payment_paid AS t1__payment_paid, t1.payment_currency AS t1__payment_currency, t1.payment_discount AS t1__payment_discount,
        t1.stat_views AS t1__stat_views, t1.stat_unique AS t1__stat_unique, t1.stat_apply AS t1__stat_apply, t1.employer_id AS t1__employer_id,
        t1.discount_id AS t1__discount_id, t1.geo_status AS t1__geo_status, t1.geo_latitude AS t1__geo_latitude,
        t1.geo_longitude AS t1__geo_longitude, t2.id AS t2__id, t2.slug AS t2__slug, t2.title AS t2__title, t2.description AS t2__description,
        t3.id AS t3__id, t3.slug AS t3__slug, t3.title AS t3__title, t3.description AS t3__description, t3.color AS t3__color
        FROM `wpjb_job` AS `t1` INNER JOIN `wpjb_category` AS `t2` ON t2.id={$object->getId()} AND `t1`.`job_category` REGEXP CONCAT('i:[[:digit:]]+;s:[[:digit:]]+:"', {$object->getId()}, '"')
        INNER JOIN `wpjb_type` AS `t3` ON `t1`.`job_type`=`t3`.`id`
        #WHERE#
        #ORDER#
        #LIMIT#
SQL;
        //echo "SQL: ".$query->toString();
        $this->view->cDir = Wpjb_Project::getInstance()->router()->linkTo("category", $this->getObject());
        $this->_exec($query, $sql);
        return "index";
    }

    public function typeAction()
    {
        $text = Wpjb_Project::getInstance()->conf("seo_job_type", __("Job Type: {type}", WPJB_DOMAIN));
        $param = array(
            'type' => $this->getObject()->title
        );

        $url = Wpjb_Project::getInstance()->getUrl()."/";
        $url.= $this->_getRouter()->linkTo("jobtype", $this->getObject());
        $this->setCanonicalUrl($url);

        $this->view->current_type = $this->getObject();
        $this->_setTitle($text, $param);

        $object = $this->getObject();
        $query = clone $this->_query;
        $query->join("t1.category t2")->join("t1.type t3", "t3.id=".$object->getId());
        $sql = <<<SQL
        SELECT t1.id AS t1__id, t1.company_name AS t1__company_name, t1.company_website AS t1__company_website,
        t1.company_email AS t1__company_email, t1.company_logo_ext AS t1__company_logo_ext, t1.job_type AS t1__job_type,
        t1.job_category AS t1__job_category, t1.job_source AS t1__job_source, t1.job_country AS t1__job_country,
        t1.job_state AS t1__job_state, t1.job_zip_code AS t1__job_zip_code, t1.job_location AS t1__job_location,
        t1.job_limit_to_country AS t1__job_limit_to_country, t1.job_title AS t1__job_title, t1.job_slug AS t1__job_slug,
        t1.job_visible AS t1__job_visible, t1.job_created_at AS t1__job_created_at, t1.job_expires_at AS t1__job_expires_at,
        t1.job_modified_at AS t1__job_modified_at, t1.job_description AS t1__job_description, t1.is_approved AS t1__is_approved,
        t1.is_active AS t1__is_active, t1.is_filled AS t1__is_filled, t1.is_featured AS t1__is_featured, t1.payment_sum AS t1__payment_sum,
        t1.payment_paid AS t1__payment_paid, t1.payment_currency AS t1__payment_currency, t1.payment_discount AS t1__payment_discount,
        t1.stat_views AS t1__stat_views, t1.stat_unique AS t1__stat_unique, t1.stat_apply AS t1__stat_apply, t1.employer_id AS t1__employer_id,
        t1.discount_id AS t1__discount_id, t1.geo_status AS t1__geo_status, t1.geo_latitude AS t1__geo_latitude,
        t1.geo_longitude AS t1__geo_longitude, t2.id AS t2__id, t2.slug AS t2__slug, t2.title AS t2__title,
        t2.description AS t2__description, t3.id AS t3__id, t3.slug AS t3__slug, t3.title AS t3__title,
        t3.description AS t3__description, t3.color AS t3__color FROM `wpjb_job` AS `t1`
        INNER JOIN `wpjb_category` AS `t2` ON `t1`.`job_category` REGEXP CONCAT('i:[[:digit:]]+;s:[[:digit:]]+:"', t2.id, '"') OR `t1`.`job_category` = 'a:0:{}'
        INNER JOIN `wpjb_type` AS `t3` ON `t1`.`job_type`=`t3`.`id` AND t3.id={$object->getId()}
        #WHERE#
        GROUP BY t1.id
        #ORDER#
        #LIMIT#
SQL;
        //echo "SQL: ".$query->toString();
        $this->view->cDir = Wpjb_Project::getInstance()->router()->linkTo("jobtype", $this->getObject());
        $this->_exec($query, $sql);
        return "index";
    }

    public function searchAction()
    {
        $request = $this->getRequest();

        $text = Wpjb_Project::getInstance()->conf("seo_search_results", __("Search Results: {keyword}", WPJB_DOMAIN));
        $param = array(
            'keyword' => $request->get("query")
        );
        $this->_setTitle($text, $param);

        $request = Daq_Request::getInstance();
        
        $param = array(
            "query" => $request->get("query"),
            "category" => $request->get("category"),
            "type" => $request->get("type"),
            "page" => $request->get("page", 1),
            "count" => $request->get("count", 20),
            "country" => $request->get("country"),
            "posted" => $request->get("posted"),
            "location" => $request->get("location"),
            "is_featured" => $request->get("is_featured"),
            "employer_id" => $request->get("employer_id"),
            "field" => $request->get("field", array()),
            "sort" => $request->get("sort"),
            "order" => $request->get("order"),
        );
        
        $result = Wpjb_Model_JobSearch::search($param);

        $this->view->jobPage = $result->page;
        $this->view->jobCount = ceil($result->total/$result->perPage);
        $this->view->jobList = $result->job;
        
        $router = Wpjb_Project::getInstance()->router();
        $this->view->cDir = $router->linkTo("search", null, $param);
        $this->view->qString = $this->getServer("QUERY_STRING");
        
        return "index";
    }

    public function advsearchAction()
    {
        $this->_setTitle(Wpjb_Project::getInstance()->conf("seo_adv_search", __("Advanced Search", WPJB_DOMAIN)));
        $form = new Wpjb_Form_AdvancedSearch();
        
        $this->view->form = $form;
        return "search";
    }

    public function singleAction()
    {
        $this->_setTitle(" ");
        $job = $this->getObject();

        $url = Wpjb_Project::getInstance()->getUrl()."/";
        $url.= $this->_getRouter()->linkTo("job", $job);
        $this->setCanonicalUrl($url);
        
        $show_related = (bool)Wpjb_Project::getInstance()->conf("front_show_related_jobs");
        $this->view->show_related = $show_related;

        if(($job->is_active && $job->is_approved) || $this->_isUserAdmin()) {
            // reload job with category and type
            $query = new Daq_Db_Query();
            /*$job = $query->select("*")
                ->from("Wpjb_Model_Job t")
                ->join("t.category t2")
                ->join("t.type t3")
                ->where("t.id = ?", $job->getId())->execute();*/

            $query->select("*")
                ->from("Wpjb_Model_Job t")
                ->join("t.category t2")
                ->join("t.type t3")
                ->where("t.id = ?", $job->getId());

            $sql = <<<SQL
                SELECT t.id AS t__id, t.company_name AS t__company_name, t.company_website 
                AS t__company_website, t.company_email AS t__company_email, t.company_logo_ext 
                AS t__company_logo_ext, t.job_type AS t__job_type, t.job_category 
                AS t__job_category, t.job_source AS t__job_source, t.job_country 
                AS t__job_country, t.job_state AS t__job_state, t.job_zip_code AS t__job_zip_code, t.job_location 
                AS t__job_location, t.job_limit_to_country AS t__job_limit_to_country, t.job_title 
                AS t__job_title, t.job_slug AS t__job_slug, t.job_visible AS t__job_visible, t.job_created_at 
                AS t__job_created_at, t.job_expires_at AS t__job_expires_at, t.job_modified_at 
                AS t__job_modified_at, t.job_description AS t__job_description, t.is_approved 
                AS t__is_approved, t.is_active AS t__is_active, t.is_filled AS t__is_filled, t.is_featured 
                AS t__is_featured, t.payment_sum AS t__payment_sum, t.payment_paid AS t__payment_paid, t.payment_currency 
                AS t__payment_currency, t.payment_discount AS t__payment_discount, t.stat_views AS t__stat_views, t.stat_unique 
                AS t__stat_unique, t.stat_apply AS t__stat_apply, t.employer_id AS t__employer_id, t.discount_id 
                AS t__discount_id, t.geo_status AS t__geo_status, t.geo_latitude AS t__geo_latitude, t.geo_longitude 
                AS t__geo_longitude, t2.id AS t2__id, t2.slug AS t2__slug, t2.title AS t2__title, t2.description 
                AS t2__description, t3.id AS t3__id, t3.slug AS t3__slug, t3.title AS t3__title, t3.description 
                AS t3__description, t3.color AS t3__color FROM `wpjb_job` AS `t` INNER JOIN `wpjb_category` AS `t2` 
                ON `t`.`job_category` REGEXP CONCAT('i:[[:digit:]]+;s:[[:digit:]]+:"', t2.id, '"')
                INNER JOIN `wpjb_type` AS `t3` ON `t`.`job_type`=`t3`.`id`
                #WHERE#
                #ORDER#
                #LIMIT#
SQL;
            $temp_job = $query->execute($sql);
            //echo "SQL: ".$query->toString()."<br>";
            /*$temp_job = $query->fetchAll($sql);
            foreach ($temp_job[0] as $k => $v) {
                $job->_field[$k] = $v;
            }*/
            
            if (count($temp_job) > 0) {
                $job = $temp_job;
                $this->view->job = $job[0];
                $job = $job[0];
            } else {
                $job->job_category = null;
                $this->view->job = $job;
            }
            //print_rr($job);
            // $this->view->job = $job[0];
            // $job = $job[0];

            $text = Wpjb_Project::getInstance()->conf("seo_single", __("{job_title}", WPJB_DOMAIN));
            $param = array(
                'job_title' => $job->job_title,
                'id' => $job->id
            );
            $this->_setTitle($text, $param);


            $old = Wpjb_Project::getInstance()->conf("front_mark_as_old");

            if($old>0 && time()-strtotime($job->job_created_at)>$old*3600*24) {
                $msg = __("Attention! This job posting is {$old} days old and might be already filled.",WPJB_DOMAIN);
                $this->view->_flash->addInfo($msg);
            }

            if($job->is_filled) {
                $msg = __("This job posting was marked by employer as filled and is probably no longer available", WPJB_DOMAIN);
                $this->view->_flash->addInfo($msg);
            }

            if($job->employer_id > 0) {
                $this->view->company = new Wpjb_Model_Employer($job->employer_id);
            }
            // related jobs
            $related = clone $this->_query;
            /* @var $related Daq_Db_Query */
            $related->join("t1.search t4");
            $q = "MATCH(t4.title, t4.description, t4.location, t4.company)";
            $q.= "AGAINST (? IN BOOLEAN MODE)";
            $related->where($q, $job->job_title);
            $related->where("t1.id <> ?", $job->getId());
            $related->limit(5);

            $this->view->related = $related->execute();
            

        } else {
            // job inactive or not exists
            $msg = __("Selected job is inactive or does not exist", WPJB_DOMAIN);
            $this->view->_flash->addError($msg);
            $this->view->job = null;
            return false;
        }
        //die( 'DEAD MAN');
    }

    public function applyAction()
    {
        if( !is_user_logged_in() ) {
            $this->view->_flash->addError(__("Please login before applying for jobs", WPJB_DOMAIN));
            return false;
        }
        
        if( mbt_get_user_type() != "artist" ) {
            $this->view->_flash->addError(__("Only Artists can apply for Jobs", WPJB_DOMAIN));
            return false;
        }
        
        $text = Wpjb_Project::getInstance()->conf("seo_apply", __("Apply for position: {job_title} (ID: {id})", WPJB_DOMAIN));
        $param = array(
            'job_title' => $this->getObject()->job_title,
            'id' => $this->getObject()->id
        );
        $this->_setTitle($text, $param);
        
        $job = $this->getObject();
        $this->view->job = $job;

        if(!$this->isMember() && Wpjb_Project::getInstance()->conf("front_apply_members_only", false)) {
            $this->view->members_only = true;
            $this->view->_flash->addError(__("Only registered members can apply for jobs.", WPJB_DOMAIN));
            return;
        }
        
        if($job->job_source == 3) {
            wp_redirect($job->company_website);
        }

        $form = new Wpjb_Form_Apply();
        if($this->isPost()) {
            if($form->isValid($this->getRequest()->getAll())) {
                // send
                $var = $form->getValues();
                $job = $this->getObject();

                $form->setJobId($job->getId());
                $form->setUserId(Wpjb_Model_Resume::current()->user_id);

                $form->save();
                $files = $form->getFiles();
                $application = $form->getObject();

                $mail = new Wpjb_Model_Email(6);
                $append = array(
                    "applicant_email" => $var['email'],
                    "applicant_cv" => $var['resume'],
                    "applicant_name" => $var['applicant_name']
                );
                
                list($title, $body) = Wpjb_Utility_Messanger::parse($mail, $job, $append);
                $add = $form->getAdditionalText();
                if(!empty($add)) {
                    $body .= "\r\n--- --- ---\r\n";
                }
                foreach($add as $field) {

                    if(!$form->hasElement($field)) {
                        continue;
                    }
                    $opt = $form->getElement($field)->getOptions();
                    if(!empty($opt)) {
                        foreach($opt as $o) {
                            if($o["value"] == $form->getElement($field)->getValue()) {
                                $fValue = $o["desc"];
                            }
                        }
                    } else {
                        $fValue = $form->getElement($field)->getValue();
                    }

                    $body .= $form->getElement($field)->getLabel().": ";
                    $body .= $fValue."\r\n";
                }
                $headers = "From: ".$var["applicant_name"]." <".$var["email"].">\r\n";

                $email = $var["email"];

                $title = trim($title);
                if(empty($title)) {
                    $title = __("[Application] ", WPJB_DOMAIN).$var["name"];
                }

                if(apply_filters("wpjb_job_apply", $form) !== true) {
                    wp_mail($job->company_email, $title, $body, $headers, $files);
                }

                $form->reinit();

                $job->stat_apply++;
                $job->save();

                $this->view->application_sent = true;
                $this->view->_flash->addInfo(__("Your application has been sent.", WPJB_DOMAIN));
                Wpjb_Utility_Messanger::send(8, $job, array('applicant_email'=>$var['email']));
            } else {
                $this->view->_flash->addError(__("There are errors in your form.", WPJB_DOMAIN));
            }

        } elseif(Wpjb_Model_Resume::current()->id>0) {
            $resume = Wpjb_Model_Resume::current();
            $form->getElement("email")->setValue($resume->email);
            $form->getElement("applicant_name")->setValue($resume->firstname." ".$resume->lastname);
        }

        $this->view->form = $form;

    }

    public function deleteAlertAction()
    {
        $hash = $this->_request->getParam("hash");
        $query = new Daq_Db_Query();
        $result = $query->select()->from("Wpjb_Model_Alert t")
            ->where("MD5(CONCAT(id, email)) = ?", $hash)
            ->limit(1)
            ->execute();

        if($result[0]) {
            $alert = $result[0];
            /* @var $alert Wpjb_Model_Alert */
            $alert->is_active = 0;
            $alert->save();

            $this->view->_flash->addInfo(__("Alert deleted. You will no longer receive email alerts.", WPJB_DOMAIN));
        } else {
            $this->view->_flash->addError(__("Alert could not be found.", WPJB_DOMAIN));
        }

        $this->indexAction();
        return "index";
    }
    
    public function paymentAction()
    {
        $payment = $this->getObject();
        $button = Wpjb_Payment_Factory::factory($payment);
        
        $this->_setTitle(__("Payment", WPJB_DOMAIN));
        
        if($payment->payment_sum == $payment->payment_paid) {
            $this->view->_flash->addInfo(__("This payment was already processed correctly.", WPJB_DOMAIN));
            return false;
        }
        
        if($payment->object_type == 1) {
            $this->view->job = new Wpjb_Model_Job($payment->object_id);
        }
        
        $this->view->payment = $payment;
        $this->view->button = $button;
        $this->view->currency = Wpjb_List_Currency::getCurrencySymbol($payment->payment_currency);
    }
    
}

?>
