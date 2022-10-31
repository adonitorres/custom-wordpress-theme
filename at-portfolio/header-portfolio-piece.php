<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <?php wp_head(); ?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="site portfolio-piece">
  <header class="header">
    <div class="branding"> 
      <?php the_custom_logo(); ?>
      </div>
      <div class="navigation">
        <div class="flex">
          <h1 class="site-title">
            <div>
              <a href="<?php echo esc_url( home_url() ); ?>">
                <?php bloginfo( 'name' ); ?>
              </a>
            </div>
          </h1>
          <?php
          //display one of our registered menu areas
          wp_nav_menu( array(
            'theme_location' => 'main_nav', //from functions.php
            'container' => 'nav', //div, nav, or false
            'container_class' => 'main-menu', //<nav class="main-menu'>
          ) ); ?>
        </div>
      </div>
      <div class="utilities">
        <?php dynamic_sidebar( 'header_utility' ); ?>
      </div>
      <?php //get_search_form(); ?>
  </header>