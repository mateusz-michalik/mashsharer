<?php
/**
 * Admin Add-ons
 *
 * @package     Mashshare
 * @subpackage  Admin/Add-ons
 * @copyright   Copyright (c) 2014, Rene Hermenau
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add-ons
 *
 * Renders the add-ons content.
 *
 * @since 1.1.8
 * @return void
 */
function mash_add_ons_page() {
	ob_start(); ?>
	<div class="wrap" id="edd-add-ons">
		<h2>
			<?php _e( 'Add Ons for Mashshare', 'mashshare' ); ?>
			&nbsp;&mdash;&nbsp;<a href="http://www.mashshare.net" class="button-primary" title="<?php _e( 'Visit Website', 'mash' ); ?>" target="_blank"><?php _e( 'See Details', 'mash' ); ?></a>
		</h2>
		<p><?php _e( 'These add-ons extend the functionality of Mashshare.', 'mash' ); ?></p>
		<?php echo mash_add_ons_get_feed(); ?>
	</div>
	<?php
	echo ob_get_clean();
}

/**
 * Add-ons Get Feed
 *
 * Gets the add-ons page feed.
 *
 * @since 1.1.8
 * @return void
 */
function mash_add_ons_get_feed() {
	if ( false === ( $cache = get_transient( 'mashshare_add_ons_feed' ) ) ) {
		$feed = wp_remote_get( 'http://mashshare.net/?feed=addons', array( 'sslverify' => false ) );
		if ( ! is_wp_error( $feed ) ) {
			if ( isset( $feed['body'] ) && strlen( $feed['body'] ) > 0 ) {
				$cache = wp_remote_retrieve_body( $feed );
				set_transient( 'mashshare_add_ons_feed', $cache, 3600 );
			}
		} else {
			$cache = '<div class="error"><p>' . __( 'There was an error retrieving the Mashshare addon list from the server. Please try again later.', 'mash' ) . '
                                   <br>Visit instead the Mashshare Addon Website <a href="http://www.mashshare.net" class="button-primary" title="Mashshare Add ons" target="_blank"> Get Add-Ons  </a></div>';
		}
	}
	return $cache;
}