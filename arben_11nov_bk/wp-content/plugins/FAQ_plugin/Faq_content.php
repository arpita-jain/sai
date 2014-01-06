<?php
/**
 * Plugin Name: FAQ Content
 **/
/*for frontend*/
add_action('admin_menu','get_menus');
include_once(ABSPATH.'wp-content/plugins/job-post/pagination.class.php');?>
<?php /*step-1*/
function get_menus()
{  add_menu_page('My Plugin Options', 'FAQ_Content', 'manage_options', 'FAQ_Content', 'faq_content');
     //add_menu_page( 'My Plugin Options', 'Demo', 'manage_options', 'demoplugin', 'my_plugin_options2' );
}
/* function step3 */
function faq_content()
{?><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
     $("#category_txt").hide();
	$('#category').change(function() {
	{
            var value = $("#category option:selected").text(); //alert(value);
            if(value =="Others"){
                $("#category_txt").show();
            }else{
                $("#category_txt").hide();
            }
           }
});
     });              
</script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function()
		  {
		   $('.edit_link').click(function()
					{
				       //alert(cat);
				       var cat=this.title;;
				       $.ajax({
					 url:'<?php echo site_url()."/ajax_response_file.php";?>',
					 type:'post',
					 data:{
					      cat:cat
					   },
				       });
				       //alert(cat);
				      });
});
</script>
<script type="text/javascript">
	 $(document).ready(function(){
            url = $("#url").val();
	   // alert(url);
                $(".page_class").click(function(){
		 // alert(this.title);
		  owntitle = this.title;
		  window.location = url+'&paging='+owntitle;
                 });
		 //for next button
		 $('.next').click(function(){
		    owntitle = this.title;
		    window.location = url+'&paging='+owntitle;
		    });
		 $('.prev').click(function(){
		    owntitle = this.title;
		   window.location = url+'&paging='+owntitle;
		    });
		  });
</script>
<style>
    .list_table tr td
    {
        padding: 10px;
    }
    .job-pagintn-part a.active{
     background: url("../pagintn-btn.png") no-repeat scroll center top transparent;
    }
    .job-pagintn-part a{
     
    float: left;
    font-family: 'helvetica_neue_lt_std45_light';
    font-size: 12px;
    font-weight: normal;
    height: 26px;
    line-height: 25px;
    margin: 0 4px 0 0;
    padding: 0;
    text-align: center;
    text-decoration: none;
    width: 26px;
    }
    
</style>
<?php global $wpdb;
     $category_id= $_REQUEST['cat_id'];
     $dcat=$_REQUEST['dcat'];
      $catid=$_REQUEST['catid'];
      if(isset($catid)){
        $delete_data = $wpdb->get_results("DELETE FROM wp_faq_category where id='$catid'");
       $wpdb->get_results("DELETE FROM wp_faq_content where category='$catid'");
      }
     if(isset($dcat))
     {
     $delete_data = $wpdb->get_results("DELETE FROM wp_faq_content where Faq_id='$dcat'");
     }?>
