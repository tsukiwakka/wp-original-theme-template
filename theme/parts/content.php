<?php
/**
 * parts/content.php
 * 投稿カードテンプレート（ループ内で使用）
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow'); ?>>

  <?php if (has_post_thumbnail()) : ?>
    <a href="<?php the_permalink(); ?>" class="block overflow-hidden aspect-video">
      <?php the_post_thumbnail('medium_large', [
          'class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300',
          'alt'   => get_the_title(),
      ]); ?>
    </a>
  <?php endif; ?>

  <div class="p-6">
    <header class="entry-header mb-3">
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
          <?php echo esc_html(get_the_date()); ?>
        </time>
        <?php the_category(' · '); ?>
      </div>

      <?php the_title(
          sprintf('<h2 class="entry-title text-lg font-bold leading-snug"><a href="%s" class="text-gray-900 hover:text-blue-600 transition-colors">', esc_url(get_permalink())),
          '</a></h2>'
      ); ?>
    </header>

    <div class="entry-summary text-sm text-gray-600 line-clamp-3">
      <?php the_excerpt(); ?>
    </div>

    <footer class="entry-footer mt-4">
      <a href="<?php the_permalink(); ?>"
         class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
        <?php esc_html_e('続きを読む', 'my-theme'); ?>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
      </a>
    </footer>
  </div>

</article>
