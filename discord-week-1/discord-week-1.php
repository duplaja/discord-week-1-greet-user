<?php
/*
Plugin Name: Week 1: Greet a User
Plugin URI: https://dandulaney.com
Description: Greets a user by popping up a modal addressing them by username, and welcoming them to the blog when they first log in.
Version: 1.0
Author: Dan Dulaney
Author URI: https://dandulaney.com
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

    Copyright 2019 by Dan Dulaney <dan.dulaney07@gmail.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'discord_week_one_enqueue_styles' ) ) {
	/**
	 * Enqueues main plugin style.
	 *
	 * @param
	 * @return
	 */

	add_action( 'wp_enqueue_scripts', 'discord_week_one_enqueue_styles' );
	function discord_week_one_enqueue_styles() {
		wp_enqueue_style( 'discord-week-1-main-style', 	plugins_url( 'css/main.css', __FILE__ ), array(), '1.2' ); 
		
	}
}

	
if ( ! function_exists( 'discord_week_one_login_redirect' ) ) {
	/**
	 * Login redirect with query string on user login.
	 *
	 * @param $redirect_to (WordPress redirect link)
	 * @return $redirect_to (WordPress redirect link)
	 */
	add_action( 'login_redirect', 'discord_week_one_login_redirect', 10, 3 );
	function discord_week_one_login_redirect($redirect_to) {
 
		$redirect_to =  home_url('/?welcome=yes'); //Website home url with a query variable
	
		return $redirect_to;		
	}
}

if (! function_exists( 'discord_week_one_modal_js')) {
	/**
	 * Adds JS code to show the modal to the footer, if the query parameter is set.
	 * 
	 * Note: Normally, this JavaScript would be an enqueued JS file, with jQuery set as a dependency.
	 * For the sake of those initially learning, I've avoided using enqueue_script for this one.
	 * For those interested, the process is very similar to enqueing the CSS file above.
	 *
	 * @param $redirect_to (WordPress redirect link)
	 * @return $redirect_to (WordPress redirect link)
	 */

	add_action('wp_footer','discord_week_one_modal_js');
	function discord_week_one_modal_js() {

		$current_user = wp_get_current_user(); //Gets User object for logged in user
		
		if ($current_user->exists() && $_GET['welcome'] == 'yes') { //Runs the following code only if the user exists (is logged in)
		  
			$username = $current_user->user_nicename;
			$sitetitle = get_bloginfo('name');
					
			//HTML for Modal
			$html_to_add = "
			<div id='myModal' class='modal'>
				<div class='modal-content'>
				<span class='close'>&times;</span>
				<p>Welcome {$username} to {$sitetitle}</p>
				</div>
			</div>";

			//Script to handle closing modal when clicked off
			$html_to_add .= "
			<script>
			var modal = document.getElementById('myModal');
			var span = document.getElementsByClassName('close')[0];

			span.onclick = function() {
				modal.style.display = 'none';
			}
			
			window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = 'none';
				}
			}
			</script>";

			echo $html_to_add;
		}
	}
}