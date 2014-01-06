<?php
/**
* @version  Joomla 2.5
* @package  Limo Booking
* @copyright Copyright (C) 2012 KANEV.CO.UK All rights reserved.
* @license  GNU/GPL, see license.txt
* Limo Booking is open source software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>

<?php

class paypal_class 
{
   var $last_error;                 // holds the last error encountered
   var $ipn_log;                    // bool: log IPN results to text file?
   var $ipn_log_file;               // filename of the IPN log
   var $ipn_response;               // holds the IPN response from paypal   
   var $ipn_data = array();         // array contains the POST values for IPN
   var $fields = array();           // array holds the fields to submit to paypal
   function paypal_class() // initialization constructor.  Called when class is created.
   {
		
		$this->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
		
		$this->last_error = '';
		
		$this->ipn_log_file = 'ipn_log.txt'; // populate $fields array with a few default values.  See the paypal
		
		$this->ipn_log = true; // documentation for a list of fields and their data types. These defaul
		
		$this->ipn_response = ''; // values can be overwritten by the calling script.
		
		$this->add_field('rm','2');           // Return method = POST
		
		$this->add_field('cmd','_xclick'); 
		
   }
   function add_field($field, $value) 
   {
      // adds a key=>value pair to the fields array, which is what will be 
      // sent to paypal as POST variables.  If the value is already in the 
      // array, it will be overwritten.
      $this->fields["$field"] = $value;
   }
   function submit_paypal_post_2() 
   {
      // this function actually generates an entire HTML page consisting of
      // a form with hidden elements which is submitted to paypal via the 
      // BODY element's onLoad attribute.  We do this so that you can validate
      // any POST vars from you custom form before submitting to paypal.  So 
      // basically, you'll have your own form which is submitted to your script
      // to validate the data, which in turn calls this function to create
      // another hidden form and submit to paypal.
      // The user will briefly see a message on the screen that reads:
      // "Please wait, your order is being processed..." and then immediately
      // is redirected to paypal. <h3>Please wait, your reservation is being processed...</h3>
		echo "<html>\n";
		
		echo "<head><title>Processing Payment...</title></head>\n";
		
		echo "<body>";
		
		echo "<center></center>\n";
		
		echo "<form method=\"post\" name=\"form\" action=\"".$this->paypal_url."\">\n"; 
		echo "<div><input class='button' type='submit'  name='submit' value='' /></div>";
		
		foreach ($this->fields as $name => $value) 
		{
		   echo "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
		}
		
		echo "</form>\n";
		
		echo "</body></html>\n";
   }
   function submit_paypal_post() 
   {
      // this function actually generates an entire HTML page consisting of
      // a form with hidden elements which is submitted to paypal via the 
      // BODY element's onLoad attribute.  We do this so that you can validate
      // any POST vars from you custom form before submitting to paypal.  So 
      // basically, you'll have your own form which is submitted to your script
      // to validate the data, which in turn calls this function to create
      // another hidden form and submit to paypal.
      // The user will briefly see a message on the screen that reads:
      // "Please wait, your order is being processed..." and then immediately
      // is redirected to paypal. <h3>Please wait, your reservation is being processed...</h3>
							
/*<img src='http://".$_SERVER['HTTP_HOST']."/".substr(JPATH_SITE,19,20)."/components/".COMPONENT."/images/loader.gif"."' >*/
		echo " <h3>Please Wait, Your Donation Is Being Processed...</h3>";
		
      echo "<html>\n";
      echo "<head><title>Processing Payment...</title></head>\n";
      echo "<body onLoad=\"document.form.submit();\">\n";
      echo "<center></center>\n";
      echo "<form method=\"post\" name=\"form\" action=\"".$this->paypal_url."\">\n"; 
	  
	 //echo "<div style='float:left;color:#FFFFFF;'><a href='index.php'><span style='color:#FFFFFF;' class='button'> << PAY LATER </span></a></div>";
	 
	  //echo "<div style='float:right;'><input class='button' type='submit' name='submit' value='Pay With Paypal >>' /></div>";
      foreach ($this->fields as $name => $value) 
	  {
         echo "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
      }
      echo "</form>\n";
      echo "</body></html>\n";
   }
   
   function validate_ipn() 
   {
      
      $url_parsed=parse_url($this->paypal_url);       // parse the paypal URL  
      // generate the post string from the _POST vars aswell as load the
      // _POST vars into an arry so we can play with them from the calling
      // script.
      $post_string = '';    
      foreach ($_POST as $field=>$value) 
	  { 
         $this->ipn_data["$field"] = $value;
         $post_string .= $field.'='.urlencode($value).'&'; 
      }
      $post_string.="cmd=_notify-validate"; // append ipn command
      $fp = fsockopen($url_parsed[host],"80",$err_num,$err_str,30);  // open the connection to paypal
      if(!$fp) 
	  {
         // could not open the connection.  If loggin is on, the error message
         // will be in the log.
         $this->last_error = "fsockopen error no. $errnum: $errstr";
         $this->log_ipn_results(false);       
         return false;
      } 
	  else 
	  { 
         
         fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n");  // Post the data back to paypal
         fputs($fp, "Host: $url_parsed[host]\r\n"); 
         fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
         fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
         fputs($fp, "Connection: close\r\n\r\n"); 
         fputs($fp, $post_string . "\r\n\r\n"); 
         
         while(!feof($fp))  // loop through the response from the server and append to variable 
		 { 
            $this->ipn_response .= fgets($fp, 1024); 
         } 
         fclose($fp); // close connection
      }
      if (eregi("VERIFIED",$this->ipn_response)) 
	  {
         $this->log_ipn_results(true);  // Valid IPN transaction.
         return true;       
      } 
	  else 
	  {
         $this->last_error = 'IPN Validation Failed.';  // Invalid IPN transaction.  Check the log for details.
         $this->log_ipn_results(false);   
         return false;
      }
   }
   function log_ipn_results($success) 
   {
      if (!$this->ipn_log) return;  // is logging turned off?
      $text = '['.date('m/d/Y g:i A').'] - ';   // Timestamp
      if ($success) $text .= "SUCCESS!\n";  // Success or failure being logged?
      else $text .= 'FAIL: '.$this->last_error."\n";
      $text .= "IPN POST Vars from Paypal:\n";  // Log the POST variables
      foreach ($this->ipn_data as $key=>$value) 
	  {
         $text .= "$key=$value, ";
      }
      $text .= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;  // Log the response from the paypal server
      $fp=fopen($this->ipn_log_file,'a');  // Write to log
      fwrite($fp, $text . "\n\n"); 
      fclose($fp);  // close file
   }
   function dump_fields() 
   {
      // Used for debugging, this function will output all the field/value pairs
      // that are currently defined in the instance of the class using the
      // add_field() function.
      echo "<h3>paypal_class->dump_fields() Output:</h3>";
      echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">
            <tr>
               <td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>
               <td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>
            </tr>"; 
      ksort($this->fields);
      foreach ($this->fields as $key => $value) 
	  {
         echo "<tr><td>$key</td><td>".urldecode($value)."&nbsp;</td></tr>";
      }
      echo "</table><br>"; 
   }
}         
?>