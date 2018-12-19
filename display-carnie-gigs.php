<?php
/*
Plugin Name: Display Carnie Gigs
Plugin URI: https://github.com/OpenAirOrchestra/display-carnie-gigs
Description: A gig calendar plugin for The Carnival Band 
Version: 0.1
Author: Open Air Orchestra Webmonkey
Author URI: mailto://oaowebmonkey@gmail.com
License: GPL2
*/

/*  Copyright 2018  Open Air Orchestra  (email : oaowebmonkey@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USAi
*/

$include_folder = dirname(__FILE__);
require_once $include_folder . '/views/options.php';


/*
 * Main class for dislay carnie gigs.  Handles activation, hooks, etc.
 */
class displayCarnieGigsCalendar {

	private $carnie_mirror_database;

	/*
	 * Constructor
	 */
	function __construct() {
	}
	   
	/*
	 * Activate the plugin.  
  	 * Create any database tables.
	 * Migrate any data from previous versions.
	 */
	function activate () {
		$version = get_option("display_carniegigs_db_version");

		
		/*
		if ($version) {
			if ($version < CARNIE_GIGS_DB_VERSION) {
				update_option("display_carniegigs_db_version", CARNIE_GIGS_DB_VERSION);
			}
		} else {
			// First install/activate

			// Add database version option
			add_option("display_carniegigs_db_version", CARNIE_GIGS_DB_VERSION);
		}
		*/

	}

	/*
	 * Create admin menu(s) for this plugin.  
	 * The admin menu gets us to managing options.
	 *
	 * http://codex.wordpress.org/Creating_Options_Pages
	 */
	function create_admin_menu() {
		
		// Add options page
		add_options_page('Display Carnie Gigs Plugin Settings', 'Display Carnie Gigs Settings', 'manage_options', 'display-carnie-gigs-options', array($this, 'options_page'));

		//call register settings function
		add_action( 'admin_init', array($this, 'register_settings'));
	}

	/*
	 * Register settings for this plugin
	 */
	function register_settings() {
		register_setting( 'display-carnie-gigs-settings-group', 'display_carniegigs_mirror_table' );
	}

	function options_page() {
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		} 

		$carnie_gigs_options_view = new displayCarnieGigsOptionsView;
		$carnie_gigs_options_view->render();
	}

	/*
	 * Called whenver one of the options related to the mirror
	 * database is changed
	 */
	function mirror_database_changed() {
		if (! $this->carnie_mirror_database) {
			$this->carnie_mirror_database = new carnieMirrorDatabase;
		}
		$this->carnie_mirror_database->rebuild($this->metadata_fields, 
			$this->metadata_prefix);
	}

	/*
	 * Handles display-carniegigs shortcode
	 * examples:
	 * [display-carniegigs] 
         * [display-carniegigs time="past"] 
         * [display-carniegigs time="future"] 
         * [display-carniegigs display="short"] 
	 */
	function carniegigs_shortcode_handler($atts, $content=NULL, $code="") {
		extract( shortcode_atts( array(
			'time' => 'all',
			'display' => 'short'), $atts ) );

?>
		DFDF Short Code
<?php
		/*
		if (! $this->carnie_mirror_database) {
			$this->carnie_mirror_database = new carnieMirrorDatabase;
		}
		   
		$check_post_status = false;
		$gigs = array();
		if ($time == 'past') {
			$gigs = $this->carnie_mirror_database->past_gigs();
		} else if ($time == 'future') {
			$gigs = $this->carnie_mirror_database->future_gigs();
			$check_post_status = true;
		} else {
			$gigs = $this->carnie_mirror_database->all_gigs();
		}

		if (! $this->carnie_gig_view) {
			$this->carnie_gig_view = new carnieGigView;
		}
		
		$this->carnie_gig_view->shortGigs($gigs, $check_post_status);
		*/
	}

	/*
	 * Queue scripts for admin pages
	 */
	function enqueue_admin_scripts() {
		wp_enqueue_script('suggest');
	}

}


$DISPLAYCARNIEGIGSCAL = new displayCarnieGigsCalendar;

// activation hook
register_activation_hook(__FILE__, array($DISPLAYCARNIEGIGSCAL, 'activate') );

// shortcodes
add_shortcode('display-carniegigs', array($DISPLAYCARNIEGIGSCAL, 'carniegigs_shortcode_handler'));

// actions
add_action('admin_init', array($DISPLAYCARNIEGIGSCAL, 'enqueue_admin_scripts'));
add_action('admin_menu', array($DISPLAYCARNIEGIGSCAL, 'create_admin_menu'));
add_action('update_option_carniegigs_mirror_table', array($DISPLAYCARNIEGIGSCAL, 'mirror_database_changed'));


?>
