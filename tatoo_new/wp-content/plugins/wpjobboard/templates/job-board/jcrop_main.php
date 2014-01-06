<script src="<?php echo site_url().'/wp-content/plugins/wpjobboard/css/jquery.min.js';?>"></script>
<script src="<?php echo site_url().'/wp-content/plugins/wpjobboard/css/jquery.ui.widget.js';?>"></script>
<script src="<?php echo site_url().'/wp-content/plugins/wpjobboard/css/jquery.ui.accordion.js';?>"></script>
<script src="<?php echo site_url().'/wp-content/plugins/wpjobboard/css/jquery.Jcrop.min.js';?>"></script>

<script src="<?php echo site_url().'/wp-content/plugins/wpjobboard/css/jcrop_main.js';?>"></script>

<link rel="stylesheet" href="<?php echo site_url().'/wp-content/plugins/wpjobboard/css/jquery.ui.theme.css';?>" type="text/css" />
<link rel="stylesheet" href="<?php echo site_url().'/wp-content/plugins/wpjobboard/css/jquery.ui.accordion.css';?>" type="text/css" />
<link rel="stylesheet" href="<?php echo site_url().'/wp-content/plugins/wpjobboard/css/jquery.Jcrop.css';?>" type="text/css" />
<link rel="stylesheet" href="<?php echo site_url().'/wp-content/plugins/wpjobboard/css/jcrop_main.css';?>" type="text/css" />

<div class="jcrop_example">

  <!--  <div id="accordion" class="accordion">
        <h3><a href="#">Jcrop - Crop Behavior</a></h3>
        <div class="sample_1">-->

           <!-- <div style="margin-bottom:10px;">
                <h4>Preview pane:</h4>
                <div style="overflow: hidden; width: 200px; height: 200px;">
                    <img id="preview" src="files/image.jpg"/>
                </div>
            </div>-->

            <img src="files/image.jpg" id="cropbox1" />

            <form action="index.php" method="post" onsubmit="return checkCoords();">
                <div style="margin:5px;">
                     <input type="hidden" name="x" id="x" size="4"/></label>
                   <input type="hidden" name="y" id="y" size="4"/></label>
                    <input type="hidden" name="x2" id="x2" size="4"/></label>
                    <input type="hidden" name="y2" id="y2" size="4"/></label>
                   <input type="hidden" name="w" id="w" size="4"/></label>
                    <input type="hidden" name="h" id="h" size="4"/></label>
                </div>

                <div style="margin:5px;">
                    <input type="submit" value="Crop Image" />
                </div>
            </form>

          <!--  <p>
                <b>An example of crop script.</b> I decided to show form with values (you can keep it invisible if you want).
                Current sample ties several form values together with a event handler.
                Form values are updated as the selection is changed.
                Also current sample have preview area. So we will see our crop result.
                Aspect ratio disabled.
                If you press the <i>Crop Image</i> button, the form will be submitted and a 200x200 thumbnail will be dumped to the browser. Try it!
            </p>
        </div>

        <h3><a href="#">Jcrop - Animations</a></h3>
        <div class="sample_2">
            <img src="files/image.jpg" id="cropbox2" />

            <div style="margin: 20px 0;">
                <button id="anim1">Position 1</button>
                <button id="anim2">Position 2</button>
                <button id="anim3">Position 3</button>
                <button id="anim4">Position 4</button>
                <button id="anim5">Position 5</button>
            </div>

            <p>
                <b>Animating Selections.</b> We can use Jcrop API to set selections using animation (or immediately) to them. Here are several buttons are set to control the selection. User interactivity is still available. Try it!
            </p>
        </div>-->

        <!--<h3><a href="#">Jcrop - Custom styling</a></h3>-->
        <!--<div class="sample_3">
            <img src="files/image.jpg" id="cropbox3" />

            <p>
                <b>So maybe you like the color blue.</b>
                This demo shows how we can styling our Jcrop sample. This is easy - we will use addClass param to override styles. Also possible to set opacity using bgOpacity param (at current sample bgOpacity = 0.5). Also I used minSize param to determinate min size of selector (value = 50).
            </p>
        </div>-->
    </div>

</div>
