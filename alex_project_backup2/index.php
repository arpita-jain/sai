<?php
include("includes/config.php");
include("includes/database.php");
$obj=new database();
$regionOptions='';$rselected='';
$suburbOptions='';$sselected='';
$estateOptions='';$eselected='';

$regionList=$obj->getType('Region');
$suburbList=$obj->getType('Suburb');
$estateList=$obj->getType('Estate');

for($i=0;$i<count($regionList);$i++)
{
    if(isset($_REQUEST['result']) && $_REQUEST['result']!="" && $_REQUEST['result']==$regionList[$i]->Region)
    {
        $rselected='selected="selected"';
    }
    else
    {
        $rselected='';
    }
    $regionOptions.='<option value="'.$regionList[$i]->Region.'" '.$rselected.'>'.$regionList[$i]->Region.'</option>';
}
for($i=0;$i<count($suburbList);$i++)
{
    if(isset($_REQUEST['result']) && $_REQUEST['result']!="" && $_REQUEST['result']==$suburbList[$i]->Suburb)
    {
        $sselected='selected="selected"';
    }
    else
    {
        $sselected='';
    }
    $suburbOptions.='<option value="'.$suburbList[$i]->Suburb.'" '.$sselected.'>'.$suburbList[$i]->Suburb.'</option>';
}
for($i=0;$i<count($estateList);$i++)
{
    if(isset($_REQUEST['result']) && $_REQUEST['result']!="" && $_REQUEST['result']==$estateList[$i]->Estate)
    {
        $eselected='selected="selected"';
    }
    else
    {
        $eselected='';
    }
    $estateOptions.='<option value="'.$estateList[$i]->Estate.'" '.$eselected.'>'.$estateList[$i]->Estate.'</option>';
}

//error_reporting(0);
$flag =0;
$flag2=0;
$va ='';
if(isset($_GET['submit']))
{
    $views=$_GET['views'];
   
    if($_GET['librarycode']!='')
    {
            $l_code= "select * from  Library_code";
            $l_result=mysql_query($l_code);
            $l_code_row=mysql_fetch_array($l_result);
            $_GET['librarycode'];
            if($_GET['librarycode']==$l_code_row['l_code'])
            {
            $flag  = 1;
            $library_code=$_GET['librarycode'];
            }
            else
            {
                
            echo $l_msg="<div style='color:red; margin-left: 42%;'>incorrect library code</div>";
            $library_code = "";
            }
     }
    else
    {
            $library_code="";
    }
    $result ='';
    if(isset($_GET['result']))
    {
        $result=$_GET['result'];
        $flag2 =1;
    }    
}
else
{
    $library_code="";
   $views='all';
   }
   
