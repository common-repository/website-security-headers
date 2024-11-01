<?php
/**
 * Settings
 *
 * @package DAVEDOESTHINGS\WSH
 */

namespace DAVEDOESTHINGS\WSH\Settings;

use const DAVEDOESTHINGS\WSH\DATA_PREFIX;

const SETTINGS_KEY         = DATA_PREFIX . '_settings';
const SETTINGS_SECTION_KEY = DATA_PREFIX . '_settings_section';
const KSES_ARGS            = [
	'a'      => [
		'href'   => [],
		'target' => [],
	],
	'em'     => [],
	'strong' => [],
];

/**
 * Setup.
 *
 * @return void
 */
function setup() : void {
	add_action( 'admin_menu', __NAMESPACE__ . '\\register_settings_menu', 10 );
	add_action( 'admin_init', __NAMESPACE__ . '\\register_settings_page', 10 );
	add_action( 'admin_init', __NAMESPACE__ . '\\save_settings_options', 11 );
}

/**
 * Get the settings whitelist data.
 *
 * @return array
 */
function get_settings_whitelist() : array {

	$enable_label = esc_html__( 'Enable header?', 'davedoesthings-wsh' );
	$status_label = esc_html__( 'Status', 'davedoesthings-wsh' );

	return [
		[
			'type'  => 'checkbox',
			'key'   => DATA_PREFIX . '_global_enable',
			'label' => esc_html__( 'Global Status', 'davedoesthings-wsh' ),
			'text'  => esc_html__( 'Enable all headers? (if enabled below)', 'davedoesthings-wsh' ),
		],
		[
			'type'  => 'textarea',
			'key'   => DATA_PREFIX . '_sts_value',
			'label' => esc_html__( 'Strict Transport Security', 'davedoesthings-wsh' ),
			'text'  => esc_html__( 'Enter the VALUE for Strict-Transport-Security e.g. max-age=31536000; includeSubDomains', 'davedoesthings-wsh' ),
			'desc'  => sprintf(
				/* translators: 1. opening anchor, closing anchor. */
				__( 'For more information about the Strict Transport Security header %1$sclick here%2$s.', 'davedoesthings-wsh' ),
				'<a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security" target="_blank">',
				'</a>'
			),
		],
		[
			'type'  => 'checkbox',
			'key'   => DATA_PREFIX . '_sts_enable',
			'label' => $status_label,
			'text'  => $enable_label,
		],
		[
			'type'  => 'textarea',
			'key'   => DATA_PREFIX . '_csp_value',
			'label' => esc_html__( 'Content Security Policy', 'davedoesthings-wsh' ),
			'text'  => esc_html__( 'Enter the VALUE for Content Security Policy e.g. default-src https:', 'davedoesthings-wsh' ),
			'desc'  => sprintf(
				/* translators: 1. opening anchor, closing anchor. */
				__( 'For more information about the Content Security Policy header %1$sclick here%2$s', 'davedoesthings-wsh' ),
				'<a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy" target="_blank">',
				'</a>'
			),
			'rows'  => 10,
		],
		[
			'type'  => 'checkbox',
			'key'   => DATA_PREFIX . '_csp_enable',
			'label' => $status_label,
			'text'  => $enable_label,
		],
		[
			'type'    => 'select',
			'key'     => DATA_PREFIX . '_xfo_value',
			'label'   => esc_html__( 'X Frame Options', 'davedoesthings-wsh' ),
			'desc'    => sprintf(
				/* translators: 1. opening anchor, closing anchor. */
				__( 'For more information about the X Frame Options header %1$sclick here%2$s', 'davedoesthings-wsh' ),
				'<a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options" target="_blank">',
				'</a>'
			),
			'options' => [
				''           => esc_html__( 'None', 'davedoesthings-wsh' ),
				// Remaining options should NOT be translatable.
				'deny'       => 'DENY',
				'sameorigin' => 'SAMEORIGIN',
			],
		],
		[
			'type'  => 'checkbox',
			'key'   => DATA_PREFIX . '_xfo_enable',
			'label' => $status_label,
			'text'  => $enable_label,
		],
		[
			'type'    => 'select',
			'key'     => DATA_PREFIX . '_xcto_value',
			'label'   => esc_html__( 'X Content Type Options', 'davedoesthings-wsh' ),
			'desc'    => sprintf(
				/* translators: 1. opening anchor, closing anchor. */
				__( 'For more information about the X Content Type Options header %1$sclick here%2$s', 'davedoesthings-wsh' ),
				'<a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options" target="_blank">',
				'</a>'
			),
			'options' => [
				''        => esc_html__( 'None', 'davedoesthings-wsh' ),
				// Remaining options should NOT be translatable.
				'nosniff' => 'nosniff',
			],
		],
		[
			'type'  => 'checkbox',
			'key'   => DATA_PREFIX . '_xcto_enable',
			'label' => $status_label,
			'text'  => $enable_label,
		],
		[
			'type'    => 'select',
			'key'     => DATA_PREFIX . '_rp_value',
			'label'   => esc_html__( 'Referrer Policy', 'davedoesthings-wsh' ),
			'desc'    => sprintf(
				/* translators: 1. opening anchor, closing anchor. */
				__( 'For more information about the Referrer-Policy header %1$sclick here%2$s', 'davedoesthings-wsh' ),
				'<a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy" target="_blank">',
				'</a>'
			),
			'options' => [
				''                                => esc_html__( 'None', 'davedoesthings-wsh' ),
				// Remaining options should NOT be translatable.
				'no-referrer'                     => 'no-referrer',
				'no-referrer-when-downgrade'      => 'no-referrer-when-downgrade',
				'origin'                          => 'origin',
				'origin-when-cross-origin'        => 'origin-when-cross-origin',
				'same-origin'                     => 'same-origin',
				'strict-origin'                   => 'strict-origin',
				'strict-origin-when-cross-origin' => 'strict-origin-when-cross-origin (the common default)',
				'unsafe-url'                      => 'unsafe-url',
			],
		],
		[
			'type'  => 'checkbox',
			'key'   => DATA_PREFIX . '_rp_enable',
			'label' => $status_label,
			'text'  => $enable_label,
		],
		[
			'type'  => 'textarea',
			'key'   => DATA_PREFIX . '_pp_value',
			'label' => esc_html__( 'Permissions Policy', 'davedoesthings-wsh' ),
			'text'  => esc_html__( 'Enter the VALUE for Permissions Policy e.g. default-src https:', 'davedoesthings-wsh' ),
			'desc'  => sprintf(
				/* translators: 1. opening anchor, closing anchor. */
				__( 'For more information about the Permissions Policy header %1$sclick here%2$s. This header is less common and has the lowest impact in terms of security, so do not populate and activate this header unless you have good reason to.', 'davedoesthings-wsh' ),
				'<a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Feature-Policy" target="_blank">',
				'</a>'
			),
			'rows'  => 10,
		],
		[
			'type'  => 'checkbox',
			'key'   => DATA_PREFIX . '_pp_enable',
			'label' => $status_label,
			'text'  => $enable_label,
		],
	];
}

