<?php

/**
 * Description of BPMediaModel
 *
 * @author joshua
 */
class RTMediaModel extends RTDBModel {

    function __construct () {
        parent::__construct ( 'rtm_media' );
        $this->meta_table_name = "rt_rtm_media_meta";
    }

    /**
     *
     * @param type $name
     * @param type $arguments
     * @return type
     */
    function __call ( $name, $arguments ) {
        $result = parent::__call ( $name, $arguments );
        if ( ! $result[ 'result' ] ) {
            $result[ 'result' ] = $this->populate_results_fallback ( $name, $arguments );
        }
        return $result;
    }

    /**
     *
     * @global type $wpdb
     * @param type $columns
     * @param type $offset
     * @param type $per_page
     * @param type $order_by
     * @return type
     */
    function get ( $columns, $offset = false, $per_page = false, $order_by = 'media_id desc' ) {
        global $wpdb;
        $select = "SELECT * FROM {$this->table_name}";
        $join = "";
        $where = " where 2=2 ";
        $temp = 65;
        foreach ( $columns as $colname => $colvalue ) {
            if ( strtolower ( $colname ) == "meta_query" ) {
                foreach ( $colvalue as $meta_query ) {
                    if ( ! isset ( $meta_query[ "compare" ] ) ) {
                        $meta_query[ "compare" ] = "=";
                    }
                    $tbl_alias = chr ( $temp ++  );
                    $join .= " LEFT JOIN {$wpdb->prefix}{$this->meta_table_name} as {$tbl_alias} ON {$this->table_name}.id = {$tbl_alias}.media_id ";
                    if ( isset ( $meta_query[ "value" ] ) )
                        $where .= " AND  ({$tbl_alias}.meta_key = '{$meta_query[ "key" ]}' and  {$tbl_alias}.meta_value  {$meta_query[ "compare" ]}  '{$meta_query[ "value" ]}' ) ";
                    else
                        $where .= " AND  {$tbl_alias}.meta_key = '{$meta_query[ "key" ]}' ";
                }
            } else {
                if ( is_array ( $colvalue ) ) {
                    if ( ! isset ( $colvalue[ 'compare' ] ) )
                        $compare = 'IN';
                    else
                        $compare = $colvalue[ 'compare' ];
                    if ( ! isset ( $colvalue[ 'value' ] ) ) {
                        $colvalue[ 'value' ] = $colvalue;
                    }
                    $col_val_comapare = ($colvalue[ 'value' ]) ? '(\'' . implode ( "','", $colvalue[ 'value' ] ) . '\')' : '';
                    $where .= " AND {$this->table_name}.{$colname} {$compare} {$col_val_comapare}";
                }
                else
                    $where .= " AND {$this->table_name}.{$colname} = '{$colvalue}'";
            }
        }
        $qorder_by = " ORDER BY {$this->table_name}.$order_by";
        
        $join = apply_filters ( 'rtmedia-model-join-query', $join, $this->table_name );
        $where = apply_filters ( 'rtmedia-model-where-query', $where, $this->table_name );
        $qorder_by = apply_filters ( 'rtmedia-model-order-by-query', $qorder_by, $this->table_name );
        
        $sql = $select . $join . $where .$qorder_by;
        if ( is_integer ( $offset ) && is_integer ( $per_page ) ) {
            $sql .= ' LIMIT ' . $offset . ',' . $per_page;
        }

        return $wpdb->get_results ( $sql );
    }

    /**
     *
     * @param type $name
     * @param type $arguments
     * @return type
     */
    function populate_results_fallback ( $name, $arguments ) {
        $result[ 'result' ] = false;
        if ( 'get_by_media_id' == $name && isset ( $arguments[ 0 ] ) && $arguments[ 0 ] ) {

            $result[ 'result' ][ 0 ]->media_id = $arguments[ 0 ];

            $post_type = get_post_field ( 'post_type', $arguments[ 0 ] );
            if ( 'attachment' == $post_type ) {
                $post_mime_type = explode ( '/', get_post_field ( 'post_mime_type', $arguments[ 0 ] ) );
                $result[ 'result' ][ 0 ]->media_type = $post_mime_type[ 0 ];
            } elseif ( 'bp_media_album' == $post_type ) {
                $result[ 'result' ][ 0 ]->media_type = 'bp_media_album';
            } else {
                $result[ 'result' ][ 0 ]->media_type = false;
            }

            $result[ 'result' ][ 0 ]->context_id = intval ( get_post_meta ( $arguments[ 0 ], 'bp-media-key', true ) );
            if ( $result[ 'result' ][ 0 ]->context_id > 0 )
                $result[ 'result' ][ 0 ]->context = 'profile';
            else
                $result[ 'result' ][ 0 ]->context = 'group';

            $result[ 'result' ][ 0 ]->activity_id = get_post_meta ( $arguments[ 0 ], 'bp_media_child_activity', true );

            $result[ 'result' ][ 0 ]->privacy = get_post_meta ( $arguments[ 0 ], 'bp_media_privacy', true );
        }
        return $result[ 'result' ];
    }

