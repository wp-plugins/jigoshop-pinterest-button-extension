<?php

/*
Plugin Name: Jigoshop Pinterest Pin-it Button
Plugin URI: http://61extensions.com
Description: Add a Pinterest Pin-it button to your products pages
Version: 1.0
Author: 61 Extensions
Author URI: http://61extensions.com
*/

/*  Copyright 2012 61 Extensions (email: support at sixtyonedesigns.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


/*
 * SOD_Jigoshop_Pinterest_Button
 */
if ( ! class_exists( 'SOD_Jigoshop_Pinterest_Button' ) ) {
	class SOD_Jigoshop_Pinterest_Button{
		var $lang = 'sod_pinterest_tab';
		var $id = 'sod_pinterest';
		function __construct(){
			add_action( 'wp_enqueue_scripts', array( &$this, 'sod_pinterest_scripts' ) );
			add_action('jigoshop_product_write_panels', array(&$this, 'write_panel'));
			add_action('jigoshop_product_write_panel_tabs', array(&$this,'pinterest_tab'));
			add_action('jigoshop_process_product_meta', array(&$this, 'write_panel_save'));
			add_action('jigoshop_template_single_summary', array(&$this, 'display_pinterest_button' ), 1 );
		}
		function display_pinterest_button(){
			global $post;
			$enabled = get_post_meta( $post->ID, 'sod_pinterest', true );
			if( $enabled ):
				?>
				<div class="pinterest-btn">
					<a href="javascript:exec_pinmarklet();" class="pin-it-btn" title="Pin It on Pinterest"></a>
				</div>
				<?php
			endif;
		}
		function sod_pinterest_scripts(){
			global $post;
			$enabled = get_post_meta( $post->ID, 'sod_pinterest', true );
			if( $enabled ):
				wp_enqueue_script( 'sod-pinterest-script', plugin_dir_url( __FILE__ ) . 'assets/sod_pinterest.js' );
				wp_register_style( 'sod-pinterest-style', plugin_dir_url( __FILE__ ) . 'assets/sod-pinterest.css' );
				wp_enqueue_style( 'sod-pinterest-style' );
			endif;
		}
		function write_panel(){
			global $post;
			$enabled = get_post_meta( $post->ID, 'sod_pinterest', true );
			if( !isset( $enabled ) ):
				$enabled = true; 
			else:
				$enabled = false;
			endif;
			$chkID = 'sod_pinterest';
			$label = '';
			$value = $enabled;
			$desc = 'Enable a Pinterest Pin-it Button on this product?';
			?>
			<div id="pinterest" class="panel jigoshop_options_panel" style="display: none; ">
				<fieldset>
					<p class="form-field">
						<?php echo jigoshop_form::checkbox( $chkID, $label, $value, $desc ); ?>
						<br />
						<span class="alignright" style="font-size:80%;">Pinterest Extension by 61 Extensions - <a target="_blank" href="http://61extensions.com/product-category/jigoshop-extensions/">View More</a></span>
					</p>
				</fieldset>
			</div>
			<?php
		}
		function pinterest_tab(){
			?>
			<li class="sod_pinterest_tab">	
				<a href="#pinterest"><?php _e( 'Pinterest', $this->lang );?></a>
			</li>
			<?php
		}
		
		function write_panel_save( $post_id ){
			$sod_pinit_option = $_POST['sod_pinterest'];
	    	update_post_meta( $post_id, 'sod_pinterest', $sod_pinit_option );
		}
	}
}
$SOD_Jigoshop_Pinterest_Button = &new SOD_Jigoshop_Pinterest_Button();
?>