?>
<html>
    <head>
        <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <link href="css/myfile.css" rel="stylesheet">
    <!--<script src="js/p_region.js"></script>-->
        <!--<script src="js/sh_dropdown.js"></script>-->
        <script src="js/sh_download.js"></script>
        <?php if($flag2 ==1){
            echo "<style>#result{display: inline;}</style>";
        }
        if($flag ==1){
            echo "<style>#lcode,#lcodetd{display: block;}</style>";
        } ?>
        <script>
            var regionHtml='<?php echo $regionOptions;?>';
            var suburbHtml='<?php echo $suburbOptions;?>';
            var estateHtml='<?php echo $estateOptions;?>';
            
            jQuery(document).ready(function(){
          
                 $("#result").hide();
                <?php if(isset($_REQUEST['views']) && $_REQUEST['views']=="region"){?>
                     $("#result").show();
                     $("#result").html(regionHtml); 
                    <?php }?>
                <?php if(isset($_REQUEST['views']) && $_REQUEST['views']=="suburb"){ ?>
                     $("#result").show();
                     $("#result").html(suburbHtml); 
                    <?php }?>
                <?php if(isset($_REQUEST['views']) && $_REQUEST['views']=="estate"){?>
                 $("#result").show();
                 $("#result").html(estateHtml); 
                    <?php }?>
                
                
                $("#views").change(function(){                    
                    if(this.value=="region"){
                      $("#result").show();
                      $("#result").html(regionHtml);  
                    }
                    else if(this.value=="suburb"){
                      $("#result").show();
                      $("#result").html(suburbHtml);  
                    }
                    else if(this.value=="estate"){
                      $("#result").show();
                      $("#result").html(estateHtml);  
                    }
                    else{
                        $("#result").hide();  
                    }
                });
                
                /*for download pdf*/
                $("select").change(function() {
                    var value = $(this).val();
                    $("a").hide();
                    document.getElementById(value).style.display = "block";
                    });
            });

        </script>
    </head>
    <body>
       <div>
        <center>
        <form name="search_form" id="search_form" method="get" >
                Library code &nbsp;&nbsp;&nbsp;<input type="password" name="librarycode" id="librarycode" value="<?php echo $library_code;?>" >
                     <select id="views" name="views">
                            <option value="all" id="all"  name="all" <?php if($views =="all") echo "selected='selected'"; ?>>All</option>
                            <option value="region" id="region" name="region" <?php if($views=="region") echo "selected='selected'"; ?>>Region</option>
                            <option value="suburb" id="suburb" name="suburb" <?php if($views=="suburb") echo "selected='selected'"; ?> >Suburb</option>
                            <option value="estate" id="estate" name="estate" <?php if($views=="estate") echo "selected='selected'"; ?> >Estate</option>
                        </select>
                         <select id="result" name="result"></select>
                        
                        <input type="submit" name="submit" class="submit" value="search"/>
                         <table class="m_table">
                         <tr><td colspan=17 align="center"><h3>Land Stocklist[Estate Name][Suburb Name]<br/>Call 1300 My Land[1300 695 263]</h3></td></tr>
                    <tr style="background: #66CC99;">
                    <th>Lot</th>
                    <th>Street</th>
                    <th>Estate</th>
                    <th>Suburb</th>
                    <th>Region</th>
                    <th>Size</th>
                    <th>Width</th>
                    <th>Length</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Covenants</th>
                    <th>Facing</th>
                    <th>Fall</th>
                    <th>Easment</th>
                    <th>Title</th>
                    <th>Stage</th>
                    <td id="lcode" >Library</td>
                     </tr>
                    <?php
                    $where = '';
                    if($views=="region" || $views=="suburb" || $views=="estate"){
                       $where = "where ".$views."='".$result."'";
                    }
                      $sql ="select * from stocklist ".$where." ORDER BY `Lot`";
                    $rs=mysql_query($sql);
                    while($row=mysql_fetch_array($rs))
                    {
                       // $obj=new database();
                        $avail_file= $obj->avail_file($row);
                     ?>
                   <tr <?php if($row['Status']=="Hold" or $row['Status']=="hold"){ echo 'style="color:blue;"';} else if($row['Status']=="Sold" or $row['Status']=="sold"){ echo 'style="color:red;"';} ?> >
                                <td><?php echo $row['Lot']; ?></td>
                                <td><?php echo $row['Street']; ?></td>
                                <td><?php echo  $row['Estate']; ?></td>
                                <td><?php echo $row['Suburb']; ?></td>
                                <td><?php echo $row['Region']; ?></td>
                                <td><?php echo $row['Size']; ?></td>
                                <td><?php echo $row['Width']; ?></td>
                                <td><?php echo $row['Length']; ?></td>
                                <td><?php echo $row['Price']; ?></td>
                                <td><?php echo $row['Status']; ?></td>
                                <td><?php echo $row['Covenants']; ?></td>
                                <td><?php echo $row['Facing']; ?></td>
                                <td><?php echo $row['Fall']; ?></td>
                                <td><?php echo $row['Easment']; ?></td>
                                <td><?php echo $row['Title']; ?></td>
                                <td><?php echo $row['Stage']; ?></td>
                                <td id="lcodetd">
                                     <select class="download" id="download" name="download">
                                <option selected="selected" value="">--download pdf--</option>
                                <?php
                                foreach( $avail_file as $f_library)
                                {
                                    ?>
                                <option name="<?php echo $f_library; ?>" value="<?php echo $f_library; ?>" style="width: 170px;"><?php echo $f_library; ?></option>
                                <?php
                                }
                             ?>
                             </select>&nbsp;&nbsp;
                            <?php
                            foreach($avail_file as $download_file)
                                {
                                    ?>
                               <a style="display: none;" id="<?php echo $download_file; ?>" href="download.php?file=<?php echo $download_file; ?>" target="_blank">Download file</a>
                                <?php
                                }
                                ?>                               
                               </td>
                            </tr>
                      <?php
                      }
                       ?>
                 </table>
            </form>
        </center>
         </div>
         </body>
</html>