    /**
     *
     * @param type $columns
     * @param type $offset
     * @param type $per_page
     * @param type $order_by
     * @return type
     */
    function get_media ( $columns, $offset = false, $per_page = false, $order_by = 'media_id desc' ) {
        if ( is_multisite () ) {
            $results = $this->get ( $columns, $offset, $per_page, "blog_id ," . $order_by );
        } else {
            $results = $this->get ( $columns, $offset, $per_page, $order_by );
        }
        return $results;
    }

    function get_user_albums ( $author_id, $offset, $per_page, $order_by = 'media_id desc' ) {
        global $wpdb;
        if ( is_multisite () )
            $order_by = "blog_id ," . $order_by;

        $sql = "SELECT * FROM {$this->table_name} WHERE (id IN(SELECT DISTINCT (album_id)
                            FROM {$this->table_name}
                                WHERE media_author = $author_id
                                    AND album_id IS NOT NULL
                                    AND media_type <> 'album' AND context <> 'group') OR (media_author = $author_id ))
                                        AND media_type = 'album'
                                        AND (context <> 'group' or context is NULL) ";
        $sql .= " ORDER BY {$this->table_name}.$order_by";

        if ( is_integer ( $offset ) && is_integer ( $per_page ) ) {
            $sql .= ' LIMIT ' . $offset . ',' . $per_page;
        }

        $results = $wpdb->get_results ( $sql );
        return $results;
    }

    function get_group_albums ( $group_id, $offset, $per_page, $order_by = 'media_id desc' ) {
        global $wpdb;
        if ( is_multisite () )
            $order_by = "blog_id ," . $order_by;
        $sql = "SELECT * FROM {$this->table_name} WHERE id IN(SELECT DISTINCT (album_id) FROM {$this->table_name} WHERE context_id = $group_id AND album_id IS NOT NULL AND media_type != 'album' AND context = 'group') OR (media_type = 'album' AND context_id = $group_id AND context = 'group')";
        $sql .= " ORDER BY {$this->table_name}.$order_by";

        if ( is_integer ( $offset ) && is_integer ( $per_page ) ) {
            $sql .= ' LIMIT ' . $offset . ',' . $per_page;
        }
        $results = $wpdb->get_results ( $sql );
        return $results;
    }

    function get_counts ( $user_id = false, $where_query = false ) {

        if ( ! $user_id && ! $where_query )
            return false;
        global $wpdb, $rtmedia;

        $query =
                "SELECT {$this->table_name}.privacy, ";
        foreach ( $rtmedia->allowed_types as $type ) {
            $query .= "SUM(CASE WHEN {$this->table_name}.media_type LIKE '{$type[ 'name' ]}' THEN 1 ELSE 0 END) as {$type[ 'name' ]}, ";
        }
        $query .= "SUM(CASE WHEN {$this->table_name}.media_type LIKE 'album' THEN 1 ELSE 0 END) as album
	FROM
		{$this->table_name} WHERE 2=2 ";

        if ( $where_query ) {
            foreach ( $where_query as $colname => $colvalue ) {
                if ( strtolower ( $colname ) != "meta_query" ) {
                    if ( is_array ( $colvalue ) ) {
                        if ( ! isset ( $colvalue[ 'compare' ] ) )
                            $compare = 'IN';
                        else
                            $compare = $colvalue[ 'compare' ];
                        if ( ! isset ( $colvalue[ 'value' ] ) ) {
                            $colvalue[ 'value' ] = $colvalue;
                        }

                        $query .= " AND {$this->table_name}.{$colname} {$compare} ('" . implode ( "','", $colvalue[ 'value' ] ) . "')";
                    } else {

                        if ( $colname == "context" && $colvalue == "profile" ) {
                               $query .= " AND {$this->table_name}.{$colname} <> 'group'";
                        } else {
                            $query .= " AND {$this->table_name}.{$colname} = '{$colvalue}'";
                        }
                    }
                }
            }
        }
        $query .= "GROUP BY privacy";
        $result = $wpdb->get_results ( $query );
        if ( ! is_array ( $result ) )
            return false;
        return $result;
    }

    function get_other_album_count ( $profile_id, $context = "profile" ) {
        $global = RTMediaAlbum::get_globals ();
        $sql = "select distinct album_id from {$this->table_name} where 2=2 AND context = '{$context}' ";
        if ( is_array ( $global ) && count ( $global ) > 0 ) {
            $sql .= " and album_id in (";
            $sep = "";
            foreach ( $global as $id ) {
                $sql .= $sep . $id;
                $sep = ",";
            }
            $sql .= ")";
        }
        if ( $context == "profile" ) {
            $sql .= " AND media_author=$profile_id ";
        } else if ( $context == "group" ) {
            $sql .= " AND context_id=$profile_id ";
        }
        global $wpdb;
        $result = $wpdb->get_results ( $sql );
        if ( isset ( $result ) ) {
            return count ( $result );
        } else {
            return 0;
        }
    }

}

?>
