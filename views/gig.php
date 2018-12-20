<?php

/*
 * Renders carnie gig 
 */
class displayCarnieGigView {



	/*
	 * Render short view of gigs from database results
	 */
	function shortGigs($gigs) {

		$output = '';

		foreach ($gigs as $gig) {
			$output = $output . $this->shortGig($gig) . '<br/>';
		}

		return $output;
	}

	/*
	 * Render a single short gig 
	 */
	function shortGig($gig) {
		return "Short Gig ";
	}


	/*
	 * Render long view of gigs from database results
	 */
	function longGigs($gigs) {

		$output = '';

		foreach ($gigs as $gig) {
			$output = $output . $this->longGig($gig) . '<br/>';
		}

		return $output;
	}

	/*
	 * Render a single long gig 
	 */
	function longGig($gig) {
		return "Long Gig ";
	}
}
?>
