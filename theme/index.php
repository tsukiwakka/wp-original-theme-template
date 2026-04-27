<?php
/**
 * index.php
 * メインテンプレート（フォールバック）
 */
get_header(); ?>

<main id="main" class="site-main" role="main">
  <div class="container mx-auto px-6 py-12">

    <?php if (have_posts()) : ?>

      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <?php while (have_posts()) : the_post(); ?>
          <?php get_template_part('parts/content', get_post_type()); ?>
        <?php endwhile; ?>
      </div>

      <?php the_posts_pagination([
          'mid_size'  => 2,
          'prev_text' => __('← 前のページ', 'my-theme'),
          'next_text' => __('次のページ →', 'my-theme'),
      ]); ?>

    <?php else : ?>
      <?php get_template_part('parts/content', 'none'); ?>
    <?php endif; ?>

  </div>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