/**
 * Register settings menu.
 *
 * @return void
 */
function register_settings_menu() : void {

	$label = esc_html__( 'Website Security Headers', 'davedoesthings-wsh' );

	add_submenu_page(
		'options-general.php',
		$label,
		$label,
		'manage_options',
		SETTINGS_KEY,
		'DAVEDOESTHINGS\WSH\Settings\render_settings_page'
	);
}

/**
 * Register settings page.
 *
 * @return void
 */
function register_settings_page() : void {

	$settings_whitelist = get_settings_whitelist();

	if ( empty( $settings_whitelist ) || ! is_array( $settings_whitelist ) ) {
		return;
	}

	add_settings_section(
		SETTINGS_SECTION_KEY,
		esc_html__( 'Settings', 'davedoesthings-wsh' ),
		'DAVEDOESTHINGS\WSH\Settings\render_settings_section',
		SETTINGS_KEY
	);

	foreach ( $settings_whitelist as $setting ) {

		register_setting( SETTINGS_KEY, $setting['key'] );

		add_settings_field(
			$setting['key'],
			$setting['label'],
			'DAVEDOESTHINGS\WSH\Settings\render_settings_field',
			SETTINGS_KEY,
			SETTINGS_SECTION_KEY,
			[
				'label_for' => $setting['key'],
				'key'       => $setting['key'],
				'type'      => $setting['type'],
				'text'      => ( isset( $setting['text'] ) ) ? $setting['text'] : '',
				'desc'      => ( isset( $setting['desc'] ) ) ? $setting['desc'] : '',
				'rows'      => ( isset( $setting['rows'] ) ) ? $setting['rows'] : '',
				'options'   => ( isset( $setting['options'] ) ) ? $setting['options'] : '',
			]
		);
	}
}

