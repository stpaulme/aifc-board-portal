<?php
/**
 * View: List View - Single Event Title
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event/title.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://m.tri.be/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */
?>
<h3 class="tribe-events-calendar-list__event-title tribe-common-h6 tribe-common-h4--min-medium">
	<a
		href="<?php echo esc_url( $event->permalink ); ?>"
		title="<?php echo esc_attr( $event->title ); ?>"
		rel="bookmark"
		class="tribe-events-calendar-list__event-title-link tribe-common-anchor-thin"
	>
  
    <?php
      $event_categories = get_the_terms($event->ID, 'tribe_events_cat');
      
      if ( is_array($event_categories) && count($event_categories) ) {
        $event_category = $event_categories[0];
        
        if ($event_category->parent) {
            $event_category_parent = get_term($event_category->parent, 'tribe_events_cat');
            $event_category_name = $event_category_parent->name;
        } else {
            $event_category_name = $event_category->name;
        }
      }
    ?>
  
    <?php echo $event_category_name . ': '; ?>
		
    <?php
		// phpcs:ignore
		echo $event->title;
		?>
	</a>
</h3>
