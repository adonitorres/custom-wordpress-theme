<?php get_header(); //requires header.php ?>

    <main class="content">
      <?php //The Loop
      if( have_posts() ){
        while( have_posts() ){
          the_post();
      ?>


      <article class="post">
        <h2 class="entry-title">
          <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
          </a>
        </h2>
        <div class="entry-content">
          <?php
          //if this is a single post or page, show the full content
          the_content(); //full content ?>
          <?php wp_link_pages(); ?>
        </div>
        
      </article>
      <!-- end .post -->

      <?php
        } //end while
      }else{
        echo 'Sorry, No Posts.';
      } ?>

    </main>
    <!-- end .content -->

<?php get_footer(); //requires footer.php ?>