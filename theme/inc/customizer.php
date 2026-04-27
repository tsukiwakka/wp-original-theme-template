<?php
/**
 * inc/customizer.php
 * WordPress カスタマイザー設定
 */

defined('ABSPATH') || exit;

add_action('customize_register', function (WP_Customize_Manager $wp_customize) {

    // ============================================================
    // テーマカラー設定
    // ============================================================
    $wp_customize->add_section('theme_colors', [
        'title'    => __('テーマカラー', 'my-theme'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('primary_color', [
        'default'           => '#3b82f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'primary_color',
        [
            'label'   => __('メインカラー', 'my-theme'),
            'section' => 'theme_colors',
        ]
    ));

    // ============================================================
    // フッター設定
    // ============================================================
    $wp_customize->add_section('theme_footer', [
        'title'    => __('フッター設定', 'my-theme'),
        'priority' => 120,
    ]);

    $wp_customize->add_setting('footer_text', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('footer_text', [
        'label'   => __('フッターテキスト', 'my-theme'),
        'section' => 'theme_footer',
        'type'    => 'textarea',
    ]);
});
