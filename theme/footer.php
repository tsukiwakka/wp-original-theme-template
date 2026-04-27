<footer id="colophon" class="site-footer bg-gray-900 text-gray-300 mt-auto">
  <div class="container mx-auto px-6 py-12">
    <div class="grid gap-8 md:grid-cols-3">

      <div>
        <h3 class="text-white font-bold mb-4"><?php bloginfo('name'); ?></h3>
        <p class="text-sm"><?php bloginfo('description'); ?></p>
      </div>

      <div>
        <?php wp_nav_menu([
            'theme_location' => 'footer',
            'menu_id'        => 'footer-menu',
            'container'      => false,
            'menu_class'     => 'space-y-2 text-sm',
            'fallback_cb'    => false,
        ]); ?>
      </div>

      <div>
        <?php if (is_active_sidebar('sidebar-1')) : ?>
          <?php dynamic_sidebar('sidebar-1'); ?>
        <?php endif; ?>
      </div>

    </div>

    <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm">
      <p>
        &copy; <?php echo esc_html(date('Y')); ?>
        <?php bloginfo('name'); ?>.
        <?php esc_html_e('All rights reserved.', 'my-theme'); ?>
      </p>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