/**
 * Render the settings page.
 *
 * @return void
 */
function render_settings_page() : void {

	$sh_url = add_query_arg(
		[
			'q'               => home_url(),
			'followRedirects' => 'on',
		],
		'https://securityheaders.com'
	);
	?>

	<div class="wrap davedoesthings-wsh--wrap">

		<h1>
			<?php esc_html_e( 'Website Security Headers', 'davedoesthings-wsh' ); ?>
		</h1>

		<!-- Introduction -->
		<div class="card davedoesthings-wsh--card">

			<h2 class="title">
				<?php esc_html_e( 'Introduction', 'davedoesthings-wsh' ); ?>
			</h2>

			<p>
				<?php esc_html_e( 'The goal of this plugin is to provide website administrators and developers with the means to easily implement key security headers that can have a profound impact on the overall security of the website.', 'davedoesthings-wsh' ); ?>
			</p>

			<p>
				<?php esc_html_e( 'Robust website security is more important now than ever before, and the headers featured in this plugin are the most common that will be flagged in the results returned by security audits/scans and penetration tests.', 'davedoesthings-wsh' ); ?>
			</p>

			<p>
				<?php
				echo wp_kses(
					sprintf(
						/* translators: 1. opening anchor tag, 2. closing anchor tag, 3. opening anchor tag, 4. closing anchor tag */
						__( 'This plugin was created as a WordPress companion for the excellent %1$sSecurity Headers%2$s website run by renowned security researcher %3$sScott Helme%4$s. This plugin has no affiliation with Scott or his website, rather, this is a nod to his excellent work. Click the button below to see the current status of your report!', 'davedoesthings-wsh' ),
						'<a href="https://securityheaders.com" target="_blank">',
						'</a>',
						'<a href="https://scotthelme.co.uk" target="_blank">',
						'</a>'
					),
					KSES_ARGS
				);
				?>
			</p>

			<a 
			href="<?php echo esc_url( $sh_url ); ?>"
			class="button-secondary">
				<?php esc_html_e( 'View Your Security Headers Report', 'davedoesthings-wsh' ); ?>
			</a>

			<p>
				<?php
				echo wp_kses(
					sprintf(
						/* translators: 1. <strong>, 2. </strong> */
						__( '%1$sNOTE%2$s: the report on the Security Headers website will only work if this site is publicly accessible on the Internet.', 'davedoesthings-wsh' ),
						'<strong>',
						'</strong>'
					),
					KSES_ARGS
				);
				?>
			</p>

		</div>

		<!-- Settings -->
		<div class="card davedoesthings-wsh--card">

			<form 
			action="options-general.php?page=<?php echo esc_attr( SETTINGS_KEY ); ?>"
			method="POST"
			novalidate="novalidate"
			autocomplete="off">
				<?php
				settings_fields( SETTINGS_KEY );
				do_settings_sections( SETTINGS_KEY );
				?>

				<p class="davedoesthings-wsh--advisory">
					<?php
					echo wp_kses(
						sprintf(
							/* translators: 1. <strong>, 2. </strong> */
							__( '%1$sIMPORTANT%2$s: if improperly configured, or configured with no knowledge of the impact of your chosen values, these headers can have a negative impact on the functionality and usability of this website. Please make sure that you fully understand the consequences of implementing these headers before adding them. Where possible, test any changes to these headers on a staging/testing site, or during a low-traffic period on the live site.', 'davedoesthings-wsh' ),
							'<strong>',
							'</strong>'
						),
						KSES_ARGS
					);
					?>
				</p>

				<?php submit_button(); ?>
			</form>

		</div>

		<!-- Troubleshooting -->
		<div class="card davedoesthings-wsh--card">

			<h2 class="title">
				<?php esc_html_e( 'Troubleshooting', 'davedoesthings-wsh' ); ?>
			</h2>

			<p>
				<?php esc_html_e( 'If you are experiencing issues with confirming that these headers are being successfully generated on your site, here are a few helpful suggestions that should hopefully resolve them:', 'davedoesthings-wsh' ); ?>
			</p>

			<ol>
				<li>
					<?php esc_html_e( 'Your web browser and/or network may be caching these headers; clearing either of these caches and viewing your site in a private browsing session on a different device on a different nework may help.', 'davedoesthings-wsh' ); ?>
				</li>
				<li>
					<?php esc_html_e( 'It is possible that the webserver or hosting platform your site is hosted on is aggressively caching headers along with everything else; clearing the server cache may help and is a common cause of issues.', 'davedoesthings-wsh' ); ?>
				</li>
				<li>
					<?php esc_html_e( 'Your webserver may already be generating one or more of these headers via Apache or NGINX; check your webserver configuration for any conflicts and remove them.', 'davedoesthings-wsh' ); ?>
				</li>
			</ol>

			<p>
				<?php
				echo wp_kses(
					sprintf(
						/* translators: 1. <strong>, 2. </strong> */
						__( 'If you have attempted to resolve the issue using the above guidance and believe that the plugin may not be working as intended, please raise a bug report on %1$sGitHub%2$s.', 'davedoesthings-wsh' ),
						'<a href="https://github.com/davedoesthings/website-security-headers/issues/new">',
						'</a>'
					),
					KSES_ARGS
				);
				?>
			</p>
		</div>

	</div>

	<?php
}

