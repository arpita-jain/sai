<?php
/*Plugin Name: Category
Plugin URI: http://www.cisin.com/
Description: Allow Join Network on site
Author: CIS
Author URI: hhttp://www.cisin.com/
Version: 1.1
* Incldue Template File using type of group*/

/*Admin part is display here*/
if(is_admin())
{
     add_action('admin_menu','ADD_Category_Menu');
   
     function ADD_Category_Menu()
     {
         add_menu_page('Add Category', 'Add Category', 'administrator', 'Category/category.php', 'Add_Category_admin');
	 
         add_filter( 'plugin_action_links', 'plugin_action_links', 10, 2 );
     }   
    
}
function Add_Category_admin(){
   
    global $wpdb;
	        /******************Database Operations*************/
	       if($_GET['action']=='del'){
	       $wpdb->query("DELETE FROM wp_trades_categories WHERE id =".$_GET['id']); 
	       }
	    if (isset($_POST['Submit'])) {
		     
		    if(($_POST['catid']) ==''){    
		     $wpdb->insert( 'wp_trades_categories', array( 'category_name' => $_POST['category_name']), array( '%s'));
		    }else{
	         $wpdb->update("wp_trades_categories",  array('category_name' => $_POST['category_name']),array('id' => $_POST['catid'] ));
		     }
	    }
	    ?>
	       <h2> Add/Edit Categories for Trades </h2>
		    <form name="category" method="post" action="<?php echo site_url('/wp-admin/admin.php?page=Category/category.php');?>">
		    <label>Category :</label>
		    <input type="text" name="category_name" id="category_name" required="required" value="<?php if($_GET['val']!='') echo $_GET['val'];?>"/>
		    <input type="hidden" name="catid" value="<?php if($_GET['action']=="del"){echo '';}else{ echo $_GET['id'];}?>"/>
		    <input type="hidden" name="action" value="<?php echo $_GET['action'];?>"/><br/><br/>
		    <input type="submit" name="Submit" class="button-primary"/>
		    </form>
	  <h2>List of categories</h2>
	  <table cellspacing="0" class="wp-list-table widefat fixed pages">
	<thead>
	<tr>
	  <th style="" class="manage-column column-cb check-column" id="cb" scope="col"></th><th style="" class="manage-column column-title sortable desc" id="title" scope="col"><span>Category</span></th><th style="" class="manage-column column-author" id="author" scope="col">Edit</th><th style="" class="manage-column column-date sortable asc" id="date" scope="col"><span>Delete</span></th>
	</tr>
	</thead>
	<tbody id="the-list">
	   <?php /*  require_once('pagination.class.php');
	   $items = $wpdb->get_results( "SELECT * FROM wp_trades_categories" );
	if($items > 0) {
        $p = new pagination;
        $p->items($items);
        $p->limit(2); // Limit entries per page
        $p->target("admin.php?page=Category/category.php");
        $p->currentPage($_GET[$p->paging]); // Gets and validates the current page
        $p->calculate(); // Calculates what to show
        $p->parameterName('paging');
        $p->adjacents(1); //No. of page away from the current page
 
        if(!isset($_GET['paging'])) {
            $p->page = 1;
        } else {
            $p->page = $_GET['paging'];
        }
 
        Query for limit paging
        $limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
        $show = $p->show();
	
} else {
    $show = "No Record Found";
} 	*/					
 
		    $done = $wpdb->get_results("SELECT * FROM wp_trades_categories ORDER BY category_name ASC ".$limit);
			foreach($done as $event_vals){ $couter++;?>
				<tr>
				 <td><?php echo $couter;?></td><td style="margin-left:30px;"><?php echo $event_vals->category_name;?></td><td><a href="<?php echo site_url('wp-admin/admin.php?page=Category/category.php&id='.$event_vals->id.'&val='.$event_vals->category_name.'&action=edit');?>"><img src="<?php echo site_url('/wp-includes/images/edit.jpeg');?>" alt="Edit" style="height: 15%; width: 17%;"></td><td><a href="<?php echo site_url('wp-admin/admin.php?page=Category/category.php&id='.$event_vals->id.'&action=del');?>"><img src="<?php echo site_url('/wp-includes/images/delete.jpeg');?>" alt="Delete" style="height: 15%; width: 28%;"></td>
			      </tr>
			 <?php   }?>
	</tbody>
	  </table>
 <?php } ?>