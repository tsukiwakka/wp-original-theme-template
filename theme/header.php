<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class('bg-gray-50 text-gray-900'); ?>>
<?php wp_body_open(); ?>

<a class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-white px-4 py-2 rounded z-50"
   href="#main">
  <?php esc_html_e('コンテンツへスキップ', 'my-theme'); ?>
</a>

<header id="masthead" class="site-header bg-white shadow-sm sticky top-0 z-40" data-header>
  <div class="container mx-auto px-6">
    <div class="flex items-center justify-between h-16">

      <!-- サイトロゴ / タイトル -->
      <div class="site-branding">
        <?php if (has_custom_logo()) : ?>
          <?php the_custom_logo(); ?>
        <?php else : ?>
          <a href="<?php echo esc_url(home_url('/')); ?>"
             class="text-xl font-bold text-gray-900 hover:text-blue-600 transition-colors">
            <?php bloginfo('name'); ?>
          </a>
        <?php endif; ?>
      </div>

      <!-- メインナビゲーション -->
      <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('メインナビゲーション', 'my-theme'); ?>">
        <button
          class="md:hidden p-2 rounded text-gray-600 hover:text-gray-900"
          data-nav-toggle
          aria-expanded="false"
          aria-controls="primary-menu"
          aria-label="<?php esc_attr_e('メニューを開く', 'my-theme'); ?>">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>

        <?php wp_nav_menu([
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'container'      => false,
            'menu_class'     => 'nav-menu hidden md:flex items-center gap-6',
            'fallback_cb'    => false,
            'depth'          => 2,
        ]); ?>
      </nav>

    </div>
  </div>
</header>
