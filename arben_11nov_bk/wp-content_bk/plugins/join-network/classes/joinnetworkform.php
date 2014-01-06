<?php
class joinnetworkform
{
   public $postcode=array("Your Postcode","02451","02452","02453","02454");
   public $about_us=array("How Did You Hear About Us?","About1","About2","About3","About3");
   public $interest=array("Select the trades you're Interested In getting leads for","Interest1","Interest2","Interest3","Interest4");
   public function __construct()
    {
       //All be function define classes folder
        require_once(CLASSES_PATH.'/joinnetworkformdb.php');  
         $this->model=new joinnetworkformdb();
    }
    
    public function displayForm()
    {
       //template file define in template folder
        require_once(TEMPLATE_PATH.'/join-now.php');
        //All be function define classes folder
        require_once(CLASSES_PATH.'/joinnetworkformdb.php');  
         $this->model=new joinnetworkformdb();
    }
     
     //dashboard join
     
     public function displayDashboard()
    {
       //template file define in template folder
        require_once(TEMPLATE_PATH.'/dashboardjoin.php');
        //All be function define classes folder
        require_once(CLASSES_PATH.'/joinnetworkformdb.php');  
         $this->model=new joinnetworkformdb();
    }

//Display Home owner

//dashboard join
     
     public function displayHomeOwner()
    {
       //template file define in template folder
        require_once(TEMPLATE_PATH.'/home_owner.php');
        //All be function define classes folder
        require_once(CLASSES_PATH.'/joinnetworkformdb.php');  
         $this->model=new joinnetworkformdb();
    }
    
    public function insert_join_now_user($data)
    {
      //print_r($data); 
      //Find function joinnetworkformdb.php in class folder
      $user_id=$this->model->insert_join_now($data);   
    $plaintext_pass = stripslashes( (string) $data['select_password'] ); 
		$this->send_welcome_user_mail($user_id,$plaintext_pass);
		$this->send_admin_mail( $user_id, $plaintext_pass, '');
     // $verification_code = '';
   //   echo $this->joinow_get_option( 'verify_user_email' );
     // if ('1' === $this->joinow_get_option( 'verify_user_email' ) ) {
			//echo $verification_code = wp_generate_password( 20, FALSE ); 
		
			//update_user_meta( $user_id, 'email_verification_code', $verification_code );
			//update_user_meta( $user_id, 'email_verification_sent', gmdate( 'Y-m-d H:i:s' ) );
			//$this->send_verification_mail( $user_id, $verification_code );
 //  }
   //  $this->send_welcome_user_mail($user_id,$plaintext_pass);
  //  $this->send_admin_mail( $user_id, $plaintext_pass, $verification_code );
   return $user_id;
    }
    
