<?php if (!empty($pagination)): ?>
	<div class="pagination">
		<?php if (isset($pagination['arrow_left'])): ?>
			<a href="<?php echo Lang::link($pagination['link']) ?><?php echo ($pagination['arrow_left'] != 1) ? '?page='.$pagination['arrow_left'] : '' ?>" class="pagination-btn">
				<svg class="pagination-arrow-left" x="0px" y="0px" viewBox="0 0 492 492" style="enable-background:new 0 0 492 492;">
					<path d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12 C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084 c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864 l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z"/>
				</svg>
			</a>
		<?php endif ?>
		<a href="<?php echo Lang::link($pagination['link']) ?>" class="pagination-btn<?php if ($pagination['active'] == 1) echo ' active' ?>">
			1
		</a>
		<?php if (isset($pagination['middle'])): ?>
			<?php foreach ($pagination['middle'] as $item): ?>
				<?php if ($item == -1): ?>
					<div class="pagination-btn-empty">...</div>
				<?php else: ?>
					<a href="<?php echo Lang::link($pagination['link']) ?>?page=<?php echo $item ?>" class="pagination-btn<?php if ($pagination['active'] == $item) echo ' active' ?>">
						<?php echo $item ?>
					</a>
				<?php endif ?>
			<?php endforeach ?>
		<?php endif ?>
		<a href="<?php echo Lang::link($pagination['link']) ?>?page=<?php echo $pagination['last'] ?>" class="pagination-btn<?php if ($pagination['active'] == $pagination['last']) echo ' active' ?>">
			<?php echo $pagination['last'] ?>
		</a>
		<?php if (isset($pagination['arrow_right'])): ?>
			<a href="<?php echo Lang::link($pagination['link']) ?>?page=<?php echo $pagination['arrow_right'] ?>" class="pagination-btn">
				<svg class="pagination-arrow-right" x="0px" y="0px" viewBox="0 0 492 492" style="enable-background:new 0 0 492 492;">
					<path d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12 C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084 c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864 l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z"/>
				</svg>
			</a>
		<?php endif ?>
	</div>
<?php endif ?>


@section('meta-directions')

@if (isset($pagination['arrow_left']))
	<link rel="prev" href="https://digiants.agency<?php echo Lang::link($pagination['link']) ?><?php echo ($pagination['arrow_left'] != 1) ? '?page='.$pagination['arrow_left'] : '' ?>">
@endif

@if (isset($pagination['arrow_right']))
	<link rel="next" href="https://digiants.agency<?php echo Lang::link($pagination['link']) ?>?page=<?php echo $pagination['arrow_right'] ?>">
@endif

@endsection