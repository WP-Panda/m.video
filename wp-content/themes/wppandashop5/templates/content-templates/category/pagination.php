<nav>
	<?php
	$args = array(
		'show_all'     => False, // �������� ��� �������� ����������� � ���������
		'end_size'     => 1,     // ���������� ������� �� ������
		'type'		   => 'list',
		'mid_size'     => 1,     // ���������� ������� ������ �������
		'prev_next'    => True,  // �������� �� ������� ������ "����������/��������� ��������".
		'prev_text'    => '<span aria-hidden="true"><i class="fa fa-angle-left"></i></span>',
		'next_text'    => '<span aria-hidden="true"><i class="fa fa-angle-right"></i></span>',
		'add_args'     => False,
		'add_fragment' => '',     // ����� ������� ���������� �� ���� �������.
		'screen_reader_text' => ' '
	);

	the_posts_pagination($args);

	?>
</nav>