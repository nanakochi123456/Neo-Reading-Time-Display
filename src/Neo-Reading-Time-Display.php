<?php
/*
Plugin Name: Neo Reading Time Display
Description: 記事ページの先頭に「この記事は〇分〇秒で読めます」を表示するプラグイン
Version: 0.12
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
        if ($seconds > 0 || $minutes == 0) {
            $reading_time .= "{$seconds}秒";
        }
        $reading_time .= "ぐらいで読めるなの";
        
        $content = "<p><strong>{$reading_time}</strong></p>" . $content;
    }
    return $content;
}
add_filter('the_content', 'calculate_reading_time');
