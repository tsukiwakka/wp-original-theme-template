<?php
/**
 * parts/content-none.php
 * 投稿が見つからない場合
 */
?>
<section class="no-results not-found text-center py-24">
  <h2 class="text-2xl font-bold text-gray-700 mb-4">
    <?php esc_html_e('コンテンツが見つかりませんでした', 'my-theme'); ?>
  </h2>
  <p class="text-gray-500 mb-8">
    <?php esc_html_e('お探しのページは見つかりませんでした。別のキーワードで検索してみてください。', 'my-theme'); ?>
  </p>
  <?php get_search_form(); ?>
</section>
