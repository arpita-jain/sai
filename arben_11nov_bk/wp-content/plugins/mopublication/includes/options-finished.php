<div class="inner">

    <div class="alldone">
        <h2 style="margin-bottom: 5px;">I'm done! What happens next?</h2>

        <p>If you are 100% happy with how your app looks, go ahead and hit the submit button.</p>
        <ol>
            <li>You'll be taken to a subscription form where we'll capture your details</li>
            <li>Then you'll be asked to select a pricing plan before being directed to a secure payment area</li>
            <li>After your order has been finalized, we'll build your app and send you an email once it's live in the App Store</li>
        </ol>
        <p>
             Your app should be live on the App Store within 7-10 working days after submission. That's it!
        </p>

        <p>

             Still have questions? Take a look at our comprehensive <a href="http://support.mopublication.com" title="MoPublication FAQs" target="_blank">FAQ section</a> 
             or <a href="http://www.mopublication.com/contact/" title="Contact MoPublication" target="_blank">Contact us</a>.
       </p>

       <p>
            <input type="checkbox" name="agree_terms" id="agree_terms" />
            <label for="agree_terms">&nbsp;I agree to the MoPublication <a href="http://www.mopublication.com/terms/" target="_blank">Terms of Service</a>.</label>
      </p>

      <form id="submitApp" method="post" action="http://www.mopublication.com/members/signup/index/c/">
            <input type="hidden" id="wordpress_url" name="wordpress_url" value="<?php echo get_site_url(); ?>"/>
            <textarea name="config_file" id="config_file" style="display: none"><?php echo get_option('frm_config_file'); ?></textarea>
            <a href="#tab-app-store" class="button tabnav">Back</a>
            <input type="button" class="button-primary" value="Submit my awesome app!" id="mopub_submit"/>
      </form>
    </div>

</div>
