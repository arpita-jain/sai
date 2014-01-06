<?php include_once("header.php"); ?>
</div>
<div class="Dates-div">
      <div class="col-md-12">
        <h1 class="date-text"><i class="fa fa-calendar"></i><span>Dates</span><a href="javascript:void();"><i class="fa fa-refresh pull-right"></i></a></h1>
      </div>
      <div class="col-md-12">
        <div class="all-Dates">
          <h2>All Dates</h2>
          <div class="date-div">
            <div class="dateText">
              <ul>
              <?php 
              foreach ($eventdate as $row) {
                  ?>
                <li><i class="fa fa-chevron-circle-right"></i>
                <?php   
                        $date= $row;
                        $formatdate=date('d-m-Y',strtotime($date));
                        $timestamp= strtotime($date);
                        $day = date('l', $timestamp); 
                        echo $formatdate.", ".$day;
                        $eventsdate_chk=$this->session->userdata('eventdate');
                        ?>
                        <strong><input type="checkbox" class="style2 checkboxes" id="<?php echo date('d-m-Y',strtotime($date)); ?>" onclick="checkEventDate(this);"  <?php if (is_array($eventsdate_chk) &&  in_array($formatdate, $eventsdate_chk)) {echo 'checked';}?>/></strong>
                  <div class="clearfix"></div>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
        <!--all-Dates--> 
      </div>
    </div>
  </div>
<script src="<?php echo base_url(); ?>assets/site/js/filters.js"></script>
  <!--content--> 
    <div class="clearfix"></div>
</div>
<?php
include_once("footer.php");
?>