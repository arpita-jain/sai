<?php
/*
Template Name: Password Recovery
*/
?>

<?php get_header(); ?>

	<div id="content">
	<div class="page-title"><?php the_title(); ?></div>

	<?php if ( is_user_logged_in() ) : ?>

		<center><h3>You are logged in! Redirecting to <a href="<?php echo bp_loggedin_user_domain() ?>">your profile</a>.</h3></center><br /><br /><br />

		<script type="text/javascript">
		<!--
		window.location = "<?php echo bp_loggedin_user_domain() ?>"
		//-->
		</script>

	<?php else : ?>
<br /><br /><br />

			<form method="post" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" id="page-login-form" class="standard-form">
			<p>Please enter your username or email address. You will receive a link to create a new password via email.</p>
			<div class="username">
				<label for="user_login"><?php _e('Username or Email', 'buddypress' ); ?>: </label>
				<input type="text" name="user_login" class="input" value="" size="20" id="page-user-pass" tabindex="1001" />
			</div>
			<div class="login_fields">
				<?php do_action('login_form', 'resetpass'); ?>
				<input type="submit" name="user-submit" value="<?php _e('Reset my password', 'buddypress' ); ?>" id="wp-submit" tabindex="1002" />
				<?php $reset = $_GET['reset']; if($reset == true) { echo '<br /><br /><br /><br /><br /><p style="font-size:18px; color:#d70a00;">' . of_get_option('t-14', 'A message will be sent to your email address.' ) . '</p>'; } ?>
				<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?reset=true" />
				<input type="hidden" name="user-cookie" value="1" />
			</div>
			</form>
<br /><br /><br /><br /><br /><br /><br />
	<?php endif; ?>




	</div><!-- #content -->

<div class="clear"></div>

<?php get_footer(); ?>
