<?php include_once("header.php"); ?>
</div>
<div class="Dates-div">
      <div class="col-md-12">
        <h1 class="date-text"><i class="fa fa-map-marker"></i><span>Venues</span><a href="javascript:void();"><i class="fa fa-refresh pull-right"></i></a></h1>
      </div>
      <div class="col-md-12">
        <div class="all-Dates">
          <h2>All Venues</h2>
          <div class="date-div">
            <div class="dateText">
              <ul>
              <?php 
              
                    foreach ($tickete as $row) {
                    $tmp= $row['name'];
                  ?>
                <li><i class="fa fa-chevron-circle-right"></i>
                <?php  echo $row['name']; 
                      $venue_chk = $this->session->userdata('venueId');
                      ?>
                        <i class="icon-check" ></i> <strong>
                        <input type="checkbox" class="style2 checkboxes" id="<?php echo $row['id']; ?>" onclick="checkVenue(this);" <?php  if (is_array($venue_chk) && in_array($row['id'], $venue_chk)) {echo 'checked';}?> /></strong>
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