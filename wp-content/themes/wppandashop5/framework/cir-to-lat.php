<?php
function ctl_sanitize_title($title) {
    global $wpdb;

    $iso9_table = array(
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Ѓ' => 'G',
        'Ґ' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Є' => 'YE',
        'Ж' => 'ZH', 'З' => 'Z', 'Ѕ' => 'Z', 'И' => 'I', 'Й' => 'J',
        'Ј' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Ќ' => 'K',
        'Л' => 'L', 'Љ' => 'L', 'М' => 'M', 'Н' => 'N', 'Њ' => 'N',
        'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
        'У' => 'U', 'Ў' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'TS',
        'Ч' => 'CH', 'Џ' => 'DH', 'Ш' => 'SH', 'Щ' => 'SHH', 'Ъ' => '',
        'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'ѓ' => 'g',
        'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'є' => 'ye',
        'ж' => 'zh', 'з' => 'z', 'ѕ' => 'z', 'и' => 'i', 'й' => 'j',
        'ј' => 'j', 'і' => 'i', 'ї' => 'yi', 'к' => 'k', 'ќ' => 'k',
        'л' => 'l', 'љ' => 'l', 'м' => 'm', 'н' => 'n', 'њ' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
        'у' => 'u', 'ў' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts',
        'ч' => 'ch', 'џ' => 'dh', 'ш' => 'sh', 'щ' => 'shh', 'ъ' => '',
        'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
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
            $iso9_table['Щ'] = 'SHT';
            $iso9_table['щ'] = 'sht';
            $iso9_table['Ъ'] = 'A';
            $iso9_table['ъ'] = 'a';
            break;
        case 'uk':
        case 'uk_ua':
        case 'uk_UA':
            $iso9_table['И'] = 'Y';
            $iso9_table['и'] = 'y';
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


//правильное склонение у комментариев
function rus_comments($null = false, $one = false, $mores = false) {
    global $id;
    $number = get_comments_number($id);

    if( $number == 0) {
        $out = __('Комментариев пока нет');
    } else {
        $after = array('комментарий','комментария','комментариев');
        $cases = array(2, 0, 1, 1, 1, 2);
        $out = $number . ' ' . $after[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }

    echo apply_filters('rus_comments', $out, $number);
}

add_filter('comments_number', 'rus_comments');