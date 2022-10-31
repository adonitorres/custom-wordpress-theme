<?php
add_theme_support( 'post-thumbnails' );

//custome body background
add_theme_support( 'custom-background' );

//custom header.
//dev: don't forget to display your header in header.php
$args = array(
  'height'        => 930,
  'width'         => 1920,
  'flex-height'   => true,
  'flex-width'    => true,
);
add_theme_support( 'custom-header', $args );

//custom logo
//dev: don't forget to display the logo (header?)
$args = array(
  'height' => 200,
  'width' => 200,
  'flex-height' => true,
);
add_theme_support( 'custom-logo', $args );

//SEO friendly titles
//dev: make sure you remove the <title> from header.php
add_theme_support( 'title-tag' );

//upgrade the markup of basic components to HTML5
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );

//post formats
//dev: only use this if you have a blog
add_theme_support( 'post-formats', array( 'quote', 'link', 'gallery' ) );

//improve RSS feeds
add_theme_support( 'automatic-feed-links' );

//custom image size for the portfolio
//                name, width, height, crop?
add_image_size( 'banner', 1920, 930, true );

/**
 * displays the featured image of the post with a container and link to single
 * @return mixed html output
 */
function at_portfolio_post_featured_image( $size = 'large' ){
  if( has_post_thumbnail() ){ ?>
    <div class="featured-image-container">
      <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail( $size ); ?>
      </a>
    </div>
  <?php
  } //end if has post thumbnail
}

/**
 * Customize the excerpt
 */
add_filter( 'excerpt_length', 'at_portfolio_excerpt_length' );
function at_portfolio_excerpt_length(){
  if( is_search() OR is_category() ){
    return 10; //words
  }else{
    return 30; //words
  }
}

/**
 * Adds 'Read More' button at the end of the excerpt
 */
add_filter( 'excerpt_more', 'at_portfolio_excerpt_more' );
function at_portfolio_excerpt_more(){
  $link = get_the_permalink();
  return "&hellip; <a href='$link' class='button'>Read More</a>";
}

/**
 * Removing all inline styles from elements
 */
 add_filter('the_content', function( $content ){
    $content = preg_replace('/ style=("|\')(.*?)("|\')/','',$content);
    return $content;
}, 20);

/**
 * Adds copyright to wp_footer
 */
// add_action( 'wp_footer', 'at_portfolio_copyright' );
// function at_portfolio_copyright(){
//   echo '&copy; 2022 AT Portfolio Theme <br>';
// }

/**
 * Improve the UX when replying to comments
 * Attach the style.css for this theme
 */
add_action( 'wp_enqueue_scripts', 'at_portfolio_scripts' );
function at_portfolio_scripts(){
  //get the theme info so we can use the version
  $theme = wp_get_theme();
  $version = $theme->get( 'Version' );
  $theme_root = get_stylesheet_uri();

  //this script is built-into wordpress
  if( is_singular() AND comments_open() ){
    wp_enqueue_script( 'comment-reply' );
  }
  //get the theme info so we can use the version
  $theme = wp_get_theme();
  wp_enqueue_style( 'theme-style', $theme_root, array(), $version );

  //get the JS code
  wp_enqueue_script( 'main', get_template_directory_uri() . '/scripts/main.js' );
}

/**
 * Menu Areas
 */
add_action( 'init', 'at_portfolio_menu_areas' );
function at_portfolio_menu_areas(){
  register_nav_menus( array(
    'main_nav' => 'Main Navigation',
    'utilities' => 'Utility Area',
  ) );
}

/**
 * Fallback Callback for the utility menu
 */
function at_portfolio_menu_default(){
  echo 'Choose a Utility Menu in the admin panel';
}

/**
 * Pagination function that can work on any template
 */
function at_portfolio_pagination(){
  echo '<div class="pagination">';
  if( is_singular() ){
    previous_post_link( '%link', '&larr; %title' );
    next_post_link( '%link', '%title &rarr;' );
  }else{
    //archive pagination
    //if mobile, do next/previous buttons
    if( wp_is_mobile() ){
      previous_posts_link( '&larr; Previous' );
      next_posts_link( 'Next &rarr;' );
    }else{
      //desktop - numbered pagination
      the_posts_pagination( array(
        'prev_text' => '&larr; Previous',
        'next_text' => 'Next &rarr;',
        'mid_size' => 1,
      ) );
    }
  }
  echo '</div>';
}

/**
 * Register all widget areas
 */
