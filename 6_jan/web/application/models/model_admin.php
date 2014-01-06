<?php

/*
 * Class Description
 * Project Name: wegottickets
 * Class name : Model_admin
 * File name Model_admin.php
 */

class Model_admin extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('Model_KioskLibraries');
        $this->load->library('email');
        $this->load->helper('cookie');
    }

    public function logged_in() {
        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from("masterusers");
        $this->db->where('username', $this->input->post('username'));
        $this->db->where('password', md5($this->input->post('password')));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return $query->row_array();
        }
    }

    public function testAuthentication() {
        if ($this->input->cookie("kiosk_token") != "") {
            return true;
        } else {
            $this->session->set_userdata('loginerror', 'Sorry no kiosk installation found , please contact to your supervisor');
            return false;
        }
    }

    public function getOneTicketInfo($id, $transaction_id) {
        $this->db->select('*');
        $this->db->from("orders");
        $this->db->where('order_id', $transaction_id);
        $query = $this->db->get();
        $orderinfo = $query->row_array();

        $this->db->select('*');
        $this->db->from("customers");
        $this->db->where('id', $orderinfo['customerid']);
        $query = $this->db->get();
        $customerinfo = $query->row_array();

        $query = $this->db->query("select *,e.time as event_time, e.date as event_date from order_details o join events e on e.id=o.event_id  where o.ticket_id=" . $id . " and o.order_id=" . $orderinfo['id']);

        $itemsinfo = $query->result_array();

        $data['orderinfo'] = $orderinfo;
        $data['customerinfo'] = $customerinfo;
        $data['itemsinfo'] = $itemsinfo;

        return $data;
    }

    public function getTicketInfo($id) {

        $this->db->select('*');
        $this->db->from("orders");
        $this->db->where('order_id', $id);
        $query = $this->db->get();
        $orderinfo = $query->row_array();

        $this->db->select('*');
        $this->db->from("customers");
        $this->db->where('id', $orderinfo['customerid']);
        $query = $this->db->get();
        $customerinfo = $query->row_array();

        $query = $this->db->query("select *,e.time as event_time, e.date as event_date from order_details o join events e on e.id=o.event_id  where o.order_id=" . $orderinfo['id']);
        $itemsinfo = $query->result_array();

        $data['orderinfo'] = $orderinfo;
        $data['customerinfo'] = $customerinfo;
        $data['itemsinfo'] = $itemsinfo;

        return $data;
    }

    public function getBasketItems() {
        $query = $this->db->query('select b.id as cart_id, b.quantity as quantity,t.stockAvailable as stockAvailable, e.id as event_id,v.id as venue_id,t.id as ticket_id,e.title as title,v.name as name,title,t.type as type,t.price as price from basket b join tickettypes t on t.id=b.item_id join events e on e.id=t.eventId join venues v on v.id=e.venueId where b.user_id=' . $this->session->userdata("admin_id"));
        return $query->result_array();
    }

    public function getBasket() {
        $query = $this->db->query('select quantity ,price,item_id from basket where user_id=' . $this->session->userdata("admin_id"));
        return $query->result();
    }

    public function getStatistics() {
//Get Admins count
        $this->db->where('user_type', 1);
        $this->db->from('masterusers');
        $admins = $this->db->count_all_results();

//Get Masters count
        $this->db->where('user_type', 2);
        $this->db->from('masterusers');
        $masters = $this->db->count_all_results();

//Get Supervisors count
        $this->db->where('user_type', 3);
        $this->db->from('masterusers');
        $supervisors = $this->db->count_all_results();

//Get Users count
        $this->db->where('user_type', 4);
        $this->db->from('masterusers');
        $users = $this->db->count_all_results();

        $statistics = array(
            "admins" => $admins,
            "masters" => $masters,
            "supervisors" => $supervisors,
            "users" => $users
        );

        return $statistics;
    }

    public function sendPassword() {
        $this->db->select('*');
        $this->db->from("masterusers");
        $this->db->where('email', $this->input->post('email'));
        $query = $this->db->get();
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($query->num_rows() > 0) {
            $get_name = $query->row_array();
            $data = array(
                'password' => md5($get_name['id'])
            );
            $this->db->where('id', $get_name['id']);
            $this->db->update('masterusers', $data);
            $this->load->library('email');
            $this->email->from('support@cisinlabs.com', 'Jaswant Singh Jatav');
            $this->email->to($this->input->post('email'));
            $this->email->subject('Forgot password response');
            $this->email->message("<div style='padding:5px 10px ; border:1px dashed #fff; background:#39F; font:12px Arial, Helvetica, sans-serif; color:#fff;'>
            <p><strong>Dear Applicant,</strong></p>
            <table>
            <tr>            
            <td>
             New-password: '" . md5($get_name['id']) . "'
            </td>
            </tr>
            </table>
            <p><strong>Admin,Wegotticket.com</strong></p>
            </div>");
            $query = $this->email->send();
            return $query;
        } else {

            return $query->row_array();
        }
    }

    public function setRememberMe() {
        if ($this->input->post('rememberme')) {
            setcookie("username", $this->input->post('username'));
            setcookie("password", $this->input->post('password'));
        } else {
            if (isset($_COOKIE['password'])) {
                setcookie("username", "");
                setcookie("password", "");
            }
        }
    }

    public function setLastLogin() {
        $data = array(
            'last_login' => date('d-m-Y h:i:s a')
        );
        $this->db->where('id', $this->session->userdata("admin_id"));
        $this->db->update('masterusers', $data);
    }

///Users Actions
    public function viewUser() {

        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from("masterusers");
        $this->db->where('id', $this->input->post('id'));
        $this->db->where('user_type', 4);
        $query = $this->db->get();
        $result = array();
        $result['success'] = "";
        $result['error'] = "";

        if ($query->num_rows() > 0) {
            $result['record'] = $query->row_array();
            $result['success'] = 1;
        } else {
            $result['error'] = "Sorry no such user found in database";
        }

        return json_encode($result);
    }

    public function delUsers() {
        $result = array();
        $result['success'] = "";
        $result['error'] = "";

        $data = array(
            'is_deleted' => 1
        );
        $this->db->where_in('id', $this->input->post('ids'));
        $this->db->where('user_type', 4);
        $foo = $this->db->update('masterusers', $data);
        if ($foo) {
            $result['success'] = $foo;
        } else {
            $result['error'] = "Sorry but record can't deleted !";
        }
        return json_encode($result);
    }

    public function editUser() {
        $data = array(
            'first_name' => $this->input->post('firstname'),
            'last_name' => $this->input->post('lastname'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'username' => $this->input->post('username'),
            'address' => $this->input->post('address')
        );

        $this->db->select('username');
        $this->db->from('masterusers');
        $this->db->where('username', $this->input->post('username'));
        $this->db->where_not_in('id', $this->input->post('id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $returndata = 0;
        } else {
            $this->db->where('id', $this->input->post('id'));
            $this->db->where('user_type', 4);
            $this->db->update('masterusers', $data);
            $returndata = 1;
        }



        return($returndata);
    }

    public function addUser() {

        $foo = "";
        $data = array(
            'first_name' => $this->input->post('firstname'),
            'last_name' => $this->input->post('lastname'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'username' => $this->input->post('username'),
            'address' => $this->input->post('address'),
            'user_type' => 4
        );

        $this->db->select('username');
        $this->db->from('masterusers');
        $this->db->where('username', $this->input->post('username'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
//  $result['error']=  "Sorry  user found in database";
            $returndata = 0;
        } else {
            $this->db->insert('masterusers', $data);
            $returndata = 1;
        }

        return $returndata;
    }

///End of Users actions
///Supervisors Actions
    public function viewSupervisor() {

        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from("masterusers");
        $this->db->where('id', $this->input->post('id'));
        $this->db->where('user_type', 3);
        $query = $this->db->get();
        $result = array();
        $result['success'] = "";
        $result['error'] = "";

        if ($query->num_rows() > 0) {
            $result['record'] = $query->row_array();
            $result['success'] = 1;
        } else {
            $result['error'] = "Sorry no such user found in database";
        }

        return json_encode($result);
    }

    public function delSupervisors() {
        $result = array();
        $result['success'] = "";
        $result['error'] = "";

        $data = array(
            'is_deleted' => 1
        );
        $this->db->where_in('id', $this->input->post('ids'));
        $this->db->where('user_type', 3);
        $foo = $this->db->update('masterusers', $data);
        if ($foo) {
            $result['success'] = $foo;
        } else {
            $result['error'] = "Sorry but record can't deleted !";
        }
        return json_encode($result);
    }

    public function editSupervisor() {
        $data = array(
            'first_name' => $this->input->post('firstname'),
            'last_name' => $this->input->post('lastname'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'username' => $this->input->post('username'),
            'address' => $this->input->post('address')
        );

        $this->db->select('username');
        $this->db->from('masterusers');
        $this->db->where('username', $this->input->post('username'));
        $this->db->where_not_in('id', $this->input->post('id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $returndata = 0;
        } else {
            $this->db->where('id', $this->input->post('id'));
            $this->db->where('user_type', 3);
            $this->db->update('masterusers', $data);
            $returndata = 1;
        }
        return $returndata;
    }

    public function addSupervisor() {
        $data = array(
            'first_name' => $this->input->post('firstname'),
            'last_name' => $this->input->post('lastname'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'password' => md5($this->input->post('password')),
            'username' => ($this->input->post('username')),
            'user_type' => 3
        );

        $this->db->select('username');
        $this->db->from('masterusers');
        $this->db->where('username', $this->input->post('username'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $returndata = 0;
        } else {
            $this->db->insert('masterusers', $data);
            $returndata = 1;
        }

        return $returndata;
    }

///End of Supervisors actions
///Masters Actions
    public function viewMaster() {

        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from("masterusers");
        $this->db->where('id', $this->input->post('id'));
        $this->db->where('user_type', 2);
        $query = $this->db->get();
        $result = array();
        $result['success'] = "";
        $result['error'] = "";

        if ($query->num_rows() > 0) {
            $result['record'] = $query->row_array();
            $result['success'] = 1;
        } else {
            $result['error'] = "Sorry no such user found in database";
        }

        return json_encode($result);
    }

    public function delMasters() {
        $result = array();
        $result['success'] = "";
        $result['error'] = "";

        $data = array(
            'is_deleted' => 1
        );
        $this->db->where_in('id', $this->input->post('ids'));
        $this->db->where('user_type', 2);
        $foo = $this->db->update('masterusers', $data);
        if ($foo) {
            $result['success'] = $foo;
        } else {
            $result['error'] = "Sorry but record can't deleted !";
        }
        return json_encode($result);
    }

    public function editMaster() {
        $data = array(
            'first_name' => $this->input->post('firstname'),
            'last_name' => $this->input->post('lastname'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'username' => $this->input->post('username'),
            'address' => $this->input->post('address')
        );
        $this->db->select('username');
        $this->db->from('masterusers');
        $this->db->where('username', $this->input->post('username'));
        $this->db->where_not_in('id', $this->input->post('id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $returndata = 0;
        } else {
            $this->db->where('id', $this->input->post('id'));
            $this->db->where('user_type', 2);
            $this->db->update('masterusers', $data);
            $returndata = 1;
        }
        return $returndata;
    }

    public function addMaster() {
        $data = array(
            'first_name' => $this->input->post('firstname'),
            'last_name' => $this->input->post('lastname'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'password' => md5($this->input->post('password')),
            'username' => ($this->input->post('username')),
            'user_type' => 2
        );
        $this->db->select('username');
        $this->db->from('masterusers');
        $this->db->where('username', $this->input->post('username'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $returndata = 0;
        } else {
            $this->db->insert('masterusers', $data);
            $returndata = 1;
        }
        return $returndata;
    }

///End of Masters actions
///Admin Actions
    public function viewAdmin() {
        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from("masterusers");
        $this->db->where('id', $this->input->post('id'));
        $this->db->where('user_type', 1);
        $query = $this->db->get();
        $result = array();
        $result['success'] = "";
        $result['error'] = "";

        if ($query->num_rows() > 0) {
            $result['record'] = $query->row_array();
            $result['success'] = 1;
        } else {
            $result['error'] = "Sorry no such user found in database";
        }

        return json_encode($result);
    }

    public function delAdmins() {
        $result = array();
        $result['success'] = "";
        $result['error'] = "";

        $data = array(
            'is_deleted' => 1
        );
        $this->db->where_in('id', $this->input->post('ids'));
        $foo = $this->db->update('masterusers', $data);
        if ($foo) {
            $result['success'] = $foo;
        } else {
            $result['error'] = "Sorry but record can't deleted !";
        }
        return json_encode($result);
    }

    public function editAdmin() {
        $data = array(
            'first_name' => $this->input->post('firstname'),
            'last_name' => $this->input->post('lastname'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'username' => ($this->input->post('username')),
            'address' => $this->input->post('address')
        );
        $this->db->select('username');
        $this->db->from('masterusers');
        $this->db->where('username', $this->input->post('username'));
        $this->db->where_not_in('id', $this->input->post('id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
//  $result['error']=  "Sorry  user found in database";
            $returndata = 0;
        } else {
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('masterusers', $data);
            $returndata = 1;
        }
        return ($returndata);
    }

//Add master group-
    public function addGroup() {
        $data = array(
            'group_name' => $this->input->post('group_name'),
            'super_id' => $this->input->post('supervisor'),
            'description' => $this->input->post('description'),
            'location' => $this->input->post('location')
        );
        return $this->db->insert('mastergroups', $data);
    }

//Add master group-
    public function addKiosk() {
        $foo = 0;
        do {
            $token = $this->generate_alpha_numeric(8);
            $data = array(
                'kiosk_name' => $this->input->post('kiosk_name'),
                'description' => $this->input->post('description'),
                'token' => $token
            );
            $this->input->set_cookie("kiosk_token", $token, time() + 60 * 60 * 24 * 30);
            $foo = $this->db->insert('kiosks', $data);
        } while (!$foo);
        return $foo;
    }

    public function updateKiosk() {
        $data = array(
            'kiosk_name' => $this->input->post('kiosk_name'),
            'description' => $this->input->post('description'),
        );
        $this->db->where('id', $this->input->post('upd_id'));
        return $this->db->update('kiosks', $data);
    }

//View all group- 
    public function getKiosks() {
        if ($this->session->userdata('admin_type') == 3) {
            $query = $this->db->query("select * from kiosks where  id in ( select kiosk_id from group_trans where group_id in ( select id from mastergroups where super_id=" . $this->session->userdata('admin_id') . "))  and is_deleted=0");
        } else {
            $query = $this->db->query("select * from kiosks where is_deleted=0");
        }

        return $query->result_array();
    }

//View all group-
    public function getAllGroups() {
        $query = $this->db->query("select * from mastergroups where is_deleted = 0");
        return $query->result_array();
    }

//View Group--
    public function viewGroup($id) {
        $query = $this->db->query("select *,g.id as group_id,u.username as username from mastergroups g join masterusers u on g.super_id=u.id where g.id='$id'");
        return $query->result_array();
    }

    public function viewKiosk($id) {
        $query = $this->db->query("select * from kiosks where id=" . $id);
        return $query->result_array();
    }

    public function editGroup() {
        $data = array(
            'group_name' => $this->input->post('group_name'),
            'super_id' => $this->input->post('supervisor'),
            'description' => $this->input->post('description'),
            'location' => $this->input->post('location')
        );
        $this->db->where('id', $this->input->post('upd_id'));
        return $this->db->update('mastergroups', $data);
    }

//Delete Group
    public function delGroup() {
        $result = array();
        $result['success'] = "";
        $result['error'] = "";

        $data = array(
            'is_deleted' => 1
        );
        foreach ($this->input->post('ids') as $id) {
            $this->db->where_in('id', $id);
            $foo = $this->db->update('mastergroups', $data);
        }

        if ($foo) {
            $result['success'] = $foo;
        } else {
            $result['error'] = "Sorry but record can't deleted !";
        }
        return json_encode($result);
    }

//Get all events -created by jaswant 
    public function getAllEvents() {
        $this->db->select('*');
        $this->db->from('events');
        $query = $this->db->get();
        return $query->result_array();
    }

//Get all venues -created by jaswant 
    public function getAllVenues() {
        $this->db->select('*');
        $this->db->from('venues');
        $query = $this->db->get();
        return $query->result_array();
    }

//Get all tickets -created by jaswant 
    public function getAllTickets() {
        $query = $this->db->query("select *,e.id as event_id,v.id as venue_id,t.id as ticket_id,e.title as event_name,v.name as venue_name from tickettypes t join events e on t.eventId=e.id join venues v on v.id=e.venueId");
        return $query->result_array();
    }

//Get all tickets -created by jaswant 
    public function getTicketsById($ids) {
        $query = $this->db->query("select *,e.id as event_id,v.id as venue_id,t.id as ticket_id,e.title as event_name,v.name as venue_name from tickettypes t join events e on t.eventId=e.id join venues v on v.id=e.venueId where t.id in (" . implode(",", $ids) . ")");
        return $query->result_array();
    }

    public function generate_alpha_numeric($length = 15) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $ret = '';
        for ($i = 0; $i < $length; ++$i) {
            $random = str_shuffle($chars);
            $ret .= $random[0];
        }
        return $ret;
    }

    public function generate_numeric($length = 1) {
        $chars = '0123456789';
        $ret = '';
        for ($i = 0; $i < $length; ++$i) {
            $random = str_shuffle($chars);
            $ret .= $random[0];
        }
        return $ret;
    }

    public function placeOrder() {
        $data = array(
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'housenumber' => $this->input->post('housenumber'),
            'street' => $this->input->post('street'),
            'city' => $this->input->post('city'),
            'county' => $this->input->post('county'),
            'country' => $this->input->post('country'),
            'postcode' => $this->input->post('postcode'),
            'admin_id' => $this->session->userdata("admin_id"),
        );
        $this->db->insert('customers', $data);
        $userid = $this->db->insert_id();

        $query = $this->db->query('select b.quantity as quantity,t.stockAvailable as stockAvailable, e.id as event_id,v.id as venue_id,t.id as ticket_id,e.title as event_name,v.name as venue_name,title,t.type as type,t.price as price from basket b join tickettypes t on t.id=b.item_id join events e on e.id=t.eventId join venues v on v.id=e.venueId where b.user_id=' . $this->session->userdata("admin_id"));
        $ticketdata = $query->result_array();

        $totalitems = 0;
        $amount = 0;
        foreach ($ticketdata as $ticket) {
            $price = ($ticket['price'] / 100);
            $amount+=($price * $ticket['quantity']);
            $totalitems++;
        }
        $transactionId = "";
        $transactionId = "OLFK" . $this->generate_numeric(1) . $this->generate_alpha_numeric(15);
        $orderdata = array(
            'order_id' => $transactionId,
            'customerid' => $userid,
            'order_items' => $totalitems,
            'order_amount' => $amount,
            'created_date' => date('d-m-Y'),
            'created_time' => date("h:i A"),
            'created_by' => $this->session->userdata("admin_id"),
       	    'kiosk_id' => $this->input->cookie("kiosk_token"),
            'order_status' => 1
        );
        $this->db->insert('orders', $orderdata);
        $orderid = $this->db->insert_id();

        foreach ($ticketdata as $ticket) {
            $orderdetails = array(
                'transaction_id' => $transactionId,
                'customer_id' => $userid,
                'order_id' => $orderid,
                'event_id' => $ticket['event_id'],
                'venue_id' => $ticket['venue_id'],
                'ticket_id' => $ticket['ticket_id'],
                'event_name' => $ticket['event_name'],
                'venue_name' => $ticket['venue_name'],
                'price' => ($ticket['price'] / 100),
                'quantity' => $ticket['quantity'],
                'kiosk_id' => $this->input->cookie("kiosk_token"),
                'created_date' => date('d-m-Y'),
                'created_time' => date("h:i A"),
                'created_by' => $this->session->userdata("admin_id"),
                'status' => 1
            );
            $this->db->insert('order_details', $orderdetails);
        }
        return $transactionId;
    }

    public function clearcart() {
        $this->db->query("delete from basket  where  user_id=" . $this->session->userdata('admin_id'));
    }

    public function removeitem($id) {
        $this->db->query("delete from basket  where id=" . $id . " and  user_id=" . $this->session->userdata('admin_id'));
    }

    public function getTotalItems() {
        $result = $this->db->query("select count(*) as totalitems from basket  where  user_id=" . $this->session->userdata('admin_id'));
        return $result->result_array();
    }

//Get Events Detail by Id -created by Arpita
    public function viewEventDetail($eventId) {
        $query = $this->db->query("select *,e.id as event_id,v.id as venue_id,t.id as ticket_id,e.title as event_name,v.name as venue_name from tickettypes t join events e on t.eventId=e.id join venues v on v.id=e.venueId where t.eventId= '$eventId'");
        return $query->row_array();
    }

    public function addAdmin() {
        $data = array(
            'first_name' => $this->input->post('firstname'),
            'last_name' => $this->input->post('lastname'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'password' => md5($this->input->post('password')),
            'username' => ($this->input->post('username')),
            'user_type' => 1
        );
        $this->db->select('username');
        $this->db->from('masterusers');
        $this->db->where('username', $this->input->post('username'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $returndata = 0;
        } else {
            $this->db->insert('masterusers', $data);
            $returndata = 1;
        }
        return ($returndata);
    }

///End of Admins actions
    public function getSupervisors() {

        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from("masterusers");
        $this->db->where('user_type', 3);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function getMasters() {

        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from("masterusers");
        $this->db->where('user_type', 2);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function getUsers() {
        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from("masterusers");
        $this->db->where('user_type', 4);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function getAssignedKiosks($id = 0) {
        $query = $this->db->query('Select * From kiosks where id in (select kiosk_id From group_trans where group_id=' . $id . ')');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function getUnassignedKiosks($id = 0) {
        $query = $this->db->query('Select * From kiosks where id not in (select kiosk_id From group_trans where group_id=' . $id . ')');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function setKiosks($ids, $sid) {
        foreach ($ids as $id) {
            $groupdata = array(
                'kiosk_id' => $id,
                'group_id' => $sid,
                'assign_by' => $this->session->userdata('admin_id'),
            );
            $this->db->insert('group_trans', $groupdata);
        }
        return true;
    }

    public function removeKiosks($ids, $sid) {
        foreach ($ids as $id) {
            $this->db->where('kiosk_id', $id);
            $this->db->where('group_id', $sid);
            $this->db->delete('group_trans');
        }
        return true;
    }

    public function getAdmins() {
        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from("masterusers");
        $this->db->where('user_type', 1);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function getAdminprofile() {
        log_message('info', 'Model_users logged_in method called suuessfully');
        $this->db->select('*');
        $this->db->from('masterusers');
        $this->db->where('id', $this->session->userdata("admin_id"));
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function editProfile() {
        $data = array(
            'first_name' => $this->input->post('firstname'),
            'last_name' => $this->input->post('lastname'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address')
        );
        if ($this->input->post('password') != '')
            $data['password'] = md5($this->input->post('password'));
        $this->db->where('id', $this->session->userdata("admin_id"));
        $foo = $this->db->update('masterusers', $data);
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($foo) {
            $result['success'] = $foo;
        } else {
            $result['error'] = "Sorry ! user can't update successfully";
        }
        return $result;
    }

    public function setuserstatus() {
        $result = array();
        $data = array(
            'is_actived' => $this->input->post('status')
        );
        $this->db->where('id', $this->input->post('id'));
        $foo = $this->db->update('masterusers', $data);
        if ($foo) {
            $result['success'] = $foo;
        } else {
            $result['error'] = "Sorry but record can't deleted !";
        }
        return $result;
    }

    public function updateBasket() {
        $i = 0;
        $tickets = $this->input->post('tickets');
        $quantity = $this->input->post('qty');
        foreach ($tickets as $id) {
            $this->db->query("update basket set quantity=" . $quantity[$i] . " where item_id=" . $id . " and user_id=" . $this->session->userdata('admin_id'));
            $i++;
        }
    }

    public function addtobasket() {
        $this->db->select('*');
        $this->db->from("basket");
        $this->db->where("user_id", $this->session->userdata('admin_id'));
        $query = $this->db->get();
        $cart = $query->result_array();
        $ids = array();
        foreach ($cart as $item) {
            $ids[] = $item['item_id'];
        }

        $result = array();
        $result['success'] = "";
        $price = $this->input->post('price');
        $i = 0;
        foreach ($this->input->post('ids') as $id) {
            if (in_array($id, $ids)) {
                $this->db->query("update basket set quantity=(quantity + 1) where item_id=" . $id . " and user_id=" . $this->session->userdata('admin_id'));
            } else {
                $basketdata = array(
                    'user_id' => $this->session->userdata('admin_id'),
                    'item_id' => $id,
                    'price' => ($price[$i] / 100),
                    'quantity' => 1
                );
                $this->db->insert('basket', $basketdata);
            }
        }
        $result['success'] = 'OK';
        return json_encode($result);
    }

    public function getOrdersinfo() {
        log_message('info', 'Model_users logged_in method called successfully');
        $query = $this->db->query("SELECT c.id as cid, c.email as email,c.city as city,c.mobile as mobile, c.firstname as firstname, c.lastname as lastname,o.order_id as order_id,o.order_items as quantity , o.order_amount as amount,o.ts as datetime FROM customers as c join orders as o on c.id = o.customerid");
        return $query->result_array();
    }

    public function viewCustomer() {
        log_message('info', 'Model_Users logged_in method called successfully');
        $this->db->select('*', FALSE);
        $this->db->from('orders as o');
        $this->db->join('customers as C', 'o.customerid = C.id', 'left');
        $this->db->where("c.id", $_REQUEST['id'], FALSE);
        $query = $this->db->get();
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($query->num_rows() > 0) {
            $result['record'] = $query->row_array();
            $result['success'] = 1;
        } else {

            $result['error'] = "Sorry no such user found in database";
        }

        return json_encode($result);
    }

//Customer Actions
    public function CustomerInfo() {
        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from("customers");
        $this->db->where('id', $this->input->post('id'));
        $query = $this->db->get();
        $result = array();
        $result['success'] = "";
        $result['error'] = "";

        if ($query->num_rows() > 0) {
            $result['record'] = $query->row_array();
            $result['success'] = 1;
        } else {
            $result['error'] = "Sorry no such user found in database";
        }

        return json_encode($result);
    }

// for edit cutomer information 
    public function editCustomer() {
        $data = array(
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'housenumber' => $this->input->post('housenumber'),
            'street' => $this->input->post('street'),
            'city' => $this->input->post('city'),
            'county' => $this->input->post('county'),
            'country' => $this->input->post('country'),
            'postcode' => $this->input->post('postcode'),
        );
        $this->db->where('id', $this->input->post('id'));
        $foo = $this->db->update('customers', $data);
        $result = array();
        $result['success'] = "";
        $result['error'] = "";
        if ($foo) {
            $result['success'] = $foo;
        } else {
            $result['error'] = "Sorry ! user can't update successfully";
        }
        return json_encode($result);
    }

// for fetch assigned user accroding to superuserid

    public function getassignedUsers() {
        log_message('info', 'Model_users logged_in method called successfully');
        $query = $this->db->query('select * from masterusers where id in (select user_id from kiosk_group where superuser_id = ' . $_REQUEST['id'] . ')');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }

        return ($result);
    }

    public function unassignGroup() {
        $this->db->where_in('user_id', $this->input->post('userId'));
        $foo = $this->db->delete('kiosk_group');
        return ($foo);
    }

// for display customer order table---//
    public function getCustomerOrder($id) {
        log_message('info', 'Model_users logged_in method called successfully');
        $query = $this->db->query("SELECT *,c.id as cid ,o.id as oid,od.id as odId FROM customers as c join orders as o on c.id = o.customerid join order_details as od on od.order_id=o.id where c.id=" . $id);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

// for display customer order table---//
    public function getOrdertickets($id) {
        log_message('info', 'Model_admin getOrdertickets method called successfully');
        $query = $this->db->query("SELECT * FROM order_details where transaction_id='" . $id . "'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function getUsersassigned() {
        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from("masterusers");
        $this->db->join("kiosk_group", "kiosk_group.user_id=masterusers.id");
        $this->db->where('masterusers.user_type', 4);
        $this->db->where('masterusers.is_deleted', 0);
        $this->db->where('kiosk_group.superuser_id', $this->session->userdata('admin_id'));
        $this->db->group_by('masterusers.id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function getrefundvalues($ids) {
        $query = $this->db->query("select ticket_id as item_id,price,quantity from order_details  where transaction_id ='" . $ids . "'");
        return $query->result();
    }

    public function getonerefundvalue($transaction, $ids) {
        $query = $this->db->query("select ticket_id as item_id,price,quantity from order_details  where  transaction_id='" . $transaction . "' and ticket_id =" . $ids);
        return $query->result();
    }

    public function updatequantity() {
        $data = array(
            'quantity' => $this->input->post('quantity'),
        );
        $this->db->where('item_id', $this->input->post('ticket_id'));
        return $this->db->update('basket', $data);
    }

//Delete Kiosk
    public function delKiosks() {
        $result = array();
        $result['success'] = "";
        $result['error'] = "";

        $data = array(
            'is_deleted' => 1
        );
        foreach ($this->input->post('ids') as $id) {
            $this->db->where_in('id', $id);
            $foo = $this->db->update('kiosks', $data);
        }

        if ($foo) {
            $result['success'] = $foo;
        } else {
            $result['error'] = "Sorry but record can't deleted !";
        }
        return json_encode($result);
    }

    public function setkioskstatus() {
        $result = array();
        $data = array(
            'is_actived' => $this->input->post('status')
        );
        $this->db->where('id', $this->input->post('id'));
        $foo = $this->db->update('kiosks', $data);
        if ($foo) {
            $result['success'] = $foo;
        } else {
            $result['error'] = "Sorry but record can't deleted !";
        }
        return $result;
    }

    public function setgroupstatus() {
        $result = array();
        $data = array(
            'is_actived' => $this->input->post('status')
        );
        $this->db->where('id', $this->input->post('id'));
        $foo = $this->db->update('mastergroups', $data);
        if ($foo) {
            $result['success'] = $foo;
        } else {
            $result['error'] = "Sorry but record can't deleted !";
        }
        return $result;
    }

    public function getGroupsTickets($tokan) {
        $this->db->select('ord.*,cs.firstname,cs.lastname,cs.email');
	$this->db->join('customers cs', 'ord.customerid = cs.id');
	$this->db->from('orders ord');
        $this->db->where('ord.kiosk_id', $tokan);
        $query = $this->db->get();	
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function getTicketByEventId() {
        $query = $this->db->query("select * from events join venues on events.venueId=venues.id join tickettypes on events.id = tickettypes.eventId where events.id=" . $this->input->post('eventId'));
        $data = $query->row_array();
        return json_encode($data);
    }
    public function getTicketquantity($id) {
        $query = $this->db->query("select * from events  join tickettypes on events.id = tickettypes.eventId where events.id=" . $id);
        return $query->result_array();
        
    }
  
    public function getOrderdTickets($order_id) {
        $this->db->select('*');
	$this->db->from('order_details');
        $this->db->where('transaction_id', $order_id);
        $query = $this->db->get();	
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
 
    public function getkioskgroupsOrder($group_id){
 	$this->db->select('gp.*,kio.*');
	$this->db->join('kiosks kio', 'kio.id = gp.id');
	$this->db->from('group_trans gp');
        $this->db->where('gp.group_id', $group_id);
        $query = $this->db->get();	
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

}

/*
  .::File Details::.
  End of file model_admin.php
  Created By : mayank awasthi
  Firm Name : Cyber Infrastructure Pvt. Ltd. India < http://cisin.com >
  Location: ./application/Models/model_admin.php
  Created At : 16 Nov, 2013  5:22:12 PM
 */
?>
