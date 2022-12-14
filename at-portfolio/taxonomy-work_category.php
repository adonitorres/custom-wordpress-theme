<?php get_header(); //requires header.php ?>

    <main class="content">
      <h1 class="page-title">Portfolio - <?php single_cat_title(); ?></h1>

      <ul class="portfolio-submenu">
        <li>
          <a href="<?php echo get_post_type_archive_link( 'work' ); ?>">All Portfolio Pieces</a>
        </li>
        <?php wp_list_categories( array(
          'title_li' => '',
          'taxonomy' => 'work_category',
        ) ); ?>
      </ul>

      <?php //The Loop
      if( have_posts() ){
        while( have_posts() ){
          the_post();
      ?>

      <article <?php post_class(); ?>>
          <div class="cover-image">
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail( 'banner' ); ?>
              <h2 class="entry-title"><?php the_title(); ?></h2>
              <?php
              //show the categories for THIS post
              the_terms( $id, 'work_category', '<h4>', ', ', '</h4>' );
              ?>
            </a>
          </div>
          <div class="entry-content">
            <?php the_excerpt(); ?>
          </div>
      </article>
      <!-- end .post -->

      <?php
        } //end while

        at_portfolio_pagination();

      }else{
        echo 'Sorry, No Posts.';
      } ?>

    </main>
    <!-- end .content -->

<?php get_footer(); //requires footer.php ?>