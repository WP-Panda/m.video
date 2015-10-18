<nav>
	<?php
	$args = array(
		'show_all'     => False, // показаны все страницы участвующие в пагинации
		'end_size'     => 1,     // количество страниц на концах
		'type'		   => 'list',
		'mid_size'     => 1,     // количество страниц вокруг текущей
		'prev_next'    => True,  // выводить ли боковые ссылки "предыдущая/следующая страница".
		'prev_text'    => '<span aria-hidden="true"><i class="fa fa-angle-left"></i></span>',
		'next_text'    => '<span aria-hidden="true"><i class="fa fa-angle-right"></i></span>',
		'add_args'     => False,
		'add_fragment' => '',     // Текст который добавиться ко всем ссылкам.
		'screen_reader_text' => 'XXX'
	);

	$nav = get_the_posts_pagination($args);
	$nav = str_replace('<h2 class="screen-reader-text">XXX</h2>', '', $nav);
	echo $nav;

	?>
</nav>