/**
 * Save the settings as options and redirect back to the settings page.
 *
 * @return void
 */
function save_settings_options() : void {

	if (
		! isset( $_REQUEST['_wpnonce'] )
		|| ! isset( $_REQUEST['option_page'] )
		|| SETTINGS_KEY !== $_REQUEST['option_page']
		|| ! check_admin_referer( DATA_PREFIX . '_settings-options' )
		|| ! current_user_can( 'manage_options' )
		) {
		return;
	}

	$settings_whitelist = get_settings_whitelist();

	if ( ! empty( $settings_whitelist ) && is_array( $settings_whitelist ) ) {

		$header_settings = [];

		foreach ( $settings_whitelist as $s ) {

			$key = $s['key'];

			if ( isset( $_REQUEST['header_settings'][ $key ] ) ) {
				$header_settings[ $key ] = str_replace(
					'"',
					"'",
					sanitize_text_field( wp_unslash( $_REQUEST['header_settings'][ $key ] ) )
				);
			} else {
				$header_settings[ $key ] = '';
			}
		}

		// Update the individual settings consumed by the settings page.
		foreach ( $header_settings as $k => $hs ) {
			update_option(
				$k,
				$hs,
			);
		}

		// Update the setting consumed when the headers are output.
		update_option(
			DATA_PREFIX . '_header_settings',
			$header_settings,
		);

		$updated = true;
	} else {
		$updated = false;
	}

	wp_safe_redirect(
		add_query_arg(
			[
				'page'    => SETTINGS_KEY,
				'updated' => $updated,
			],
			admin_url( 'options-general.php' )
		)
	);

	exit;
}

