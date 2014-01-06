<?php
class joinnetworkformdb
{	
   public function __construct()
    {   
    }
    
    /* Insert user detalis using join now */
   //   code start here
    public function insert_join_now($data)
    { //print_r($data); 
      global $wpdb;
     // print_r($data);
      $usertype=$data['usertype'];//Gender
      $gender=$data['gender'];//Gender
      $user_name=$data["user_name"]; //User Name
      $first_name=$data["first_name"]; //First Name
      $lastName=$data["last_name"]; //Last Name
      $company_name=$data["company_name"];//Company Name
      $buisness_type=$data["buisness_type"]; 
      $address1=$data['address1'];//Address1
      $address2=$data['address2'];//Address2
      $city=$data['city'];//City
      $post_code=$data['post_code'];//Post Code
      $mobile=$data['mobile'];//Mobile
      $phone=$data['phone'];//Phone
      $about_company_str=$data['about_company'];//About company
      $about_company=strtolower($about_company_str);
      $about_us=$data['about_us'];//About Us
      $user_email=$data["email_address"];//Email Address
      //$Confirm_Email=$data["Confirm_Email"];//Email Address
      $select_password=$data['select_password'];//Intrest
      $Confirm_Password=$data['Confirm_Password'];//Intrest
      $agree_option=$data['agree_option']; //Agree Option
      $latitude = $data['latitude'];
      $longitude = $data['longitude'];
      
      //echo "<pre>";
      //print_r($data);
      // die;
      //echo "usertype = ".$usertype;
      //echo "lat = ".$lat;
      //echo "lng = ".$lng;
      $user_id = username_exists( $user_name );
      if ( !$user_id and email_exists($user_email) == false ) {             
            //$user_id = wp_create_user($user_name, $hash, $user_email);
            //wp_update_user( array ('ID' => $user_id, 'first_name' => $user_name,'last_name' => $lastName) ) ;
               $userdata = array
				(
				'user_pass' => $select_password,
				'user_login' => esc_attr( $user_name ),
				'first_name' => esc_attr( $first_name ),
				'last_name' => esc_attr( $lastName ),
				'user_email' => esc_attr( $user_email ),
				'user_status' => esc_attr(2),
				'role' =>  get_option('default_role')					
				);
				
               $vals = array
				(
			       '%s',
			       '%s',
			       '%s',
			       '%s',
			       '%s',
			       '%d',
			       '%s'
				);
				
            $userdata1 = apply_filters('register_userdata', $userdata,$vals);
	 $user_id = wp_insert_user( $userdata1 );
            //add custom for registration
	    add_user_meta( $user_id,'available','available', true );
	    add_user_meta( $user_id,'gender',$gender, true );
            add_user_meta( $user_id,'address1',$address1, true );
            add_user_meta( $user_id,'address2',$address2, true );
            add_user_meta( $user_id,'company_name',$company_name, true );
	    add_user_meta( $user_id,'bussiness_type',$buisness_type, true );
            add_user_meta( $user_id,'usertype',$usertype, true );
            add_user_meta( $user_id,'city',$city, true );
            add_user_meta( $user_id,'about_company',$about_company, true );  
            add_user_meta( $user_id,'post_code',$post_code, true );
            add_user_meta( $user_id,'mobile',$mobile, true );
            add_user_meta( $user_id,'phone',$phone, true );
            add_user_meta( $user_id,'about_us',$about_us, true );
	    add_user_meta( $user_id,'skill', '', true );
	    add_user_meta( $user_id,'work_area', '', true );
	    add_user_meta( $user_id,'company_terms', '', true );
	    add_user_meta( $user_id,'feedback', '', true );
	    add_user_meta( $user_id,'contact_me', '', true );
	    add_user_meta( $user_id,'promotion', 0, true );
	    add_user_meta( $user_id,'trades_name','', true );
          //add_user_meta( $user_id,'intrest', $intrest, true );
            add_user_meta( $user_id,'agree_option', $agree_option, true );            
	    add_user_meta( $user_id,'Confirm_Password', $Confirm_Password, true );
	    add_user_meta( $user_id,'stored_user_password', $select_password, true );
            add_user_meta( $user_id,'email_verification_code', '', true );
            add_user_meta($user_id,'email_verification_sent', gmdate( 'Y-m-d H:i:s'), true );
	    add_user_meta($user_id,'trades_name', gmdate( 'Y-m-d H:i:s'), true );
	    add_user_meta($user_id,'slogan', '', true );
	     add_user_meta($user_id,'url', '', true );
	       $tbl_name = $wpdb->prefix.'userlatlong';
	       $latdata=array('userid'=>$user_id, 'lat'=>$latitude, 'lng'=>$longitude, 'usertype'=>$usertype);
	       $row_affected =$wpdb->insert($tbl_name,$latdata);
	       //add_user_meta($user_id,'latitude',$latitude, true);
	       //add_user_meta($user_id,'longitude',$longitude, true);
	   
            $user = get_userdata( $user_id );	  
	    $user->set_role( 'joinnow_unverified' );
	    $user->remove_role(get_option('default_role'));
	   // echo $user_id; die('====');
            return $user_id;
      } else {
              return false;
      }      
    }
    }
?>