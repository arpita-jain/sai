<?php

class DB_order_history {

	var $table_name = null;
	
	function __construct() {
		global $wpdb;

		// Cannot use wpdb->prefix because single table is required
		$this->table_name = $wpdb->base_prefix . 'order_history';
	}

	function insert( $array ) {
		global $wpdb;
		$array['blog_id'];
		$array['user_id'];
		$array['order_id'];
		$wpdb->insert($this->table_name, $array );
	}

	function get_order_by_blog_id( $blog_id ) {
		global $wpdb;
		return $wpdb->get_results("SELECT * FROM {$this->table_name} WHERE blog_id = $blog_id");
	}

	function get_order_by_user_id( $user_id, $order = 'id', $sort = 'DESC' ) {
		global $wpdb;
		$query_where = null;
		switch ( $order ) {
			case 'id':
				$query_where .= " ORDER BY id " . $sort;
			break;
		}
		return $wpdb->get_results("SELECT * FROM {$this->table_name} WHERE user_id = $user_id {$query_where}");
	}

	function get_order_by_order_id( $order_id ) {
		global $wpdb;
		return $wpdb->get_results("SELECT * FROM {$this->table_name} WHERE order_id = '$order_id' ");
	}

	function delete( $order_id, $blog_id ) {
		global $wpdb;
		return $wpdb->query("DELETE FROM {$this->table_name} WHERE order_id = '$order_id' AND blog_id = '$blog_id'");
	}

}


$DB_order_history = new DB_order_history();