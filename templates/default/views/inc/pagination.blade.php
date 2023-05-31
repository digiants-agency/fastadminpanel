<?php if (!empty($pagination)): ?>
<div class="pagination">
	<?php if (isset($pagination['arrow_left'])): ?>
	<a href="<?php echo ($pagination['link']) ?><?php echo ($pagination['arrow_left'] != 1) ? $pagination['separator'].'page='.$pagination['arrow_left'] : '' ?>" class="pagination-btn">
		<svg class="pagination-arrow-left" width="10" height="8" viewBox="0 0 10 8">
			<path d="M0.646446 4.35355C0.451184 4.15829 0.451184 3.84171 0.646446 3.64645L3.82843 0.464467C4.02369 0.269204 4.34027 0.269204 4.53553 0.464467C4.7308 0.659729 4.7308 0.976311 4.53553 1.17157L1.70711 4L4.53553 6.82843C4.7308 7.02369 4.7308 7.34027 4.53553 7.53553C4.34027 7.7308 4.02369 7.7308 3.82843 7.53553L0.646446 4.35355ZM10 4.5L1 4.5L1 3.5L10 3.5L10 4.5Z" fill="#1C1C1C"/>
		</svg>
	</a>
	<?php endif ?>
	<a href="<?php echo ($pagination['link']) ?>" class="pagination-btn<?php if ($pagination['active'] == 1) echo ' active' ?>">
		1
	</a>
	<?php if (isset($pagination['middle'])): ?>
	<?php foreach ($pagination['middle'] as $item): ?>
	<?php if ($item == -1): ?>
	<div class="pagination-btn-empty">...</div>
	<?php else: ?>
	<a href="<?php echo ($pagination['link']) ?><?php echo $pagination['separator'] ?>page=<?php echo $item ?>" class="pagination-btn<?php if ($pagination['active'] == $item) echo ' active' ?>">
		<?php echo $item ?>
	</a>
	<?php endif ?>
	<?php endforeach ?>
	<?php endif ?>
	<a href="<?php echo ($pagination['link']) ?><?php echo $pagination['separator'] ?>page=<?php echo $pagination['last'] ?>" class="pagination-btn<?php if ($pagination['active'] == $pagination['last']) echo ' active' ?>">
		<?php echo $pagination['last'] ?>
	</a>
	<?php if (isset($pagination['arrow_right'])): ?>
	<a href="<?php echo ($pagination['link']) ?><?php echo $pagination['separator'] ?>page=<?php echo $pagination['arrow_right'] ?>" class="pagination-btn">
		<svg class="pagination-arrow-right" width="10" height="8" viewBox="0 0 10 8">
			<path d="M9.35355 4.35355C9.54882 4.15829 9.54882 3.84171 9.35355 3.64645L6.17157 0.464467C5.97631 0.269204 5.65973 0.269204 5.46447 0.464467C5.2692 0.659729 5.2692 0.976311 5.46447 1.17157L8.29289 4L5.46447 6.82843C5.2692 7.02369 5.2692 7.34027 5.46447 7.53553C5.65973 7.7308 5.97631 7.7308 6.17157 7.53553L9.35355 4.35355ZM-4.37114e-08 4.5L9 4.5L9 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="#1C1C1C"/>
		</svg>
	</a>
	<?php endif ?>
</div>
<?php endif ?>


@section('meta-directions')

	@if (isset($pagination['arrow_left']))
		<link rel="prev" href="<?php echo ($pagination['link']) ?><?php echo ($pagination['arrow_left'] != 1) ? $pagination['separator'].'page='.$pagination['arrow_left'] : '' ?>">
	@endif

	@if (isset($pagination['arrow_right']))
		<link rel="next" href="<?php echo ($pagination['link']) ?><?php echo $pagination['separator'] ?>page=<?php echo $pagination['arrow_right'] ?>">
	@endif

@endsection
