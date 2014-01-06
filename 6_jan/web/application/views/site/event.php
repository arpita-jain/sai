<?php
include_once("header.php");
?></div>
    <div class="Dates-div">
      <div class="col-md-12">
      <h1 class="date-text"><i class="fa fa-bullhorn"></i><span>Events</span><a href="javascript:void();" onClick="location.reload(); "><i class="fa fa-refresh pull-right"></i></a></h1>
      </div>
      <div class="col-md-12">
        <div class="all-Dates">
          <h2>All Events</h2>
          <div class="date-div">
            <div class="dateText Basket">
              <ul>
                <?php
                    foreach ($event as $row) {
                    $event_chk = array();
                    $event_chk = $this->session->userdata('eventId');?> 
                <li class="EverestMain"><i class="fa fa-chevron-circle-right"></i>
                  <div class="Everest-divMain">
                    <div class="Everest-div">
                      <div class="EverestText">
                        <h4><?php echo $row['event_name']; ?>:</h4>
                        <div class="Photos">Photos From The First Ascent</div>
                        <div class="moreBtn"><a href="javascript:void(0);" onclick="viewEvent(<?php echo $row['eventId']; ?>);"  class="fancybox">more...</a> </div>
                        <div class="clear"></div>
                      </div>
                       <strong class="eventscreen-right"><input type="checkbox" class="style2 checkboxes" id="<?php echo $row['eventId']; ?>" onclick="checkEvent(this);" <?php  if (is_array($event_chk) && in_array($row['eventId'], $event_chk)) {echo 'checked';}?>/></strong>
                    <div class="clearfix"></div>
                    </div>
                    <div class="Everest-div Everest-div-border">
                      <div class="LocationDiv">
                        <h4>Location:</h4>
                        <div class="Woodstock"><?php echo $row['vanu_name']; ?></div>
                        <div class="clear"></div>
                      </div>
                      <div class="LocationDiv">
                        <h4>On:</h4>
                        <div class="Woodstock"><?php $date= $row['date'];
                        $timestamp= strtotime($date);
                        $day = date('l', $timestamp); 
                        echo date('d-m-Y',strtotime($date)).",".$day; ?> </div>
                        <div class="clear"></div>
                      </div>
                      <div class="LocationDiv">
                        <h4>Price: </h4>
                        <div class="Woodstock"><img src="<?php echo base_url(); ?>assets/site/images/Pound.png"><?php  $price=$row['price'];echo  number_format($price/100,2); ?></img></div>
                        <div class="clear"></div>
                      </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                  <div class="clear"></div>
                   <?php  
                         }
                    ?>
                    </li>
                    </ul>
            <!-- Modal -->
<div class="modal fade" id="viewEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel" style="color:#000;">Event Details</h4>
            </div>
            <div class="modal-body" style="color:#000;">
                <table id="viewData" class="table table-bordered table-stripped">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="test">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
            </div>
          </div>
        </div>
        <!--all-Dates--> 
      </div>
    </div>
  </div>
  <!--content-->
  <script src="<?php echo base_url(); ?>assets/site/js/filters.js"></script>
  <script src="<?php echo base_url(); ?>assets/site/js/events.js"></script>
<?php
include_once("footer.php");
?>