<?php
/**
 * Plugin Name: HM SalesForce Lightning Form Embed
 * Description: Registers an embed handler for SalesForce forms.
 * Version: 0.1.0
 * Author: Human Made Limited
 * Author URI: https://humanmade.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: hm-salesforce-lightning-form-embed
 */

namespace HM\SalesForce_Form_Embed;

wp_embed_register_handler(
	'salesforce-lightning-embed',
	'#https?://[^\.]+\.my\.salesforce-sites\.com/[^/]+/?#i',
	function ( $matches ) {
		static $instance_id = 1;

		$embed = sprintf(
			<<<'HTML'
				<script data-cookieyes="ignore" src="%2$s/lightning/lightning.out.js"></script>
				<div id="salesforce-lightning-locator-%1$s" class="salesforce-lightning-embed"></div>
				<script>
					$Lightning.use('c:embedFlowInExternalWebsiteApp',
						function() {
							$Lightning.createComponent(
								'c:embedFlowInExternalWebsite',
								{ },
								'salesforce-lightning-locator-%1$s',
								function(cmp) {}
							);
						},
						'%2$s'
					);
				</script>
				<noscript>
					<div class="salesforce-lightning-embed">
						<a href="%2$s" rel="nofollow">%3$s</a> (%4$s).
					</div>
				</noscript>
				HTML,
			$instance_id++,
			untrailingslashit( $matches[0] ),
			esc_html__( 'Open the form', 'hm-salesforce-lightning-form-embed' ),
			esc_html__( 'alternatively, enable JavaScript to use the form on this page', 'hm-salesforce-lightning-form-embed' )
		);

		return $embed;
	}
);
