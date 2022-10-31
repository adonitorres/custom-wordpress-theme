<?php
/*
Plugin Name: AT Portfolio CPT
Description: Sets up the admin side of our portfolio pieces ( 'Work' )
Author: Adoni Torres
Version: 0.1
License: GPLv3
*/
add_action( 'init', 'at_portfolio_cpt_register' );
function at_portfolio_cpt_register(){
  register_post_type( 'work', array(
    'public' => true,
    'show_in_rest' => true,
    'has_archive' => true,
    'menu_position' => 5, //changes the position of the menu item in the WP dashboard
    'menu_icon' => 'dashicons-portfolio', //pass an URL for a custom icon
    'rewrite' => array( 'slug' => 'portfolio' ),
    'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ),
    'labels' => array(
      'name' => 'Portfolio',
      'singular_name' => 'Portfolio Piece',
      'not_found' => 'No portfolio pieces found',
      'add_new_item' => 'Add New Portfolio Piece',
    ),
  ));
  
  // Add categories to our portfolio
  register_taxonomy( 'work_category', 'work', array(
    'show_in_rest' => true, //shows in block editor
    'hierarchical' => true, //makes this a category
    'show_admin_column' => true, //shows the category in the admin panel
    'sort' => 'true', //preserve the order of the terms
    'rewrite' => array( 'slug' => 'portfolio-category' ),
    'labels' => array(
      'name' => 'Portfolio Categories',
      'singular_name' => 'Portfolio Category',
      'menu_name' => 'Categories',
      'not_found' => 'No Categories Found',
      'add_new_item' => 'Add New Category',
    ),
  ) );
}

/**
 * Add necessary block patterns
 */
add_action( 'init', 'at_portfolio_block_patterns' );
function at_portfolio_block_patterns(){
  register_block_pattern( 'at-portfolio-cpt/case-study-objective', 
  array(
    'title' => 'Portfolio Case Study Objectives',
    'description' => 'Two columns, objectives next to your role and responsibilities',
    'categories' => array( 'featured' ),
    'content' => 
      '<!-- wp:group {"tagName":"section","className":"portfolio-information"} -->
      <section class="wp-block-group portfolio-information"><!-- wp:group {"className":"links"} -->
      <div class="wp-block-group links"><!-- wp:heading {"level":3} -->
      <h3><a href="javascript:;">Live Site Link</a></h3>
      <!-- /wp:heading -->
      
      <!-- wp:heading {"level":3} -->
      <h3><a href="javascript:;">GitHub Repo Link</a></h3>
      <!-- /wp:heading --></div>
      <!-- /wp:group -->
      
      <!-- wp:genesis-custom-blocks/portfolio-description {"project-description":"Test Description","design-process":"Test design process","coding":"Test coding","testing":"Test testing","overall":"Test overall"} /-->
      
      <!-- wp:gallery {"ids":[],"shortCodeTransforms":[],"linkTo":"media","className":"portfolio-screenshots"} -->
      <figure class="wp-block-gallery has-nested-images columns-default is-cropped portfolio-screenshots"><!-- wp:image {"id":1712,"sizeSlug":"large","linkDestination":"media"} -->
      <figure class="wp-block-image size-large"><a href="http://localhost/adoni/at-portfolio/wp-content/uploads/2022/08/Placeholder_Image.gif"><img src="http://localhost/adoni/at-portfolio/wp-content/uploads/2022/08/Placeholder_Image.gif" alt="" class="wp-image-1712"/></a></figure>
      <!-- /wp:image -->
      
      <!-- wp:image {"id":1712,"sizeSlug":"large","linkDestination":"media"} -->
      <figure class="wp-block-image size-large"><a href="http://localhost/adoni/at-portfolio/wp-content/uploads/2022/08/Placeholder_Image.gif"><img src="http://localhost/adoni/at-portfolio/wp-content/uploads/2022/08/Placeholder_Image.gif" alt="" class="wp-image-1712"/></a></figure>
      <!-- /wp:image -->
      
      <!-- wp:image {"id":1712,"sizeSlug":"large","linkDestination":"media"} -->
      <figure class="wp-block-image size-large"><a href="http://localhost/adoni/at-portfolio/wp-content/uploads/2022/08/Placeholder_Image.gif"><img src="http://localhost/adoni/at-portfolio/wp-content/uploads/2022/08/Placeholder_Image.gif" alt="" class="wp-image-1712"/></a></figure>
      <!-- /wp:image -->
      
      <!-- wp:image {"id":1712,"sizeSlug":"large","linkDestination":"media"} -->
      <figure class="wp-block-image size-large"><a href="http://localhost/adoni/at-portfolio/wp-content/uploads/2022/08/Placeholder_Image.gif"><img src="http://localhost/adoni/at-portfolio/wp-content/uploads/2022/08/Placeholder_Image.gif" alt="" class="wp-image-1712"/></a></figure>
      <!-- /wp:image -->
      
      <!-- wp:image {"id":1712,"sizeSlug":"large","linkDestination":"media"} -->
      <figure class="wp-block-image size-large"><a href="http://localhost/adoni/at-portfolio/wp-content/uploads/2022/08/Placeholder_Image.gif"><img src="http://localhost/adoni/at-portfolio/wp-content/uploads/2022/08/Placeholder_Image.gif" alt="" class="wp-image-1712"/></a></figure>
      <!-- /wp:image -->
      
      <!-- wp:image {"id":1712,"sizeSlug":"large","linkDestination":"media"} -->
      <figure class="wp-block-image size-large"><a href="http://localhost/adoni/at-portfolio/wp-content/uploads/2022/08/Placeholder_Image.gif"><img src="http://localhost/adoni/at-portfolio/wp-content/uploads/2022/08/Placeholder_Image.gif" alt="" class="wp-image-1712"/></a></figure>
      <!-- /wp:image --></figure>
      <!-- /wp:gallery --></section>
      <!-- /wp:group -->',
  ) );
}

/**
 * Flush the permalinks when this plugin is activated
 */
register_activation_hook( __FILE__, 'at_cpt_flush' );
function at_cpt_flush(){
  //register the cpt first
  at_portfolio_cpt_register(); //function where I first registered the plugin (top of this file)
  flush_rewrite_rules();
}