<h2>Add/Edit FAQ Categories</h2>  <h3><a href="<?php echo site_url().'/wp-admin/admin.php?page=FAQ_Content';?>">Add New</a></h3>
<form name="category_frm" action="" method="post">
<?php if($category_id==""){
       $tbl_name= 'wp_faq_content';
       $cat_tbl_name= 'wp_faq_category';
      if(isset($_POST['category']))
	  {       if($_POST['category']=="Others")
	    {
		     $Category=$_POST['category_txt'];
		     $latdata=array('category_name'=>$Category);
		     $row_affected =$wpdb->insert($cat_tbl_name,$latdata);
		     $Category_id = $wpdb->insert_id;
            }else{
		    $Category_id=$_POST['category'];
	     }
		 $question=$_POST['question'];
		 $ans_content=$_POST['ans_content'];
		 $latdata=array('category'=>$Category_id, 'question'=>$question, 'answer'=>$ans_content);
		 $row_affected =$wpdb->insert($tbl_name,$latdata);
		 if($row_affected==1){ ?>
            <h4>Category added sucessfully!!</h4>
         <?php  }
    }          //print_r($row_affected);}
?>
    <table class="form-table">
       <tbody>
       <tr valign="top">
	   <th scope="row">Catgory </th>
	   <td><select name="category" id="category">
		<?php $retrieve_data1 = $wpdb->get_results("SELECT * from wp_faq_category");
               foreach($retrieve_data1 as $retrieved_data)
		{
?>		
<option value="<?php echo $retrieved_data->id;?>"><?php echo $retrieved_data->category_name;?></option><?php } ?><option value="Others">Others</option></select>
	  <input type="text" name="category_txt" id="category_txt"></td>
      </tr>
      <tr>
	  <th scope="row">Sub question</th>
	  <td><input type="text" name="question" id="question" required="required"/></td>
      </tr>
     <tr>
      <th scope="row">Answer</th><td></th><textarea  rows="4" cols="50" name="ans_content" required="required"></textarea></td>
     </tr>
   </table>
   <input type="submit" class="button-primary" name="submit" value="Save"/>
   <?php }else {
       global $wpdb;
       $tbl_name= 'wp_faq_content';
       $cat_tbl_name= 'wp_faq_category';
      if(isset($_POST['category']))
	  {       if($_POST['category']=="Others")
	    {
		     $Category=$_POST['category_txt'];
		     $latdata=array('category_name'=>$Category);
		     $row_affected =$wpdb->insert($cat_tbl_name,$latdata);
		     $Category_id = $wpdb->insert_id;?>
                        <h4>Category added successfully!!</h4>
           <?php }else{
		    $Category_id=$_POST['category'];
	     }
		 $question=$_POST['question'];
		 $ans_content=$_POST['ans_content'];
		 //Update category table data
		 $data = array('category'=>$Category_id, 'question'=>$question, 'answer'=>$ans_content);
		 $where = array('Faq_id'=>$category_id);
		 $row_affected =$wpdb->update($tbl_name,$data,$where);
		 if($row_affected==1){ ?>
            <h4>Category updated successfully!!</h4>
         <?php  }
} ?>
    <table class="form-table">
       <tbody>
       <?php $retrieve_value = $wpdb->get_results("select * from wp_faq_content where Faq_id='$category_id'"); 
		foreach($retrieve_value as $retrieved_value){
		 $cat=$retrieved_value->category;?>
       <tr valign="top">
	   <th scope="row">Catgory </th>
	   <td><select name="category" id="category">
		<?php $retrieve_value1 = $wpdb->get_results("SELECT * from wp_faq_category");
               foreach($retrieve_value1 as $retrieved_value1)
		{
?>		
<option  <?php if($retrieved_value1->id == $cat){?> selected="selected" <?php }?> value="<?php echo $retrieved_value1->id;?>"><?php echo $retrieved_value1->category_name;?></option><?php } ?><option value="Others">Others</option></select>
	  <input type="text" name="category_txt" id="category_txt"></td>
      </tr>
      <tr>
	  <th scope="row">Sub question</th>
	  <td><input type="text" name="question" id="question" required="required" value="<?php echo $retrieved_value->question;?>"/></td>
      </tr>
     <tr>
      <th scope="row">Answer</th><td></th><textarea  rows="4" cols="50" name="ans_content" required="required"><?php echo $retrieved_value->answer;?></textarea></td>
     </tr>
   </table>
   <input type="submit" class="button-primary" name="submit" value="Save"/>
   <?php } }?>