/**
 * Render the settings section.
 *
 * @return void
 */
function render_settings_section() : void {
	?>

	<p>
		<?php
		echo wp_kses(
			sprintf(
				/* translators: 1. <em>, 2. </em> */
				__( 'Below you will find two settings relating to each of the security headers that can be generated by this plugin; one to determine the value of the header, and another to control whether or not the header should be generated. In addition, the first setting, %1$sGlobal Status%2$s, can be used to enable/disable the generation of all headers added by this plugin, regardless of whether they have been enabled in their respective sections below.', 'davedoesthings-wsh' ),
				'<em>',
				'</em>'
			),
			KSES_ARGS
		);
		?>
	</p>

	<p class="davedoesthings-wsh--advisory">
		<?php
		echo wp_kses(
			sprintf(
				/* translators: 1. <strong>, 2. </strong> */
				__( '%1$sIMPORTANT%2$s: if improperly configured, or configured with no knowledge of the impact of your chosen values, these headers can have a negative impact on the functionality and usability of this website. Please make sure that you fully understand the consequences of implementing these headers before adding them. Where possible, test any changes to these headers on a staging/testing site, or during a low-traffic period on the live site.', 'davedoesthings-wsh' ),
				'<strong>',
				'</strong>'
			),
			KSES_ARGS
		);
		?>
	</p>

	<?php
}

/**
 * Render a settings field
 *
 * @param array $args Field arguments.
 *
 * @return void
 */
function render_settings_field( $args ) : void {

	if ( ! isset( $args['type'] ) || ! isset( $args['key'] ) ) {
		return;
	}

	$setting_data = get_option( $args['key'] );

	echo '<div class="davedoesthings-wsh--field">';

	switch ( $args['type'] ) {
		case 'checkbox':
			?>

			<input
			class="davedoesthings-wsh--input"
			id="<?php echo esc_attr( $args['key'] ); ?>"
			type="checkbox"
			name="header_settings[<?php echo esc_attr( $args['key'] ); ?>]"
			<?php echo ( 'on' === $setting_data ) ? ' checked' : ''; ?>
			/>

			<?php
			echo esc_html( $args['text'] );

			break;
		case 'textarea':
			?>

			<textarea
			class="davedoesthings-wsh--input"
			id="<?php echo esc_attr( $args['key'] ); ?>"
			type="text"
			name="header_settings[<?php echo esc_attr( $args['key'] ); ?>]"
			placeholder="<?php echo esc_attr( $args['text'] ); ?>"
			rows="<?php echo ( $args['rows'] ) ? esc_attr( $args['rows'] ) : 2; ?>"
			><?php echo ( $setting_data ) ? esc_html( $setting_data ) : ''; ?></textarea>

			<?php
			break;
		case 'select':
			if ( $args['options'] ) {
				?>

				<select
				class="davedoesthings-wsh--input"
				id="<?php echo esc_attr( $args['key'] ); ?>"
				name="header_settings[<?php echo esc_attr( $args['key'] ); ?>]"
				>
					<?php
					foreach ( $args['options'] as $k => $v ) {
						$selected = ( $k === $setting_data ) ? ' selected' : '';
						echo '<option value="' . esc_attr( $k ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $v ) . '</option>';
					}
					?>
				</select>

				<?php
			}
			break;
		default:
			break;
	}

	echo '</div>';

	if ( $args['desc'] ) {
		echo '<p class="davedoesthings-wsh--desc">' . wp_kses( $args['desc'], KSES_ARGS ) . '</p>';
	}
}
