<?php 

$subclass ??= [];

$subclass = is_array($subclass) ? array_replace_recursive([
		'section' => '',
		'container' => ''
	], $subclass) : [
		'section' => $subclass,
		'container' => ''
	];

?>

<section class="{{ $subclass['section'] }} min-w-max relative rounded shadow bg-white overflow-hidden">
	<div class="{{ $subclass['container'] }} w-full px-4 py-1 sm:py-2">
		{!! $slot !!}
	</div>
</section>