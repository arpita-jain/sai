<?php
include_once("header.php");
?>

<div class="col-md-8 pull-left">
    <form action="<?php echo site_url(); ?>kiosk/searchOnTickets" method="post" name="frm_search">
        <div class="search-L">
            <input  type="text" name="search_text" value="">
            <input type="submit" value="Search" name="search_btn">
        </div>
    </form>
</div>
</div>
<div class="Dates-div">
<div class="col-md-12">
    <h1 class="date-text"><i class="fa fa-ticket"></i><span>Tickets</span>
        <a class="btn btn-primary pull-right" href="javascript:void();" onclick="addtobasket();" ><i class="icon-shopping-cart"></i> Add-To-Basket</a>
    </h1>
</div>
<div class="col-md-12">
    <div class="all-Dates">
        <h2>All Tickets</h2>
        <div class="date-div">
            <div class="dateText Basket">
                <ul>
                    <?php $i = 0;
                    foreach ($events as $row) {   ?>                   
                        <li class="EverestMain"><i class="fa fa-chevron-circle-right"></i>
                            <div class="Everest-divMain">
                                <div class="Everest-div">
                                    <div class="EverestText">
                                       <input type="checkbox" id="<?php echo $row['id']; ?>" style="float: left;margin-right: 10px;" class="checkboxes checkbox"  onclick="select_row(this);" value="<?php echo $row['id']; ?>"  >
                                        <input type="hidden" id="event_<?php echo $row['id']; ?>" class="checkboxes checkbox" onclick="select_row(this);" value="<?php echo $row['eventId']; ?>"  >
                                        <input type="hidden" id="venue_<?php echo $row['id']; ?>" class="checkboxes checkbox" onclick="select_row(this);" value="<?php echo $row['venueId']; ?>"  >
                                        <input type="hidden" id="price_<?php echo $row['id']; ?>" class="checkboxes checkbox" onclick="select_row(this);" value="<?php echo $row['price']; ?>"  >
                                        <h4><?php echo $row['event_name']; ?></h4>
                                        <div class="Photos">Photos From The First Ascent</div>
                                        <div class="moreBtn"><a href="javascript:void(0);" onclick="viewTicket(<?php echo $row['eventId']; ?>);"  class="fancybox">more...</a> 
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="Everest-div Everest-div-border">
                                    <div class="LocationDiv">
                                        <h4>Location:</h4>
                                        <div class="Woodstock"><?php echo $row['vanu_name']; ?></div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="LocationDiv">
                                        <?php $date= $row['date'];
                                              $timestamp= strtotime($date);
                                              $day = date('l', $timestamp); 
                                               ?>
                                        <h4>On:</h4>
                                        <div class="Woodstock"><?php echo date('d-m-Y',strtotime($date)).",".$day; ?></div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="LocationDiv">
                                        <h4>Price: </h4>
                                        <div class="Woodstock"><img src="<?php echo base_url(); ?>assets/site/images/Pound.png"><?php $price=$row['price'];echo  number_format($price/100,2); ?></img></div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                        </li>
                        <?php
                    }
                    ?>
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
                </ul>
            </div>
        </div>
    </div>
    <!--all-Dates--> 
</div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/site/js/tickets.js"></script>
<!--content-->
<?php
include_once("footer.php");
?>