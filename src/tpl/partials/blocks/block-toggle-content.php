<?php

defined('ABSPATH') || exit();

$question = get_query_var('toggle-content/question');
$answer = get_query_var('toggle-content/answer');

if(!empty($question)) :
?>


<article class="wp-block-toggle-content">
	<h4><?php echo $question ?> <i class="fas fa-minus"></i><i class="fas fa-plus"></i></h4>
	<div>
		<p><?php echo $answer ?></p>
	</div>

</article>

<?php endif; ?>