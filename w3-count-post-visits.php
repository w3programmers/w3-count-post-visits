<?php
/*
Plugin Name: W3 Count Post Visits
Plugin URI:https://github.com/w3programmers/w3-count-post-visits
Description: W3 Count Number of Visits In a Post
Version: 1.0
Author: Masud Alam
Author URI:http://www.w3programmers.com/
License: GPLv2 or later
Text Domain: w3-count-post-visits
Domain Path: /languages/
*/

function w3_get_mac(){
    // Turn on output buffering  
ob_start();  

//Get the ipconfig details using system commond  
system('ipconfig /all');  

// Capture the output into a variable  
$mycomsys=ob_get_contents();  

// Clean (erase) the output buffer  
ob_clean();  

$find_mac = "Physical"; 
//find the "Physical" & Find the position of Physical text  

$pmac = strpos($mycomsys, $find_mac);  
// Get Physical Address  

$macaddress=substr($mycomsys,($pmac+36),17);  
//Display Mac Address  
return $macaddress;
}


add_filter( 'the_content', 'w3_add_mac_address' );
function w3_add_mac_address( $content ) {
$views=1;
 $queried_object = get_queried_object();
 if($queried_object){
  if (get_post_meta($queried_object->ID, w3_get_mac(),true)) {
    $views=get_post_meta($queried_object->ID, w3_get_mac(),true)+1;
   update_post_meta( $queried_object->ID, w3_get_mac(),$views);
    $reading_times="You have already visit this Post ".get_post_meta($queried_object->ID, w3_get_mac(),true)." Times<br>";
    return $reading_times.$content;
  }
  else{
    add_post_meta( $queried_object->ID, w3_get_mac(),$views);
    $reading_times="You are reading this post for the first time<br>"
    return $reading_times.content;
  }
}
}