</form><br/>
<div style="border-top: 2px dashed #C1C1C1;"></div>
<h2><a href="<?php echo site_url().'/wp-admin/admin.php?page=FAQ_Content';?>">FAQ List</a></h2>
 <table class="form-table">
       <tbody>
         <?php  $edit_cat=$_REQUEST['edit_cat'];
          if(isset($edit_cat)==0){ ?>  <tr valign="top"><th scope="row"><h2>Category</h2></th>
             <th scope="row"><h2>Edit</h2></th>
              <th scope="row"><h2>Delete</h2></th>
        </tr>
    <!-- <table class="list_table" width="100%"> -->
<div>
<?php

global $wpdb;
//echo "select * from wp_faq_category ";
$postdata = $wpdb->get_results("select * from wp_faq_category ");

$items = count($postdata); // number of total rows in the database
if($items > 0) {
    //echo "====";
$p = new pagination;
$p->items($items);
        $p->limit(5); // Limit entries per page
        $p->target(site_url()."/wp-admin/admin.php?page=FAQ_Content");
        $p->currentPage($_GET[$p->paging]); // Gets and validates the current page
        $p->calculate(); // Calculates what to show
        $p->parameterName('paging');
        $p->adjacents(1); //No. of page away from the current page
	//print_r($p); 
        if(!isset($_GET['paging'])) {
	    $p->page = 0;
            $p->page = 1;
	  }
	 else
	  {
            $p->page = $_GET['paging'];
	  }
        //Query for limit paging
        $limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
        $show = $p->show();
	  }
	  else
	  {
		    $show = "No Record Found";
	  }
	 
	  $retrieve_data = $wpdb->get_results("select * from wp_faq_category ".$limit);
	  //print_r($retrieve_data);
	  //$postdata = $wpdb->get_results($query);
?>
            <?php /*$retrieve_data = $wpdb->get_results("select * from wp_faq_category "); */
       foreach($retrieve_data as $retrieved_data2){?>
        <tr valign="top">
	   <th scope="row"><strong><?php echo $retrieved_data2->category_name;$cat_id=$retrieved_data2->id;?></strong></th>
           <td><a href="<?php site_url();?>/wp-admin/admin.php?page=FAQ_Content&edit_cat=<?php echo $cat_id; ?>"">Edit</a></td><td><a onclick="return confirm('Are You Sure, You want to delete Category')" href="<?php site_url();?>/wp-admin/admin.php?page=FAQ_Content&catid=<?php echo $cat_id; ?>"><img style="height:25px; width:25px;" src=" <?php echo site_url().'/wp-content/plugins/FAQ_plugin/delete.jpeg';?>"/></a></td>
           </tr>
            <?php }
        }else{ 
            ?>
          <?php $retrieve_data3 = $wpdb->get_results("select * from wp_faq_content where category= $edit_cat");
               if($retrieve_data3[0]!=""){ ?>
          <tr valign="top"><th scope="row"><h2>Question</h2></th>
             <th scope="row"><h2>Edit</h2></th>
              <th scope="row"><h2>Delete</h2></th>
        </tr>
             <tr valign="top">
        <?php foreach($retrieve_data3 as $retrieved_data3){ ?>
                <input type="hidden" value="<?php echo $retrieved_data3->Faq_id;?>" class="category_id" name="category_id">
                <td><?php echo $retrieved_data3->question;?></td>
              <td><a href="<?php site_url();?>/wp-admin/admin.php?page=FAQ_Content&cat_id=<?php echo $retrieved_data3->Faq_id; ?>"><img style="height:25px; width:25px;" src=" <?php echo site_url().'/wp-content/plugins/FAQ_plugin/edit.jpeg';?>"/></a></td>
             <td><a onclick="return confirm('Are You Sure, You want to delete ?')" href="<?php site_url();?>/wp-admin/admin.php?page=FAQ_Content&dcat=<?php echo $retrieved_data3->Faq_id; ?>"><img style="height:25px; width:25px;" src=" <?php echo site_url().'/wp-content/plugins/FAQ_plugin/delete.jpeg';?>"/></a></td>
            </tr>
	 
		<?php }
        }else{
            echo '<h3>NO Questions Found</h3>';
            }
      }?>
         <input type="hidden" id="url" value="<?php echo site_url().'/wp-admin/admin.php?page=FAQ_Content'?>" />
 <?php }
 function Show_faq_answer(){
  global $wpdb;
$catid=$_REQUEST['cat'];
if($catid==""){
  $Data = $wpdb->get_results("SELECT * FROM `wp_faq_category` LIMIT 0 , 1");
  $catid= $Data[0]->id;
}
  $Data = $wpdb->get_results("select * from wp_faq_content where category= $catid");
?>
   <div class="term-condition-area">
<h3>Answer</h3>
 <div class="faq-content-bg">
<div class="term-condition-txt">
<?php foreach($Data as $val){ ?>
<div class="term-condition-rw">
 <h3><?php echo $val->question;?></h3>
 <p><?php echo $val->answer;?></p>
</div>
<?php }?>
</div>
</div>
 </div>
 <?php }add_shortcode("Show_faq_answer","Show_faq_answer");
?>