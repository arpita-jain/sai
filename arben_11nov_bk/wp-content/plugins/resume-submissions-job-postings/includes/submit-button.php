<div id="rsjp-submit-button">
    <form method="post" name="goToResume" action="<?php echo get_option( 'resume_form_page' ); ?>">
        <input type="hidden" name="fromPosting" value="<?php echo $job; ?>" />
        <input type="submit" name="fromPostingSubmit" value="<?php _e( 'Submit Resume For This Job' ); ?>" />
    </form>
</div>