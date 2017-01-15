<?php

global $option_name, $plugin_text_domain, $ajax_action, $recommended_search_term;

// search overlay template - this template styles the overlay that is used to display the search results
$preferred_post_type = "post";
if ( function_exists( 'get_option' ) ) {
	$search_options = get_option( $option_name );
	if ( isset( $search_options['preferred_post_type'] ) && $search_options['preferred_post_type'] !== false && $search_options['preferred_post_type'] !== '' ) {
		$preferred_post_type = $search_options['preferred_post_type'];
	}
}
$search_examples = get_posts( 'orderby=rand&numberposts=5&post_type=' . $preferred_post_type );
?>
<div class="search-overlay">
	<div class="search-main-container">
		<div class="search-field">
			<h2><?php _e( 'Search for post types.', $plugin_text_domain ); ?></h2>
			<input type="text" id="ajax_search" placeholder="<?php echo $recommended_search_term; ?>" />
			<input type="hidden" id="ajax_url" value="<?php echo $ajax_action; ?>" />
			<span class="results-count">
				<span class="count"></span> <span class="results-label" data-label-single="<?php _e( 'Result', 'ajax-search' ); ?>" data-label-multiple="<?php _e( 'Results', 'ajax-search' ); ?>"></span>
			</span>
			<span class="search-close">
				<i class="glyphicon glyphicon-remove"></i>
			</span>
		</div>
		<div class="preview">
			<?php if ( ! empty( $search_examples ) ) : ?>
				<p><?php _e( 'Examples', $plugin_text_domain ); ?>:</p>
				<?php // output the search_examples
				foreach ( $search_examples as $search_example ) : ?>
					<p>"<?php echo $search_example->post_title; ?>"</p>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<div class="results">
			<div class="loader">
				<?php /* display loading animation while the search is going on */ ?>
				<img src="<?php echo ajax_search_plugins_url( '/images/puff.svg' ) ?>"
				     alt="<?php _e( 'Loading Search Results...', $plugin_text_domain ); ?>">
			</div>
			<div class="no-results-info">
				<h2><?php _e( 'There are no results for your search term.', $plugin_text_domain ); ?></h2>
			</div>

			<div id="results--area" class="results--other">

			</div>
		</div>
	</div>
</div> 