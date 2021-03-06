<?php

/*
 * Renders options page for display carnie gigs plugin... admin UI
 */
class displayCarnieGigsOptionsView {

	/*
	 * Render options page
	 */
	function render() { 
?>
<div class="wrap">
<h2>Display Carnie Gigs Plugin Settings</h2>

<form method="post" action="options.php">

    <h3>Mirror Database</h3>

	<p>
	The flat table that the Carnie Gigs plugin has mirrored it's gig data to.
	</p>

    <?php settings_fields( 'display-carnie-gigs-settings-group' ); ?>
    <table class="form-table">
	            <tr valign="top">
					             
        <tr valign="top">
        <th scope="row">Mirror Database</th>
        <td><input type="text" name="display_carniegigs_mirror_database" value="<?php echo get_option('display_carniegigs_mirror_database'); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Mirror Database User Name</th>
        <td><input type="text" name="display_carniegigs_mirror_database_user_name" value="<?php echo get_option('display_carniegigs_mirror_database_user_name'); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Mirror Database User Password</th>
        <td><input type="text" name="display_carniegigs_mirror_database_user_password" value="<?php echo get_option('display_carniegigs_mirror_database_user_password'); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Mirror Database Hostname</th>
        <td><input type="text" name="display_carniegigs_mirror_database_hostname" value="<?php echo get_option('display_carniegigs_mirror_database_hostname'); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Mirror Table</th>
        <td><input type="text" name="display_carniegigs_mirror_table" value="<?php echo get_option('display_carniegigs_mirror_table'); ?>" /></td>
        </tr>
        
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php
	}
}
?>
