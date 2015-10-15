<?php
function ctl_sanitize_title($title) {
    global $wpdb;

    $iso9_table = array(
        '�' => 'A', '�' => 'B', '�' => 'V', '�' => 'G', '�' => 'G',
        '�' => 'G', '�' => 'D', '�' => 'E', '�' => 'YO', '�' => 'YE',
        '�' => 'ZH', '�' => 'Z', '�' => 'Z', '�' => 'I', '�' => 'J',
        '�' => 'J', '�' => 'I', '�' => 'YI', '�' => 'K', '�' => 'K',
        '�' => 'L', '�' => 'L', '�' => 'M', '�' => 'N', '�' => 'N',
        '�' => 'O', '�' => 'P', '�' => 'R', '�' => 'S', '�' => 'T',
        '�' => 'U', '�' => 'U', '�' => 'F', '�' => 'H', '�' => 'TS',
        '�' => 'CH', '�' => 'DH', '�' => 'SH', '�' => 'SHH', '�' => '',
        '�' => 'Y', '�' => '', '�' => 'E', '�' => 'YU', '�' => 'YA',
        '�' => 'a', '�' => 'b', '�' => 'v', '�' => 'g', '�' => 'g',
        '�' => 'g', '�' => 'd', '�' => 'e', '�' => 'yo', '�' => 'ye',
        '�' => 'zh', '�' => 'z', '�' => 'z', '�' => 'i', '�' => 'j',
        '�' => 'j', '�' => 'i', '�' => 'yi', '�' => 'k', '�' => 'k',
        '�' => 'l', '�' => 'l', '�' => 'm', '�' => 'n', '�' => 'n',
        '�' => 'o', '�' => 'p', '�' => 'r', '�' => 's', '�' => 't',
        '�' => 'u', '�' => 'u', '�' => 'f', '�' => 'h', '�' => 'ts',
        '�' => 'ch', '�' => 'dh', '�' => 'sh', '�' => 'shh', '�' => '',
        '�' => 'y', '�' => '', '�' => 'e', '�' => 'yu', '�' => 'ya'
    );
    $geo2lat = array(
        '?' => 'a', '?' => 'b', '?' => 'g', '?' => 'd', '?' => 'e', '?' => 'v',
        '?' => 'z', '?' => 'th', '?' => 'i', '?' => 'k', '?' => 'l', '?' => 'm',
        '?' => 'n', '?' => 'o', '?' => 'p','?' => 'zh','?' => 'r','?' => 's',
        '?' => 't','?' => 'u','?' => 'ph','?' => 'q','?' => 'gh','?' => 'qh',
        '?' => 'sh','?' => 'ch','?' => 'ts','?' => 'dz','?' => 'ts','?' => 'tch',
        '?' => 'kh','?' => 'j','?' => 'h'
    );
    $iso9_table = array_merge($iso9_table, $geo2lat);

    $locale = get_locale();
    switch ( $locale ) {
        case 'bg_BG':
            $iso9_table['�'] = 'SHT';
            $iso9_table['�'] = 'sht';
            $iso9_table['�'] = 'A';
            $iso9_table['�'] = 'a';
            break;
        case 'uk':
        case 'uk_ua':
        case 'uk_UA':
            $iso9_table['�'] = 'Y';
            $iso9_table['�'] = 'y';
            break;
    }

    $is_term = false;
    $backtrace = debug_backtrace();
    foreach ( $backtrace as $backtrace_entry ) {
        if ( $backtrace_entry['function'] == 'wp_insert_term' ) {
            $is_term = true;
            break;
        }
    }

    $term = $is_term ? $wpdb->get_var("SELECT slug FROM {$wpdb->terms} WHERE name = '$title'") : '';
    if ( empty($term) ) {
        $title = strtr($title, apply_filters('ctl_table', $iso9_table));
        if (function_exists('iconv')){
            $title = iconv('UTF-8', 'UTF-8//TRANSLIT//IGNORE', $title);
        }
        $title = preg_replace("/[^A-Za-z0-9'_\-\.]/", '-', $title);
        $title = preg_replace('/\-+/', '-', $title);
        $title = preg_replace('/^-+/', '', $title);
        $title = preg_replace('/-+$/', '', $title);
    } else {
        $title = $term;
    }

    return $title;
}
add_filter('sanitize_title', 'ctl_sanitize_title', 9);
add_filter('sanitize_file_name', 'ctl_sanitize_title');