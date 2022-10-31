<?php get_header(); ?>

    <main class="content single">
      <?php //The Loop
      if( have_posts() ){
        while( have_posts() ){
          the_post();
      ?>

      <article <?php post_class(); ?>>
          <div class="cover-image">
              <?php the_post_thumbnail( 'banner' ); ?>
              <h2 class="entry-title"><?php the_title(); ?></h2>
            </a>
          </div>
          <div class="entry-content">
            </section>
            <?php the_content(); ?>
            <?php wp_link_pages(); ?>
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

<?php get_footer(); ?>