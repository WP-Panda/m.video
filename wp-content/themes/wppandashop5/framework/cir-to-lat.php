<?php
function ctl_sanitize_title($title) {
    global $wpdb;

    $iso9_table = array(
        'À' => 'A', 'Á' => 'B', 'Â' => 'V', 'Ã' => 'G', '' => 'G',
        '¥' => 'G', 'Ä' => 'D', 'Å' => 'E', '¨' => 'YO', 'ª' => 'YE',
        'Æ' => 'ZH', 'Ç' => 'Z', '½' => 'Z', 'È' => 'I', 'É' => 'J',
        '£' => 'J', '²' => 'I', '¯' => 'YI', 'Ê' => 'K', '' => 'K',
        'Ë' => 'L', 'Š' => 'L', 'Ì' => 'M', 'Í' => 'N', 'Œ' => 'N',
        'Î' => 'O', 'Ï' => 'P', 'Ð' => 'R', 'Ñ' => 'S', 'Ò' => 'T',
        'Ó' => 'U', '¡' => 'U', 'Ô' => 'F', 'Õ' => 'H', 'Ö' => 'TS',
        '×' => 'CH', '' => 'DH', 'Ø' => 'SH', 'Ù' => 'SHH', 'Ú' => '',
        'Û' => 'Y', 'Ü' => '', 'Ý' => 'E', 'Þ' => 'YU', 'ß' => 'YA',
        'à' => 'a', 'á' => 'b', 'â' => 'v', 'ã' => 'g', 'ƒ' => 'g',
        '´' => 'g', 'ä' => 'd', 'å' => 'e', '¸' => 'yo', 'º' => 'ye',
        'æ' => 'zh', 'ç' => 'z', '¾' => 'z', 'è' => 'i', 'é' => 'j',
        '¼' => 'j', '³' => 'i', '¿' => 'yi', 'ê' => 'k', '' => 'k',
        'ë' => 'l', 'š' => 'l', 'ì' => 'm', 'í' => 'n', 'œ' => 'n',
        'î' => 'o', 'ï' => 'p', 'ð' => 'r', 'ñ' => 's', 'ò' => 't',
        'ó' => 'u', '¢' => 'u', 'ô' => 'f', 'õ' => 'h', 'ö' => 'ts',
        '÷' => 'ch', 'Ÿ' => 'dh', 'ø' => 'sh', 'ù' => 'shh', 'ú' => '',
        'û' => 'y', 'ü' => '', 'ý' => 'e', 'þ' => 'yu', 'ÿ' => 'ya'
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
            $iso9_table['Ù'] = 'SHT';
            $iso9_table['ù'] = 'sht';
            $iso9_table['Ú'] = 'A';
            $iso9_table['ú'] = 'a';
            break;
        case 'uk':
        case 'uk_ua':
        case 'uk_UA':
            $iso9_table['È'] = 'Y';
            $iso9_table['è'] = 'y';
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