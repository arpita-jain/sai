<?php
include_once("config.php");
class database
{
	private $link;
	function __construct()
	{
		$this->link = mysql_connect(DBHOST,DBUSERNAME,DBPASSWORD);
		mysql_select_db(DBNAME,$this->link) or die(mysql_error());
                
                return;
                
	}
	function __distruct()
	{
		mysql_close($this->link);
	}
        //to get list of region from database
        function get_region()
        {
           $get_region="select `Region` from `stocklist`";
           $regions=mysql_query($get_region) or die;
           $count_re=mysql_num_rows($regions);
           return $count_re;
        }
	//search pdf for library column
	function search_pdf($row)
	{
	$PlanOfSub=str_replace(' ','', ucwords(strtolower($row['Suburb'])).".".ucwords(strtolower($row['Estate']))."."."POS".".".ucwords(strtolower($row['Stage']))."."."pdf");
        $Engineering=str_replace(' ','',ucwords(strtolower($row['Suburb'])).".".ucwords(strtolower($row['Estate']))."."."ENG".".".ucwords(strtolower($row['Stage']))."."."pdf");
        $Compaction=str_replace(' ','',ucwords(strtolower($row['Suburb'])).".".ucwords(strtolower($row['Estate']))."."."COM".".".ucwords(strtolower($row['Stage']))."."."pdf");
        $Concept=str_replace(' ','',ucwords(strtolower($row['Suburb'])).".".ucwords(strtolower($row['Estate']))."."."CON"."."."pdf");
        $LocationMap=str_replace(' ','',ucwords(strtolower($row['Suburb'])).".".ucwords(strtolower($row['Estate']))."."."LOC"."."."pdf");
       // echo $abc=str_replace(' ','',"h l l o");
	$array1=array($PlanOfSub,$Engineering,$Compaction,$Concept,$LocationMap);
        return $array1;
	}
	
	function avail_file($row)
	{
		$obj=new database();
		 $f_array= $obj->search_pdf($row);
                        $a = glob('upload/*.pdf',GLOB_BRACE);
                        $filename=array();
                        $i=0;
                            foreach($a as $arr)
                            {
                            $file=explode('/',$arr);
                            
                            $filename[$i]=$file[1];
                            $i++;
                            }
                            $f_type=array();
                            $j=0;
                             foreach($f_array as $file_type)
                             {
                                 if(in_array($file_type,$filename))
                                 {
                                    $f_type[$j]=$file_type;
                                      $j++;
                                 }
                             }
		 return  $f_type;
        }
	//for parsing excelsheet
        function parseExcel($file)
	{
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($file);
	return $data;
	}
     function getType($wherecond)
     {
	$responseArray=array();
	$sql = "SELECT DISTINCT ".$wherecond." from stocklist";
	$res=mysql_query($sql);
	while($row=mysql_fetch_object($res))
	{
		$responseArray[]=$row;
	}
	return $responseArray;	
     }

     
}
?>	
