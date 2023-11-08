<div id="tribe-events-footer">
	<nav class="tribe-events-nav-pagination">
		<ul class="tribe-events-sub-nav">
			<?php if ( ! empty( $prev_url ) ) : ?>
				<li class="tribe-events-nav-previous"><a href="<?php echo $prev_url; ?>"><span aria-hidden="true">&laquo;</span> Previous</a></li>
			<?php endif; ?>
			
			<?php if ( ! empty( $next_url ) ) : ?>
				<li class="tribe-events-nav-next"><a href="<?php echo $next_url; ?>">Next <span aria-hidden="true">&raquo;</span></a></li>
			<?php endif; ?>
		</ul>
		<!-- .tribe-events-sub-nav -->
	</nav>
</div>