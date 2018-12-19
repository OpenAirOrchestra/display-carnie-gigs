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
        <th scope="row">Mirror Table</th>
        <td><input type="text" name="carniegigs_mirror_table" value="<?php echo get_option('carniegigs_mirror_table'); ?>" /></td>
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