add_action( 'widgets_init', 'at_portfolio_widget_areas' );
function at_portfolio_widget_areas(){
  //set up one widget area
  register_sidebar( array(
    'name' => 'Header Utility Area',
    'id' => 'header_utility',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>'
  ) );

  register_sidebar( array(
    'name' => 'Footer Area',
    'id' => 'footer_area',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>'
  ) );

  register_sidebar( array(
    'name' => 'Home Footer Area',
    'id' => 'home_footer_area',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>'
  ) );
}

/**
 * Change how comments are counted - only count real comments, not trackbacks
 */
add_filter( 'get_comments_number', 'at_portfolio_comments_number' );
function at_portfolio_comments_number(){
  //the post we're counting comments on
  global $id;
  $comments = get_approved_comments( $id );
  $count = 0;
  foreach( $comments AS $comment ){
    if( $comment->comment_type == 'comment' ){
      $count++;
    }
  }
  return $count;
}

/**
 * Count just the pingbacks and trackbacks
 * @return mixed 0 if no pings, otherwise return the count with grammar
 */
function at_portfolio_pings_numbers(){
  //the post we're counting comments on
  global $id;
  $comments = get_approved_comments( $id );
  $count = 0;
  foreach( $comments AS $comment ){
    if( $comment->comment_type != 'comment' ){
      $count++;
    }
  }
  if( $count == 0 ){
    return 0;
  }else{
    return $count == 1 ? 'One site mentions' : "$count sites mention";
  }
}

/**
 * Pagination for comment lists
 */
function at_portfolio_comments_pagination(){
  //if pagination is needed, show it
  if( get_option( 'page_comments' ) ){
    ?>
    <section class="comment-pagination pagination">
      <?php
      previous_comments_link();
      next_comments_link();
      ?>
    </section>
    <?php
  }
}

/**
 * Removes all default block patterns
 */
add_action( 'init', function(){
	remove_theme_support( 'core-block-patterns' );
} );

/**
 * Custom query to show X number of portfolio pieces
 */
function at_portfolio_pieces( $number = 1, $size = 'thumbnail', $categories = false, $link = true ){
  if( $categories ){
    $tax_query = array( 
      'relation' => 'OR',
      array(
        'taxonomy' => 'work_category',
        'terms' => $categories,
        'field' => 'slug',
      ),
    );
  }else{
    $tax_query = array();
  }

  $portfolio_query = new WP_Query( array(
    'post_type' => 'work',
    'posts_per_page' => $number, //limit
    'page' => 1,
    'tax_query' => $tax_query,
  ) );
  if( $portfolio_query->have_posts() ){
  ?>
  <div class="portfolio-pieces">
    <?php
    while( $portfolio_query->have_posts() ){
      $portfolio_query->the_post();
    ?>
    <div class="portfolio-piece">
      <div class="cover-image">
        <?php if( $link ){ ?>
        <a href="<?php the_permalink(); ?>">
          <?php the_post_thumbnail( $size ); ?>
        </a>
        <?php }else{
          the_post_thumbnail( $size );
        } ?>
        <div class="info">
          <h2 class="entry-title"><?php the_title(); ?></h2>
          <?php 
          if( $link ){
            the_terms( get_the_ID(), 'work_category', '<h3>', ', ', '</h3>' );
          }else{
            $cats = get_the_terms( $post, 'work_category' )();
            foreach( $cats as $cat ){
              echo $cat->name;
            }
          } ?>
        </div>
      </div>
    </div>
    <?php } //end while ?>
  </div>
  <?php
  } //end if posts found

  //clean up for future loops
  wp_reset_postdata(); 
}

/**
 * Customizing main query behavior
 * Change the number of posts on the search results and the portfolio
 * The blog and other archives should still use the setting (10)
 */
add_action( 'pre_get_posts', 'at_portfolio_query_tweaks' );
function at_portfolio_query_tweaks( $query ){
  if( is_search() ){
    $query->set( 'posts_per_page', 20 );
  }elseif( is_post_type_archive( 'work' ) ){
    $query->set( 'posts_per_page', 12 );
  }
}

/**
 * Block Editor Enqueue Styles
 */
function gutenberg_editor_styles(){
  wp_enqueue_style('custom-editor-css', 'https://fonts.googleapis.com/css2?family=Encode+Sans+SC:wght@400;600&family=Encode+Sans:wght@500&family=Open+Sans&display=swap');
}
add_action('enqueue_block_editor_assets', 'gutenberg_editor_styles');
add_action('wp_enqueue_scripts', 'gutenberg_editor_styles');


// require_once( get_stylesheet_directory() . '/inc/block-patterns.php' );
require_once( get_stylesheet_directory() . '/inc/customizer-functions.php' );

//no close