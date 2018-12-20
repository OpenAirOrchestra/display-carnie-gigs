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
		$year = "";
		$first = 1;

		foreach ($gigs as $gig) {

			if (date('Y', strtotime($gig['date'])) != $year)
			{
				if ($first)
				{
					$output .= "<div class='year'>";
				}
				else
				{
					$output .= "</div>\n";
					$output .= "\n<div class='year collapsed'>\n";
				}
				
				$year = date('Y', strtotime($gig['date']));
				$output .= "<a href='javascript:;' class='expand_button' onclick='toggle_parent_collapsed(event);'>&nbsp;&nbsp;&nbsp;&nbsp;</a> <span class='year'>$year</span><br/>";
			}


	                if ((! $gig['cancelled']) && (! $gig['tentative']))
			{
                        	$output .= "<div class='gig collapsed'>\n";
				$output .= $this->shortGig($gig);
	                        $output .= "\n</div>\n";
			}

			$first = 0;
		}
		$output .= "</div>\n";

		return $output;
	}

	/*
	 * Render a single short gig 
	 */
	function shortGig($gig) {
		$output .= "<a href='javascript:;' class='expand_button' onclick='toggle_parent_collapsed(event);'>&nbsp;&nbsp;&nbsp;&nbsp;</a> <span class='date'>"; 

		if (strtotime($gig['date']) > 0) {
			$output .=  date('j M Y', strtotime($gig['date']));
			$output .= ': ';
		} 

		if ((strncasecmp($gig['url'], 'http://', 7) == 0) ||
		    (strncasecmp($gig['url'], 'https://', 8) == 0))
		{
		    $output .= "<a href=\"{$gig['url']}\">";
		}
		else if (strlen($gig['url']) > 0)
		{
			$output .= "<a href=\"http://{$gig['url']}\">";
		}
		$output .= stripslashes($gig['title']);
		if (strlen($gig['url']) > 0)
		{
			$output .= "</a>";
		}

		$output .= "</span> <div class='details'>";

		if (strlen($gig['location']) > 0)
        	{
        		$output .= "<p class='location'>" .  stripslashes($gig['location']) . "</p>";
        	}
        	if (strlen($gig['description']) > 0)
        	{
        		$output .= "<p class='description'>" . stripslashes($gig['description']) . " </p>";
        	}

		$output .= '</div>';
		return $output;
	}


	/*
	 * Render long view of gigs from database results
	 */
	function longGigs($gigs) {

		$output = '';

		foreach ($gigs as $gig) {
			$output .= $this->longGig($gig);
		}

		return $output;
	}

	/*
	 * Render a single long gig 
	 */
	function longGig($gig) {
		$output = '<h3>';

		if ($gig['cancelled'])
		{
			$output .= "Cancelled: ";
			$output .= date('l, d M Y', strtotime($gig['date']));
			$output .= ": ";

			if ((strncasecmp($gig['url'], 'http://', 7) == 0) ||
			    (strncasecmp($gig['url'], 'https://', 8) == 0))
			{
			    $output .= "<a href=\"{$gig['url']}\">";
			}
			else if (strlen($gig['url']) > 0)
			{
				$output .= "<a href=\"http://{$gig['url']}\">";
			}
			echo stripslashes($gig['title']);
			if (strlen($gig['url']) > 0)
			{
				$output .= "</a>";
			}
			$output .= '<h3>';
		}
		else
		{
			if ($gig['tentative'])
			{
				$output .= "Tentative: ";
			}
			$output .= date('l, d M Y', strtotime($gig['date']));
			$output .= ": ";

			if ((strncasecmp($gig['url'], 'http://', 7) == 0) ||
			    (strncasecmp($gig['url'], 'https://', 8) == 0))
			{
			    $output .= "<a href=\"{$gig['url']}\">";
			}
			else if (strlen($gig['url']) > 0)
			{
			    $output .= "<a href=\"http://{$gig['url']}\">";
			}
			$output .= stripslashes($gig['title']);
			if (strlen($gig['url']) > 0)
			{
				$output .= "</a>";
			}
			$output .= "</h3>\n";

			if (strlen($gig['location']) > 0)
			{
				$output .= "<div class='location'>";
				$output .=  stripslashes($gig['location']); 
				$output .= "</div>\n";
			}
			if (strlen($gig['description']) > 0)
			{
				$output .= "<div class='description'>";
				$output .= stripslashes($gig['description']); 
				$output .= "</div>\n";
			}
			$output .= "<p class='times'>";

			if (strlen($gig['eventstart']) > 0)
			{
				$output .= "Event start: ";
				$output .= date('g:ia', strtotime($gig['eventstart']));
				$output .= ". ";
			}
			if (strlen($gig['performancestart']) > 0)
			{
				$output .= "Performance start: ";
				$output .= date('g:ia', strtotime($gig['performancestart']));
				$output .= ". ";
			}
			$output .= "</p>\n";
		}
		return $output;
	}
}
?>