    public static /*.mixed.*/ function default_options( $option = '' )
		{
			$blogname = stripslashes( wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ) );
			$options = array(
				'verify_user_email' => is_multisite() ? '1' : '1',
				'message_verify_user_email' => is_multisite() ? 
					__( "<h2>%user_login% is your new username</h2>\n<p>But, before you can start using your new username, <strong>you must activate it</strong></p>\n<p>Check your inbox at <strong>%user_email%</strong> and click the link given.</p>\n<p>If you do not activate your username within two days, you will have to sign up again.</p>", 'register-plus-redux' ) :
					__( 'Please verify your account using the verification link sent to your email address.', 'register-plus-redux' ),
				'verify_user_admin' => '0',
				'message_verify_user_admin' => __( 'Your account will be reviewed by an administrator and you will be notified when it is activated.', 'register-plus-redux' ),
				'delete_unverified_users_after' => is_multisite() ? 0 : 7,
				'autologin_user' => '0',

				'username_is_email' => '0',
				'double_check_email' => '0',
				'user_set_password' => '0',
				'min_password_length' => 6,
				'disable_password_confirmation' => '0',
				'show_password_meter' => '0',
				'message_empty_password' => 'Strength Indicator',
				'message_short_password' => 'Too Short',
				'message_bad_password' => 'Bad Password',
				'message_good_password' => 'Good Password',
				'message_strong_password' => 'Strong Password',
				'message_mismatch_password' => 'Password Mismatch',
				'enable_invitation_code' => '0',
				'require_invitation_code' => '0',
				'invitation_code_case_sensitive' => '0',
				'invitation_code_unique' => '0',
				'enable_invitation_tracking_widget' => '0',
				'show_disclaimer' => '0',
				'message_disclaimer_title' => 'Disclaimer',
				'require_disclaimer_agree' => '1',
				'message_disclaimer_agree' => 'Accept the Disclaimer',
				'show_license' => '0',
				'message_license_title' => 'License Agreement',
				'require_license_agree' => '1',
				'message_license_agree' => 'Accept the License Agreement',
				
				
				'show_privacy_policy' => '0',
				'message_privacy_policy_title' => 'Privacy Policy',
				'require_privacy_policy_agree' => '1',
				'message_privacy_policy_agree' => 'Accept the Privacy Policy',
				'default_css' => '1',
				'required_fields_style' => 'border:solid 1px #E6DB55; background-color:#FFFFE0;',
				'required_fields_asterisk' => '0',
				'starting_tabindex' => 0,
				'disable_user_message_registered' => '1',
				'disable_user_message_created' => '0',
				'custom_user_message' => '0',
				'user_message_from_email' => get_option( 'admin_email' ),
				'user_message_from_name' => $blogname,
				'user_message_subject' => '[' . $blogname . '] ' . __( 'Your Login Information', 'join-network' ),
				'user_message_body' => "Username: %user_login%\nPassword: %user_password%\n\n%site_url%\n",
				'send_user_message_in_html' => '0',
				'user_message_newline_as_br' => '0',
				'custom_verification_message' => '0',
				'verification_message_from_email' => get_option( 'admin_email' ),
				'verification_message_from_name' => $blogname,
				'verification_message_subject' => '[' . $blogname . '] ' . __( 'Verify Your Account', 'register-plus-redux' ),
				'verification_message_body' => "Verification URL: %verification_url%\nPlease use the above link to verify your email address and activate your account\n",
				'send_verification_message_in_html' => '0',
				'verification_message_newline_as_br' => '0',
				'disable_admin_message_registered' => '0',
				'disable_admin_message_created' => '0',
				'admin_message_when_verified' => '1',
				'custom_admin_message' => '0',
				'admin_message_from_email' => get_option( 'admin_email' ),
				'admin_message_from_name' => $blogname,
				'admin_message_subject' => '[' . $blogname . '] ' . __( 'New User Registered', 'register-plus-redux' ),
				'admin_message_body' => "New user registered on your site %blogname%\n\nUsername: %user_login%\nE-mail: %user_email%\n",
				'send_admin_message_in_html' => '0',
				'admin_message_newline_as_br' => '0'
			);
			if ( !empty( $option ) ) {
				if ( array_key_exists( $option, $options ) ) {
					return $options[$option];
				}
				else {
					//TODO: Trigger event this would be odd
					return FALSE;
				}
			}
			return $options;
   }
   public function joinow_update_options( /*.array[string]mixed.*/ $options ) {
			if ( empty( $options ) && empty( $this->options ) ) return FALSE;
			if ( !empty( $options ) ) {
				update_option( 'cis_register_join_now_options', $options );
				$this->options = $options;
			}
			else {
				update_option( 'cis_register_join_now_options', $this->options );
			}
			return TRUE;
   }
   private /*.void.*/ function joinow_load_options( $force_refresh = FALSE ) {
			if ( empty( $this->options ) || $force_refresh === TRUE ) {
				$this->options = get_option( 'cis_register_join_now_options' );
			}
			if ( empty( $this->options ) ) {
				$this->joinow_update_options( $this->default_options() );
			}
    }
   public /*.mixed.*/ function joinow_get_option( /*.string.*/ $option ) {
			if ( empty( $option ) ) return NULL;
			$this->joinow_load_options( FALSE );
			if ( array_key_exists( $option, $this->options ) ) {
				return $this->options[$option];
			}
			return NULL;
   }
   public /*.bool.*/ function joinow_set_option( /*.string.*/ $option, /*.mixed.*/ $value, $save_now = FALSE ) {
			if ( empty( $option ) ) return FALSE;
			$this->joinow_load_options( FALSE );
			$this->options[$option] = $value;
			if ( $save_now === TRUE ) {
				$this->joinow_update_options( NULL );
			}
			return TRUE;
   }

   public /*.bool.*/ function joinow_unset_option( /*.string.*/ $option, $save_now = FALSE ) {
			if ( empty( $option ) ) return FALSE;
			$this->joinow_load_options( FALSE );
			unset( $this->options[$option] );
			if ( $save_now === TRUE ) {
				$this->joinow_update_options( NULL );
			}
			return TRUE;
   }
   // Email setting function
   public /*.string.*/ function joinnetwork_filter_mail_content_type_text( /*.string.*/ $content_type ) {
			return 'text/plain';
		}
   public /*.string.*/ function joinnetwork_filter_mail_content_type_html( /*.string.*/ $content_type ) {
			return 'text/html';
		}
   public /*.string.*/ function joinnetwork_filter_verification_mail_from( /*.string.*/ $from_email ) {
			return is_email( $this->joinow_get_option( 'verification_message_from_email' ) );
		}

   public /*.string.*/ function joinnetwork_filter_verification_mail_from_name( /*.string.*/ $from_name ) {
			return esc_html( $this->joinow_get_option( 'verification_message_from_name' ) );
		}

   public /*.string.*/ function joinnetwork_filter_welcome_user_mail_from( /*.string.*/ $from_email ) {
			return is_email( $this->joinow_get_option( 'user_message_from_email' ) );
		}

   public /*.string.*/ function joinnetwork_filter_welcome_user_mail_from_name( /*.string.*/ $from_name ) {
			return esc_html( $this->joinow_get_option( 'user_message_from_name' ) );
		}
   public /*.string.*/ function joinnetwork_filter_admin_mail_from( /*.string.*/ $from_email ) {
			return is_email( $this->joinow_get_option( 'admin_message_from_email' ) );
		}

   public /*.string.*/ function joinnetwork_filter_admin_mail_from_name( /*.string.*/ $from_name ) {
			return esc_html( $this->joinow_get_option( 'admin_message_from_name' ) );
   }
   		// $user is a WP_User object
   public /*.string.*/ function replace_keywords( /*.mixed.*/ $message, $user, $plaintext_pass = '', $verification_code = '' ) {
			global $pagenow;
			echo $verification_code;
			if ( empty( $message ) ) return '%blogname% %site_url% %http_referer% %http_user_agent% %registered_from_ip% %registered_from_host% %user_login% %user_email% %user_password% %verification_code% %verification_url%';

			preg_match_all( '/%=([^%]+)%/', (string) $message, $keys );
			if ( is_array( $keys ) && is_array( $keys[1] ) ) {
				foreach( $keys[1] as $key ) {
					$message = str_replace( "%=$key%", get_user_meta( $user->ID, $key, TRUE ), $message );
				}
			}

			// support renamed keywords for backcompat
			$message = str_replace( '%verification_link%', '%verification_url%', $message );

			$message = str_replace( '%blogname%', wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ), $message );
			$message = str_replace( '%site_url%', site_url(), $message );
			$message = str_replace( '%?pagenow%', $pagenow, $message ); //debug keyword
			$message = str_replace( '%?user_info%', print_r( $user, TRUE ), $message ); //debug keyword
			$message = str_replace( '%?keys%', print_r( $keys, TRUE ), $message ); //debug keyword

			if ( !empty( $_SERVER ) ) {
				$message = str_replace( '%http_referer%', isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '', $message );
				$message = str_replace( '%http_user_agent%', isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '', $message );
				$message = str_replace( '%registered_from_ip%', isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '', $message );
				$message = str_replace( '%registered_from_host%', isset( $_SERVER['REMOTE_ADDR'] ) ? gethostbyaddr( $_SERVER['REMOTE_ADDR'] ) : '', $message );
			}
			if ( !empty( $user ) ) {
				$message = str_replace( '%user_login%', $user->user_login, $message );
				$message = str_replace( '%user_email%', $user->user_email, $message );
				$message = str_replace( '%stored_user_login%', $user->user_login, $message );
			}
			if ( !empty( $plaintext_pass ) ) {
				$message = str_replace( '%user_password%', $plaintext_pass, $message );
			}
			if ( !empty( $verification_code ) ) {
				$message = str_replace( '%verification_code%', $verification_code, $message );
				$message = str_replace( '%verification_url%', wp_login_url() . '?action=verifyemail&verification_code=' . $verification_code, $message );
			}

			preg_match_all( '/%([^%]+)%/', (string) $message, $keys );
			if ( is_array( $keys ) && is_array( $keys[1] ) ) {
				foreach( $keys[1] as $key ) {
					$message = str_replace( "%$key%", get_user_meta( $user->ID, $key, TRUE ), $message );
				}
			}
			return (string) $message;
		}
    // Send user welcome mail
    public function send_welcome_user_mail( /*.int.*/ $user_id, /*.string.*/ $plaintext_pass )
    {     //echo $plaintext_pass; die('==');
      $user = get_userdata( $user_id );
      $subject = $this->default_options( 'user_message_subject' );
      $message = $this->default_options( 'user_message_body' );
      add_filter( 'wp_mail_content_type', array( $this, 'joinnetwork_filter_mail_content_type_text' ), 10, 1 );
      if ( '1' === $this->joinow_get_option( 'custom_user_message' ) ) {
      $subject = esc_html( $this->joinow_get_option( 'user_message_subject' ) );
      $message = $this->joinow_get_option( 'user_message_body' );
      if ( '1' === $this->joinow_get_option( 'send_user_message_in_html' ) && '1' === $this->rpr_get_option( 'user_message_newline_as_br' ) )
      $message = nl2br( (string) $message );
      $from_name = $this->joinow_get_option( 'user_message_from_name' );
      if ( !empty( $from_name ) )
      add_filter( 'wp_mail_from_name', array( $this, 'joinnetwork_filter_welcome_user_mail_from_name' ), 10, 1 );
      if ( FALSE !== is_email( $this->joinow_get_option( 'user_message_from_email' ) ) )
      add_filter( 'wp_mail_from', array( $this, 'joinnetwork_filter_welcome_user_mail_from' ), 10, 1 );
      if ( '1' === $this->joinow_get_option( 'send_user_message_in_html' ) )     
      add_filter( 'wp_mail_content_type', array( $this, 'joinnetwork_filter_mail_content_type_html' ), 10, 1 );
      }
      $subject = $this->replace_keywords( $subject, $user );
      $message = $this->replace_keywords( $message, $user, $plaintext_pass );
      wp_mail( $user->user_email, $subject, $message );
    }
    
    // Send New Registration mail to admin
    public /*.void.*/ function send_admin_mail( /*.int.*/ $user_id, /*.string.*/ $plaintext_pass, $verification_code = '' ) {
	  	
			 $user = get_userdata( $user_id );
			 $subject = $this->default_options( 'admin_message_subject' );
			 $message = $this->default_options( 'admin_message_body' );
			
			add_filter( 'wp_mail_content_type', array( $this, 'joinnetwork_filter_mail_content_type_text' ), 10, 1 );
			if ( '1' === $this->joinow_get_option( 'custom_admin_message' ) ) {
				$subject = esc_html( $this->joinow_get_option( 'admin_message_subject' ) );
				$message = $this->joinow_get_option( 'admin_message_body' );
				if ( '1' === $this->joinow_get_option( 'send_admin_message_in_html' ) && '1' === $this->joinow_get_option( 'admin_message_newline_as_br' ) )
					$message = nl2br( (string) $message );
				$from_name = $this->joinow_get_option( 'admin_message_from_name' );
				if ( !empty( $from_name ) )
					add_filter( 'wp_mail_from_name', array( $this, 'joinnetwork_filter_admin_mail_from_name' ), 10, 1 );
				if ( FALSE !== is_email( $this->joinow_get_option( 'admin_message_from_email' ) ) )
					add_filter( 'wp_mail_from', array( $this, 'joinnetwork_filter_admin_mail_from' ), 10, 1 );
				if ( '1' === $this->joinow_get_option( 'send_admin_message_in_html' ) )
					add_filter( 'wp_mail_content_type', array( $this, 'joinnetwork_filter_mail_content_type_html' ), 10, 1 );
			}
			$subject = $this->replace_keywords( $subject, $user );
			$message = $this->replace_keywords( $message, $user, $plaintext_pass, $verification_code );
			//echo get_option( 'admin_email' ).'=='.$subject.'==='.$message;die('====================');
			wp_mail( get_option( 'admin_email' ), $subject, $message );
   }
   public function send_verification_mail( $user_id, $verification_code ) {
	         $user = get_userdata( $user_id );
		   $subject = $this->default_options( 'verification_message_subject' );
		  $message = $this->default_options( 'verification_message_body' );
		  add_filter( 'wp_mail_content_type', array( $this, 'joinnetwork_filter_mail_content_type_text' ), 10, 1 );
		   
		  if ( '1' === $this->joinow_get_option( 'custom_verification_message' ) ) {
			  $subject = esc_html( $this->joinow_get_option( 'verification_message_subject' ) );
			  $message = $this->joinow_get_option( 'verification_message_body' );
			  if ( '1' === $this->joinow_get_option( 'send_verification_message_in_html' ) && '1' === $this->joinow_get_option( 'verification_message_newline_as_br' ) ) {
				  $message = nl2br( (string) $message );
			  }
			  $from_name = $this->joinow_get_option( 'verification_message_from_name' );
			  if ( !empty( $from_name ) )
				  add_filter( 'wp_mail_from_name', array( $this, 'joinnetwork_filter_verification_mail_from_name' ), 10, 1 );
			  if ( FALSE !== is_email( $this->joinow_get_option( 'verification_message_from_email' ) ) )
				  add_filter( 'wp_mail_from', array( $this, 'joinnetwork_filter_verification_mail_from' ), 10, 1 );
			  if ( '1' === $this->joinow_get_option( 'send_verification_message_in_html' ) )
				  add_filter( 'wp_mail_content_type', array( $this, 'joinnetwork_filter_mail_content_type_html' ), 10, 1 );
		  }
		 	
		   $subject = $this->replace_keywords( $subject, $user );
		   $message = $this->replace_keywords( $message, $user, '', $verification_code );
		  $ret=wp_mail($user->user_email,$subject,$message);  	
	  }

}
?>
