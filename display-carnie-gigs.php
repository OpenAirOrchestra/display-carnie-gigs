<?php
/**
 * Plugin Name: Display Carnie Gigs
 * Plugin URI: https://github.com/OpenAirOrchestra/display-carnie-gigs
 *  Description: Display Gigs from carnie-gigs plugin on a second, public webstie.
 * Version: 1.1
 * Author: Open Air Orchestra Webmonkey
 * Author URI: mailto://oaowebmonkey@gmail.com
 * License: GPL2
 * GitHub Plugin URI: https://github.com/OpenAirOrchestra/display-carnie-gigs
 **/

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
require_once $include_folder . '/views/gig.php';
require_once $include_folder . '/views/options.php';
require_once $include_folder . '/model/mirror_database.php';

/*
 * Main class for dislay carnie gigs.  Handles activation, hooks, etc.
 */
class displayCarnieGigsCalendar {

	private $carnie_mirror_database, 
		$carnie_gig_view;

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
		register_setting( 'display-carnie-gigs-settings-group', 'display_carniegigs_mirror_database' );
		register_setting( 'display-carnie-gigs-settings-group', 'display_carniegigs_mirror_database_user_name' );
		register_setting( 'display-carnie-gigs-settings-group', 'display_carniegigs_mirror_database_user_password' );
		register_setting( 'display-carnie-gigs-settings-group', 'display_carniegigs_mirror_database_hostname' );
	}

	/*
 	 * render settings page
 	 */
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
		$this->carnie_mirror_database = new displayCarnieMirrorDatabase;
	}

	/*
	 * Handles display-carniegigs shortcode
	 * examples:
	 * [display-carniegigs] 
         * [display-carniegigs time="past"] 
         * [display-carniegigs time="future"] 
         * [display-carniegigs display="short"] 
         * [display-carniegigs display="long"] 
	 */
	function carniegigs_shortcode_handler($atts, $content=NULL, $code="") {
		$output = '';

		// Pull out shortcode
		extract( shortcode_atts( array(
			'time' => 'all',
			'display' => 'short'), $atts ) );

		// Get gigs from database
		if (! $this->carnie_mirror_database) {
			$this->carnie_mirror_database = new displayCarnieMirrorDatabase;
		}
		   
		$gigs = array();
		if ($time == 'past') {
			$gigs = $this->carnie_mirror_database->past_gigs();
		} else if ($time == 'future') {
			$gigs = $this->carnie_mirror_database->future_gigs();
		} else {
			$gigs = $this->carnie_mirror_database->all_gigs();
		}

		// Render results
		if (! $this->carnie_gig_view) {
			$this->carnie_gig_view = new displayCarnieGigView;
		}
		
		if ($display == 'short') {
			$output = $output . $this->carnie_gig_view->shortGigs($gigs);
		} else {
			$output = $output . $this->carnie_gig_view->longGigs($gigs);
		}


		return $output;
	}

	/*
	 * Queue scripts and styles for admin pages
	 */
	function enqueue_admin_scripts() {
		// wp_enqueue_script('suggest');
	}

	/*
	 * Queue scripts and styles for regular pages
	 */
	function enqueue_scripts() {
	    wp_enqueue_style( 'short-gig-style', plugins_url( '/styles/short-gig-style.css', __FILE__ ) );
	    wp_enqueue_script( 'short-gig-util', plugins_url( '/scripts/short-gig-util.js', __FILE__ ) );
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
add_action('wp_enqueue_scripts', array($DISPLAYCARNIEGIGSCAL, 'enqueue_scripts'));



?>
