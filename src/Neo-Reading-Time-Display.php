<?php
/*
Plugin Name: Neo Reading Time Display
Description: 記事ページの先頭に「この記事は〇分〇秒で読めます」を表示するプラグイン
Version: 0.1
Author: Nano Yozakura
*/

function calculate_reading_time($content) {
    if (is_single()) { // 記事ページのみ
        $char_count = mb_strlen(strip_tags($content)); // HTMLタグを除いた文字数をカウント
        $minutes = floor($char_count / 350);
        $seconds = floor(round($char_count % 350) % 60);
        
        $reading_time = "この記事は";
        if ($minutes > 0) {
            $reading_time .= "{$minutes}分";
        }
        if ($seconds > 0 || $minutes == 0) {
            $reading_time .= "{$seconds}秒";
        }
        $reading_time .= "で読めるなの";
        
        $content = "<p><strong>{$reading_time}</strong></p>" . $content;
    }
    return $content;
}
add_filter('the_content', 'calculate_reading_time');
