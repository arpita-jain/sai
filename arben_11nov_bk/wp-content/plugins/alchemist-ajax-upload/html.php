<script type="text/javascript">window.aaiuUploadCount = 0;</script>
<style>
    #aaiu-ul-list,
    #aaiu-ul-list li {
        margin: 2px;
        padding: 2px;
    }

    #aaiu-ul-list li {
        display: inline-block;
        background: #FFFFFF;
    }

   

    .aaiu_button {
        border: 1px solid #CCCCCC;
        border-radius: 5px 5px 5px 5px;
        color: #333333;
        font-weight: bold;
        margin: 5px 0 15px;
        padding: 3px 8px;
        text-decoration: none;
    }

</style>
<div id="aaiu-upload-container" style="position: inherit !important">
 <input type="radio" name="img_category" value="before" id="img_category2" class="checkedradio"/>Before
    <input type="radio" name="img_category" value="after" id="img_category1" class="checkedradio"/>After
   <div class="clear"></div>
    <div class="job-upload-field">
			       <div class="job-upload-bg"><span>                        
                                       <input type="text" placeholder="upload your recent work image" id="work_imagename" readonly="true" name="work_imagename">
					   </span> </div>
				 </div><div class="post-job-upload" id="work_upload_btn">
				<!-- Button to invoke the click of the File Input -->
                                <input type="button" id="aaiu-uploader" class="uploadbtn" disabled="disabled" value="<?php if (get_template() =='constructionmatesss_mob') {  echo 'Upload Images';}?>" />
				<div id="upl_upload" style="color: red;"></div>
				<input type="hidden" id="ajax_url" name="ajax_url" value="<?php echo site_url().'/wp-content/plugins/alchemist-ajax-upload/ajax.php'; ?>" />
				<input type="hidden" id="after_cat" value="" />
				<input type="hidden" id="before_cat" value="" />
				
    </div>

    <div id="aaiu-upload-imagelist">
        <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
    </div>

</div>
