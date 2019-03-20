<?php
/**
 * Plugin Name: Add ID to Links
 * Plugin URI: https://www.gravilum.com/wordpress-plugins/add-id-to-links
 * Description: Adds a unique ID to all links in order to allow Google Analytics
 *              enhanced link attribution to work. Adds an ID to every link that 
 *              doesn't already have one within every post and page content. Does
 *              not add IDs to links in the header, footer, sidebars, or other
 *              areas outside the post or page content.
 * Version: 1.1
 * Author: Nate Phillips
 * Author URI: https://www.gravilum.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * {Plugin Name} is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * {Plugin Name} is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with {Plugin Name}. If not, see {License URI}.
 */

 /* This line for security...prevents standalone execution of this file */
 defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

 add_filter( 'the_content', 'gravilum_add_id_to_links');

 function gravilum_add_id_to_links( $content ) {

  /* Find all links (i.e., <a ...>....</a>) and add an ID if one doesn't 
     already exist */   
  $content = preg_replace_callback( 
      '/(\<a(.*?))\>(.*)(<\/a>)/i', 
      function( $matches ) {
        static $link_counter = 100;  
        if ( !stripos( $matches[1], ' id=' ) ) {
          $matches[0] = $matches[1] . $matches[2] . ' id="gravilum-ga-link-' . 
                        $link_counter++ . '">' . $matches[3] . $matches[4];                
        }
		    return $matches[0];
      }, 
      $content );
  
   return $content;
 }