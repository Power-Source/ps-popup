<?php

/**

 * This page is only displayed when

 * 1. PO_GLOBAL is true

 * 2. The site is a Multisite network

 * 3. User is in the Network-Dashboard

 * 4. Any "PopUp" menuitem is opened (Edit PopUp, Create PopUp, ...)

 */



switch_to_blog( BLOG_ID_CURRENT_SITE );

$main_url = admin_url( 'edit.php?post_type=' . IncPopupItem::POST_TYPE );

$blog_title = get_bloginfo( 'name' );

restore_current_blog();



$dismiss_url = esc_url_raw( add_query_arg( 'popup_network', 'hide' ) );



?>

<style>

blockquote p {

	font-size: 19px;

	font-style: italic;

	font-weight: 300;

	background: #FAFAFA;

	padding: 10px;

}

</style>

<div id="wpbody-content" tabindex="0">

	<div class="wrap">

		<h2><?php _e( 'Globale PopUps', 'popover' ); ?></h2>



		<blockquote>

		<p><?php

		printf(

			__(

				'Bitte beachte:<br/> Wir haben die globalen PopUp-Menüelemente verschoben ' .

				'zum <strong>Hauptblog</strong> Deines Multisite ' .

				'Netzwerks!<br />Der Hauptblog dieses Netzwerks ist "%1$s" - ' .

				'<a href="%2$s">Gehe jetzt zum Hauptblog</a>!', 'popover'

			),

			$blog_title,

			esc_url( $main_url )

		);

		?></p>

		</blockquote>



		<div>

			<p><?php

			_e(

				'Weil die Menüpunkte "PopUp" hier auf der ' .

				'<strong>Netzwerk Admin Seite</strong> werden nicht mehr verwendet ' .

				'Du kannst sie jederzeit <strong>ausblenden</strong>:', 'popover'

			);

			?></p>

			<p>

				<a href="<?php echo esc_url( $dismiss_url ); ?>" class="button-primary">

					<?php _e( 'Verstecke die Menüpunkte hier!', 'popover' ); ?>

				</a>

			</p>

		</div>

	</div>

	<div class="clear"></div>

</div>