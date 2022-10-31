<?php get_header('portfolio-piece'); ?>

    <main class="content portfolio-piece">
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
            <?php the_field( 'year' ); //CAUTION: the_field() function belongs to the ACF plugin. ?>
            <section class="technology">
              <h4>Technologies Used:</h4>
              <?php
              //show the categories for THIS post
              echo '<ul>';
              the_terms( $id, 'work_category', '<li>', '</li><li>', '</li>' );
              echo '</ul>';
              ?>
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