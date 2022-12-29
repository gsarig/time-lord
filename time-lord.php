<?php
/*
	Plugin Name: Time Lord
	Plugin URI: http://wordpress.org/plugins/time-lord/
	Description: Make modifications on your content based on time parameters. Show or hide part of a post at a given point in the future, calculate age and more. 
	Version: 1.2
	Author: Giorgos Sarigiannidis
	Author URI: http://www.gsarigiannidis.gr
*/

	load_plugin_textdomain('timelord', false, basename( dirname( __FILE__ ) ) . '/languages' ); // Localize it

	/*
		The [timelord] shortcode.
	*/
	function timelord_shortcode( $atts, $content = null ) {

		date_default_timezone_set(get_option('timezone_string'));

		$a = shortcode_atts( array(
			'mode' 			=> 'show', 	// [timelord mode="hide"]
			'from' 			=> false, 	// [timelord from="YYYY-MM-DD hh:mm:ss"]
			'to' 			=> false,	// [timelord to="YYYY-MM-DD hh:mm:ss"]
			'message'		=> false,	// [timelord message="SOME MESSAGE"]
			'from_msg'		=> false, 	// [timelord from_msg="SOME MESSAGE"]
			'to_msg'		=> false, 	// [timelord to_msg="SOME MESSAGE"]
			'every' 		=> false, 	// [timelord every="1 day"]
			'del' 			=> false, 	// [timelord del="yes"]
			'year' 			=> false,	// [timelord year="YYYY"]
			'ordinal' 		=> false, 	// [timelord ordinal="yes"]
		), $atts );

		$now = time();

		if( !empty($a['year']) ) { // [timelord year="YEAR" ordinal="yes"]

			$year_set 		= filter_var( $a['year'], FILTER_SANITIZE_NUMBER_INT );
			$year_current 	= date('Y');
			$set_age 		= abs( $year_current - $year_set );
			$age 			= ( $a['ordinal'] === 'yes' ) ? ordinal($set_age) : $set_age;

			return $age;

		} else if ( !empty($a['every']) ) { // [timelord from="DATE" to="DATE" every="INTERVAL"]

			/* 
				Test for recurring events (requires PHP 5.3 or newer)
				http://php.net/manual/en/class.dateperiod.php
			*/
			$days 		= array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
			$every 		= $a['every'];
			$set_begin 	= !empty($a['from']) ? $a['from'] : get_the_modified_date('Y-m-d H:i'); // If "from" date is set, get it. Else, get the date for the post's last modification
			$no_end 	= $now + (60*60*60);
			$set_end 	= !empty($a['to']) ? $a['to'] : date('d M Y H:i:s', $no_end); // If "to" date is set, get it. Else, set it as a really distant date in the future
			$begin 		= new DateTime( $set_begin );
			$end 		= new DateTime( $set_end );
			$interval 	= !in_array( $every, $days ) ? DateInterval::createFromDateString($every) : new DateInterval('P1D');
			$period 	= new DatePeriod($begin, $interval, $end, DatePeriod::EXCLUDE_START_DATE);
			$i 			= 0;

			foreach ( $period as $dt ) :
				$count_interval 	= strtotime($every) - $now;
				$count_iteration 	= strtotime($dt->format( "l Y-m-d H:i:s"));
				$count_difference 	= $count_iteration - $now;
				
				if( in_array( $every, $days ) ) { // If iteration every specific date is set (e.g. [timelord from="DATE" to="DATE" every="Monday"])

					$get_content = ( date('l', $now) === $every ) ? $content : '';

				} elseif( ($i++ % 2 == 0) && ($count_difference < $count_interval) && ($count_difference > 0)  ) { // If period is even (not odd), it has began but its not over yet

					$get_content = $content;
				
				} else {

					$get_content = '';

				}

				return do_shortcode($get_content);

			endforeach;

		} else { // [timelord mode="hide" from="DATE" to="DATE" message="MESSAGE" from_msg="MESSAGE" to_msg="MESSAGE"]

			$set_from 		= strtotime($a['from']);
			$set_to 		= strtotime($a['to']);
			$from 			= !empty($set_from) ? $set_from : ($now-1);
			$to 			= !empty($set_to) ? $set_to : ($now+1);
			$empty_msg	 	= $a['del'] === 'yes' ? '<del>' . do_shortcode($content) . '</del>' : '';
			$message 		= !empty($a['message']) ? $a['message'] : $empty_msg;
			$condition 		= $a['mode'] === 'hide' ? ($now < $from || $now > $to) : ($now > $from && $now < $to);
			$from_msg 		= !empty($a['from_msg']) ? human_time_diff( $set_from ) : '';
			$to_msg			= !empty($a['to_msg']) ? human_time_diff( $set_to ) : '';
			$get_deadline 	= $now < $from ? $a['from_msg'] . $from_msg :  $a['to_msg'] . $to_msg;
			$get_class		= $now < $from ? 'message-from' : 'message-to'; 
			$deadline 		= '<span class="timelord-' . $get_class . '">' . $get_deadline . '</span>';
			$get_content 	= $condition ? do_shortcode($content) : $message;

			return $get_content . $deadline;

		}

	} // timelord_shortcode();
	add_shortcode( 'timelord', 'timelord_shortcode' );

		/* 
			Function ordinal($number) to get the ordinal suffix.
		*/
		function ordinal( $number ) {
			$ends = array( 
				__( 'th', 'timelord' ),
				__( 'st', 'timelord' ),
				__( 'nd', 'timelord' ),
				__( 'rd', 'timelord' ),
				__( 'th', 'timelord' ),
				__( 'th', 'timelord' ),
				__( 'th', 'timelord' ),
				__( 'th', 'timelord' ),
				__( 'th', 'timelord' ),
				__( 'th', 'timelord' ) 
			);
			$ordinal = (($number % 100) >= 11) && (($number % 100) <= 13) ? $number. 'th' : $number. $ends[$number % 10];

			return $ordinal;
		}
