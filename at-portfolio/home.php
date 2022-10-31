<?php get_header(); ?>

    <main class="content">
      <section class="posts">
        <?php //The Loop
        if( have_posts() ){
          while( have_posts() ){
            the_post();
        ?>

        <article <?php post_class(); ?>>
          <?php
          //example custom function
          at_portfolio_post_featured_image(); ?>
          <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </h2>
          <div class="entry-content">
            <?php
            //if this is a single post or page, show the full content
            if( is_singular() OR has_post_format( 'link' ) ){
              the_content(); //full content
              wp_link_pages( array(
                'next_or_number' => 'next',
                'before' => '<div class="post-pagination">Keep Reading: ',
                'after' => '</div>',
                'separator' => ' | ',
                'nextpagelink' => 'Next &raquo;',
                'previouspagelink' => '&laquo; Previous',
              ) ); //support paginated posts
            }else{
              the_excerpt(); //only shows short excerpt of the content (teaser)
            } ?>
          </div>
          <div class="postmeta">
            <span class="author"><span>by: </span><?php the_author_posts_link(); ?></span>
            <span class="date"><span>posted on</span><?php the_date(); ?></span>
            <span class="num-comments"><?php comments_number(); ?></span>
            <span class="categories"><?php the_category(); ?></span>
            <span class="tags"><?php the_tags($before = '', $sep = ''); ?></span>
          </div>
          <!-- end .postmeta -->
        </article>
        <!-- end .post -->

        <?php
        //comments and the comment form
        comments_template();
        ?>

        <?php
          } //end while

          at_portfolio_pagination();

        }else{
          echo 'Sorry, No Posts.';
        } ?>
      </section>
    </main>
    <!-- end .content -->

<?php get_footer(); ?>