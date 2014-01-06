<?php

include_once("includes/config.php");
include_once("includes/database.php");
include_once("includes/oleread_helper.php");
include_once("includes/reader_helper.php");
$obj=new database();

if (isset($_POST['button1'])) //  Do  THE FOLLOWING WHEN BUTTON IS PRESSED
{

	    if ($_FILES["file"]["error"] > 0)
	    {
		echo "Error: " . $_FILES["file"]["error"] . 
		"You have not selected a file or some other error <br />";
	    }
	    else
	    {       //              Errorless  start 
			$file_name=$_FILES["file"]["name"]; //echo $file_name;
			$file_type=$_FILES["file"]["type"];
			$location="/opt/lampp/htdocs/alex_project"; // write the location on 
			// server where a copy should be created
			move_uploaded_file($_FILES["file"]["tmp_name"],
			$location . $_FILES["file"]["name"]);
			$path = $location . $_FILES["file"]["name"];
			//chmod($path,0777);
			$data = $obj->parseExcel($path);

	    if(!empty($data))
	    {

			$data = $data->sheets[0];
			// echo $data['cells'][2][1]; die;
			
			$Flag=0;
			for($i=2; $i <= $data['numRows'] ; $i++)
			{
				    $id = $data['cells'][$i][1];$fname =$data['cells'][$i][1];
				    if($id != '' && $fname != '')
				    {

						$Lot = checknull(check_exist($data['cells'][$i],1)); 
						$Street =checknull(check_exist($data['cells'][$i],2));
						$Estate =checknull(check_exist($data['cells'][$i],3));
						$Suburb =checknull(check_exist($data['cells'][$i],4));
						$Region = checknull(check_exist($data['cells'][$i],5));
						$Size = checknull(check_exist($data['cells'][$i],6));
						$Width = checknull(check_exist($data['cells'][$i],7));
						$Length = checknull(check_exist($data['cells'][$i],8));                    
						$Price = checknull(check_exist($data['cells'][$i],9));
						$Status = checknull(check_exist($data['cells'][$i],10));
						$Covenants =checknull(check_exist($data['cells'][$i],11));
						$Facing =checknull(check_exist($data['cells'][$i],12));
						$Fall = checknull(check_exist($data['cells'][$i],13));
						$Easment =checknull(check_exist($data['cells'][$i],14));
						$Title = checknull(check_exist($data['cells'][$i],15));
						$Stage = checknull(check_exist($data['cells'][$i],16));
						
						
						 if($Lot!="" && $Estate!="" &&  $Street!="" &&  $Suburb!="" &&  $Region!="" &&  $Size!="" && $Width!="" &&  $Length!="" && $Price!="" &&  $Status!="" && $Covenants!="" &&  $Facing!="" && $Fall!="" && $Easment!="" && $Title!="" && $Stage!="")
						 {
							    if(is_numeric($Lot) && is_numeric($Size) && is_numeric($Width) && is_numeric($Fall) && is_numeric($Stage) && is_numeric($Length) )
							    {
									if(is_string($Estate) && is_string($Street)  && is_string($Suburb)  && is_string($Region) && is_string($Price) && is_string($Status) && is_string($Covenants) && is_string($Facing) && is_string($Easment) && s_string($Title))
									{
						 $result[] ="insert into stocklist(Lot,Street,Estate,Suburb,Region,Size,Width,Length,Price,Status,Covenants,Facing,Fall,Easment,Title,Stage) values('".$Lot."', '".$Street."', '".$Estate."', '".$Suburb."', '".$Region."', '".$Size."', '".$Width."', '".$Length."', '".$Price."','".$Status."','".$Covenants."','".$Facing."','".$Fall."','".$Easment."','".$Title."','".$Stage."')";
						 $Flag++;
									}
									else
									{
									$Flag--;
									$_SESSION["error_msg"]="Estate,Street,Suburb,Region,Price,Status,Covenants,Facing,Easment,Title should be a string on line number".$Flag;
									}
									}
									else
									{
									$Flag--;
									$_SESSION["error_msg"]="Lot,Size,Width,Fall,Stage,Length should be a Number on line number".$Flag;
									}
						   }
						   else
						   {
							   
						    $Flag--;
						   }
				     }
				     

			 }
				    if($Flag==count($result))
				    {
						connect_db();
						foreach($result as $arr)
						{
							    mysql_query($arr) or die(mysql_error());
						}
						
						$_SESSION["error_msg"]="Spreadsheet has successfully uploaded";
				    }
				    else
				    {
						$_SESSION["error_msg"].="  incorrect Spreadsheet";
				    }

                        }
            }

header("location:admin.php");
}
function checknull($val)
       {
	
       if( is_null($val) )
         {
          return '';	 
         }
         else
         {
         return $val;
         }
       }

      function check_exist($a,$c)
      {
       return isset($a[$c])?$a[$c]:'';	 
      }
        function connect_db()
       {
	$delete_data="delete from stocklist";
       $result=mysql_query($delete_data);
      return $result;
       }
?>

