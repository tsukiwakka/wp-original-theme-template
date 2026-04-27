<?php
/**
 * inc/template-tags.php
 * カスタムテンプレートタグ（テンプレートから呼び出す関数群）
 */

defined('ABSPATH') || exit;

/**
 * 投稿のメタ情報を出力
 */
function theme_posted_on(): void {
    printf(
        '<span class="posted-on"><time datetime="%1$s">%2$s</time></span>',
        esc_attr(get_the_date('c')),
        esc_html(get_the_date())
    );
}

/**
 * 著者情報を出力
 */
function theme_posted_by(): void {
    printf(
        '<span class="byline">%s <a href="%s" class="author-link">%s</a></span>',
        esc_html__('By', 'my-theme'),
        esc_url(get_author_posts_url(get_the_author_meta('ID'))),
        esc_html(get_the_author())
    );
}

/**
 * 読了時間を計算して出力
 */
function theme_reading_time(): void {
    $content = get_the_content();
    $word_count = str_word_count(strip_tags($content));
    $reading_time = (int) ceil($word_count / 200); // 200文字/分

    printf(
        '<span class="reading-time">%s</span>',
        sprintf(
            /* translators: %d: reading time in minutes */
            esc_html__('約%d分で読めます', 'my-theme'),
            $reading_time
        )
    );
}

/**
 * パンくずリスト
 */
function theme_breadcrumbs(): void {
    if (is_front_page()) return;

    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__('パンくずリスト', 'my-theme') . '">';
    echo '<ol class="flex flex-wrap items-center gap-2 text-sm text-gray-500">';
    echo '<li><a href="' . esc_url(home_url('/')) . '" class="hover:text-blue-600">' . esc_html__('ホーム', 'my-theme') . '</a></li>';

    if (is_single() || is_page()) {
        echo '<li aria-hidden="true">/</li>';
        echo '<li class="text-gray-900 font-medium" aria-current="page">' . esc_html(get_the_title()) . '</li>';
    } elseif (is_archive()) {
        echo '<li aria-hidden="true">/</li>';
        echo '<li class="text-gray-900 font-medium" aria-current="page">' . esc_html(get_the_archive_title()) . '</li>';
    }

    echo '</ol>';
    echo '</nav>';
}
