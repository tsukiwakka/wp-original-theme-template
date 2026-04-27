<?php
/**
 * functions.php
 *
 * Vite のマニフェストを読み込み、ハッシュ付きアセットを
 * WordPressに正しくエンキューする仕組みを実装。
 *
 * 開発時: Vite dev server (localhost:5173) からHMRで配信
 * 本番時: theme/dist/.vite/manifest.json を参照してビルド済みファイルを配信
 */

defined('ABSPATH') || exit;

// ============================================================
// Vite アセット統合
// ============================================================

/**
 * Vite dev server が起動中かどうか判定
 * .vite-dev-server ファイルの存在で判断（npm run dev時に作成）
 */
function theme_is_vite_dev(): bool {
    return defined('WP_DEBUG') && WP_DEBUG
        && file_exists(get_template_directory() . '/.vite-dev-server');
}

/**
 * Vite manifest を読み込んでアセットURLを返す
 */
function theme_vite_asset(string $entry): string {
    static $manifest = null;

    if (theme_is_vite_dev()) {
        return "http://localhost:5173/{$entry}";
    }

    if ($manifest === null) {
        $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
        if (file_exists($manifest_path)) {
            $manifest = json_decode(file_get_contents($manifest_path), true);
        } else {
            $manifest = [];
            if (WP_DEBUG) {
                error_log('[Theme] manifest.json が見つかりません。npm run build を実行してください。');
            }
        }
    }

    if (isset($manifest[$entry]['file'])) {
        return get_template_directory_uri() . '/dist/' . $manifest[$entry]['file'];
    }

    return '';
}

// ============================================================
// スクリプト・スタイルのエンキュー
// ============================================================
add_action('wp_enqueue_scripts', function () {

    if (theme_is_vite_dev()) {
        // ── 開発時: Vite HMR クライアントを読み込む ──
        // @vite/client と main.js は type="module" で読み込む必要がある
        wp_enqueue_script('vite-client', 'http://localhost:5173/@vite/client', [], null, false);
        wp_enqueue_script('theme-main',  'http://localhost:5173/js/main.js',   [], null, true);

        // type="module" を付与（ViteはESMで動作するため必須）
        add_filter('script_loader_tag', function (string $tag, string $handle): string {
            if (in_array($handle, ['vite-client', 'theme-main'], true)) {
                return str_replace('<script ', '<script type="module" ', $tag);
            }
            return $tag;
        }, 10, 2);

        // 開発時はSCSSをmain.jsのimportで処理するためCSSの別途読み込みは不要
        // （main.js の先頭で style.scss を import していること）
    } else {
        // ── 本番時: manifest.json からハッシュ付きファイルを読み込む ──
        $css_url = theme_vite_asset('scss/style.scss');
        $js_url  = theme_vite_asset('js/main.js');

        if ($css_url) {
            wp_enqueue_style('theme-style', $css_url, [], null);
        }
        if ($js_url) {
            wp_enqueue_script('theme-main', $js_url, [], null, true);
        }
    }
});

// ============================================================
// テーマサポート設定
// ============================================================
add_action('after_setup_theme', function () {
    // HTML5マークアップ
    add_theme_support('html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ]);

    // アイキャッチ画像
    add_theme_support('post-thumbnails');

    // カスタムロゴ
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ]);

    // タイトルタグ
    add_theme_support('title-tag');

    // Gutenberg: フルワイド画像
    add_theme_support('align-wide');

    // Gutenberg: エディタースタイル
    add_theme_support('editor-styles');
    add_editor_style('dist/css/style.css');

    // ナビゲーションメニュー登録
    register_nav_menus([
        'primary' => __('メインナビゲーション', 'my-theme'),
        'footer'  => __('フッターナビゲーション', 'my-theme'),
    ]);

    // 翻訳ファイルの読み込み
    load_theme_textdomain('my-theme', get_template_directory() . '/languages');
});

// ============================================================
// ウィジェットエリア登録
// ============================================================
add_action('widgets_init', function () {
    register_sidebar([
        'name'          => __('サイドバー', 'my-theme'),
        'id'            => 'sidebar-1',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
});

// ============================================================
// インクルードファイル
// ============================================================
$includes = [
    '/inc/template-tags.php',   // テンプレートタグ
    '/inc/customizer.php',      // カスタマイザー設定
];

foreach ($includes as $file) {
    $path = get_template_directory() . $file;
    if (file_exists($path)) {
        require_once $path;
    }
}
