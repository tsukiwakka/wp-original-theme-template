<?php
/**
 * single.php
 * 投稿詳細ページ
 */
get_header(); ?>

<main id="main" class="site-main" role="main">
  <div class="container mx-auto px-6 py-12 max-w-3xl">

    <?php while (have_posts()) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header mb-8">
          <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
              <?php echo esc_html(get_the_date()); ?>
            </time>
            <?php the_category(' · '); ?>
          </div>

          <?php the_title('<h1 class="entry-title text-4xl font-bold text-gray-900 leading-tight mb-6">', '</h1>'); ?>

          <?php if (has_post_thumbnail()) : ?>
            <div class="rounded-xl overflow-hidden aspect-video mb-8">
              <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
            </div>
          <?php endif; ?>
        </header>

        <div class="entry-content prose max-w-none">
          <?php the_content(); ?>
        </div>

        <footer class="entry-footer mt-12 pt-8 border-t border-gray-200">
          <?php the_tags('<div class="flex flex-wrap gap-2">', '', '</div>'); ?>
        </footer>

      </article>

      <?php
      the_post_navigation([
          'prev_text' => __('← %title', 'my-theme'),
          'next_text' => __('%title →', 'my-theme'),
      ]);
      ?>

      <?php if (comments_open() || get_comments_number()) : ?>
        <?php comments_template(); ?>
      <?php endif; ?>

    <?php endwhile; ?>

  </div>
</main>

<?php get_footer(); ?>
