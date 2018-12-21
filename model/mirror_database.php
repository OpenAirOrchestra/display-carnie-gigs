<?php

class displayCarnieMirrorDatabase {

	private $table,
		$verified_attendees_database,
		$wpdb;

	/*
	 * Constructor
	 */
	function __construct() {
	}

	/*
	 * Get basic options into member variables
	 */
	function get_options() {

		$username = get_option('display_carniegigs_mirror_database_user_name');
		$password = get_option('display_carniegigs_mirror_database_user_password');
		$database = get_option('display_carniegigs_mirror_database');
		$hostname = get_option('display_carniegigs_mirror_database_hostname');


		$this->wpdb = new wpdb($username, $password, $database, $hostname);
		$this->table = get_option('display_carniegigs_mirror_table');
	}

	function mirror_specified() {
		if (! $this->table ) {
			$this->get_options();
		}
		return $this->table && strlen($this->table);
	}


	/*
	 * Return past gigs in the mirror database
	 */
	function past_gigs () {
		$results = array();

		// SELECT DATE(DATE_SUB(NOW(), INTERVAL 2 HOUR));
		//
		if ($this->mirror_specified()) {
			// convert GMT to PST
			// SELECT DATE(DATE_SUB(NOW(), INTERVAL 2 HOUR));
			$select = "SELECT * FROM " . $this->table .
			   ' WHERE `date` < DATE(DATE_SUB(NOW(), INTERVAL 2 HOUR)) ORDER BY `date` DESC';
			$results = $this->wpdb->get_results( $select, ARRAY_A );
		}

		return $results;
	}

	/*
	 * Return future gigs in the mirror database
	 */
	function future_gigs () {
		$results = array();

		// convert GMT to PST
		// DATE(DATE_SUB(NOW(), INTERVAL 2 HOUR))

		if ($this->mirror_specified()) {
			$select = "SELECT * FROM " . $this->table .
				   ' WHERE `date` >= DATE(DATE_SUB(NOW(), INTERVAL 2 HOUR)) ORDER BY `date`';

			$results = $this->wpdb->get_results( $select, ARRAY_A );
		}

		return $results;
	}

	/*
	 * Return all gigs in the mirror database
	 */
	function all_gigs () {
		$results = array();

		if ($this->mirror_specified()) {
			$select = "SELECT * FROM " . $this->table .
			   " ORDER BY `date` DESC";
			$results = $this->wpdb->get_results( $select, ARRAY_A );
		}

		return $results;
	}

	/*
	 * Return one gig in the mirror database
	 */
	function one_gig () {
		$results = array();

		if ($this->mirror_specified()) {
			$select = "SELECT * FROM " . $this->table .
			   " LIMIT 1";
			$results = $this->wpdb->get_results( $select, ARRAY_A );
		}

		return $results;
	}
}

?>
