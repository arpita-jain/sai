<?php
include_once("header.php");
?>
<div class="col-md-8 pull-left">
    <form action="<?php echo site_url(); ?>kiosk/searchOnCustomers" method="post" name="frm_search">
        <div class="search-L">
            <input  type="text" name="search_text" value="">
            <input type="submit" value="Search" name="search_btn">
        </div>
    </form>
</div>
</div>
<div class="Dates-div">
    <div class="col-md-12">
        <h1 class="date-text"><i class="fa fa-users"></i><span>Customer Orders</span></h1>
    </div>
    <div class="col-md-12">
        <div class="all-Dates">
            <h2>Customer Orders</h2>
            <div class="date-div">
                <div class="dateText Basket">
                    <ul><?php foreach ($order as $row) { ?> 
                            <li class="EverestMain"><i class="fa fa-chevron-circle-right"></i>
                                <div class="Everest-divMain btm30">
                                    <div class="EverestText">
                                        <div class="Customerorder">
                                            <h4>Customer Name:</h4>
                                            <div class="Woodstock"><?php echo $row['firstname'] . "&nbsp;" . $row['lastname']; ?></div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="Customerorder">
                                            <h4>Post Code:<?php echo $row['postcode']; ?></h4>
                                            <br>
                                            <div class="Woodstock">
                                                <ul>
                                                    <?php foreach ($row['tickets'] as $ticket) { ?>
                                                        <li>Ticket Id: <?php echo $ticket['ticket_id']; ?>  </li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div><!--Woodstock-->
                                            <div class="clear"></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <a class="clear-orderBtn" href="<?php echo site_url() . 'kiosk/OrderDetail?id=' . $row['id']; ?>">Show Order</a> 
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clear"></div>
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
<!--content-->
<?php
include_once("footer.php");
?>