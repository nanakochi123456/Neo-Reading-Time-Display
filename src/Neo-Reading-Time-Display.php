<?php
/*
Plugin Name: Neo Reading Time Display
Description: 記事ページの先頭に「この記事は〇分〇秒で読めます」を表示するプラグイン
Version: 0.14
Author: Nano Yozakura
*/

function calculate_reading_time($content) {
    $strings=350;

    if (is_single()) { // 記事ページのみ
        $text_content = strip_tags($content); // HTMLタグを除去
        $text_content = preg_replace('/\s+/u', '', $text_content); // 空白・改行を削除
        $char_count = mb_strlen($text_content); // 文字数をカウント
        $char_time = $char_count / $strings * 60;
        $minutes = floor($char_time / 60);
        $seconds = round($char_time % 60);
        
        $reading_time = "この記事は";
        if ($minutes > 0) {
            $reading_time .= "{$minutes}分";
        }
        if ($seconds > 0 || $minutes >= 0) {
            $reading_time .= "{$seconds}秒";
        }
        $reading_time .= "ぐらいで読めるなの";
        
        $content = "<div class='reading-time'>{$reading_time}</div>" . $content;
    }
    return $content;
}
// top
add_filter('the_content', 'calculate_reading_time');
// アイキャッチよりも上
//add_action('tha_entry_top', 'calculate_reading_time');

// CSSを挿入
function Neo_Reading_Time_enqueue_styles() {
    $css_file = plugin_dir_path(__FILE__) . 'Neo-Reading-Time-Display.css';
    $css_url = plugin_dir_url(__FILE__) . 'Neo-Reading-Time-Display.css';

    // タイムスタンプをクエリ文字列として付加
    wp_enqueue_style(
        'Neo-Reading-Time-style', 
        $css_url,
        array(), // 依存関係なし
        file_exists($css_file) ? filemtime($css_file) : false // タイムスタンプをバージョンに使用
    );
}
add_action('wp_enqueue_scripts', 'Neo_Reading_Time_enqueue_styles');
