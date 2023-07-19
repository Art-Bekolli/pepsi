<?php


/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * custom option and settings
 */




 add_action( 'post_submitbox_misc_actions', 'custom_button' );

function custom_button(){
	echo "<br>Emri dhe Mbiemri: " . get_post_meta(get_the_ID(), 'user_submit_name')[0];
	echo "<br>Numri i Telefonit: " . get_post_meta(get_the_ID(), 'num_custom_field')[0];
	echo "<br>Email: " . get_post_meta(get_the_ID(), 'email_custom_field')[0];
}

function wporg_settings_init() {
	// Register a new setting for "wporg" page.
	register_setting( 'wporg', 'wporg_options' );

	// Register a new section in the "wporg" page.
	add_settings_section(
		'wporg_section_developers',
		__( 'Gjenerimi automatik i fituesit', 'wporg' ), 'wporg_section_developers_callback',
		'wporg'
	);

	// Register a new field in the "wporg_section_developers" section, inside the "wporg" page.
	add_settings_field(
		'wporg_field_pill', // As of WP 4.6 this value is used only internally.
		                        // Use $args' label_for to populate the id inside the callback.
			__( '', 'wporg' ),
		'wporg_field_pill_cb',
		'wporg',
		'wporg_section_developers',
		array(
			'label_for'         => 'wporg_field_pill',
			'class'             => 'wporg_row',
			'wporg_custom_data' => 'custom',
		)
	);
}

/**
 * Register our wporg_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'wporg_settings_init' );


/**
 * Custom option and settings:
 *  - callback functions
 */


/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function wporg_section_developers_callback( $args ) {
	?>
	<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( '', 'wporg' ); ?></p>
	<?php
}

/**
 * Pill field callbakc function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function wporg_field_pill_cb( $args ) {
	// Get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	?>
	
	<?php
}

/**
 * Add the top level menu page.
 */
function wporg_options_page() {
	add_menu_page(
		'Zgjidh',
		'Zgjidhe fituesin',
		'manage_options',
		'wporg',
		'wporg_options_page_html'
	);
}


/**
 * Register our wporg_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'wporg_options_page' );


/**
 * Top level menu callback function
 */
function wporg_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// add error/update messages

	// check if the user have submitted the settings
	// WordPress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		header("Refresh:0");
	}

	// show error/update messages
	settings_errors( 'wporg_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form class="random-form" action="options.php" method="post">
			<?php
			// output security fields for the registered setting "wporg"
			settings_fields( 'wporg' );
			// output setting sections and their fields
			// (sections are registered for "wporg", each field is registered to a specific section)
			do_settings_sections( 'wporg' );
			// output save settings button

						//Create WordPress Query with 'orderby' set to 'rand' (Random)
			$the_query = new WP_Query( array ( 'orderby' => 'rand', 'post_status' => array('publish'), 'posts_per_page' => '1' ) );
			// output the random post
			while ( $the_query->have_posts() ) : $the_query->the_post();
			    echo '<div class="random">';
			    echo 'Qyteti: '.get_the_title();		
				echo "<br>Emri dhe Mbiemri: " . get_post_meta(get_the_ID(), 'user_submit_name')[0];
				echo "<br>Numri i Telefonit: " . get_post_meta(get_the_ID(), 'num_custom_field')[0];
				echo "<br>Email: " . get_post_meta(get_the_ID(), 'email_custom_field')[0];
				echo "<br><img src= '" .  get_the_post_thumbnail_url(get_the_ID()) . "' >";
			    echo '</div>';
			endwhile;

			// Reset Post Data
			wp_reset_postdata();


			submit_button( 'Rigjeneroni postin' );



			
			?>

			
       

		</form>
	</div>
	<?php
}
/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__ . '/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__) . '/config/assets.php',
            'theme' => require dirname(__DIR__) . '/config/theme.php',
            'view' => require dirname(__DIR__) . '/config/view.php',
        ]);
    }, true);

// IMAGE SIZES
add_image_size('big', 2560, 999999);

function limit($value, $limit = 100, $end = '...')
{
    if (mb_strlen($value) <= $limit) return $value;
    return mb_substr($value, 0, $limit) . $end;
}

function fix_post_id_on_preview($null, $post_id)
{
    if (is_preview()) {
        return get_the_ID();
    }
}
add_filter('acf/pre_load_post_id', 'fix_post_id_on_preview', 10, 2);


 add_action( 'publish_post', 'send_notification' );
function send_notification( $post_id ) {    
        $post     = get_post($post_id);
        //$post_url = get_permalink( $post_id );
        $post_title = get_the_title( $post_id ); 
        $author   = get_userdata($post->post_author);
        $subject  = 'Urime, keni hyre ne loje shperblyese!';
        $message  = "Kuponi juaj: ".$post_title." Ka hyre ne loje.";
        wp_mail(get_post_meta($post_id, 'email_custom_field'), $subject, $message );  
}

function my_wp_trash_post( $post_id ) {

    $post     = get_post($post_id);
        //$post_url = get_permalink( $post_id );
        $post_title = get_the_title( $post_id ); 
        $author   = get_userdata($post->post_author);
        $subject  = 'Hyrja nuk ju pranua.';
        $message  = "Ju kerkojme falje, por hyrja juaj me numrin: ".$post_title." nuk eshte pranuar ne loje.";
        wp_mail(get_post_meta($post_id, 'email_custom_field'), $subject, $message );  
}
 add_action( 'wp_trash_post', 'my_wp_trash_post' );

function uploadimaeg($image_url)
		{ // upload foto ne server, dhe kthe id te fotos

			// it allows us to use download_url() and wp_handle_sideload() functions
			require_once(ABSPATH . 'wp-admin/includes/file.php');

			// download to temp dir
			$temp_file = download_url($image_url);

			if (is_wp_error($temp_file)) {
				return false;
			}

			// move the temp file into the uploads directory
			$file = array(
				'name'     => basename($image_url),
				'type'     => mime_content_type($temp_file),
				'tmp_name' => $temp_file,
				'size'     => filesize($temp_file),
			);
			$sideload = wp_handle_sideload(
				$file,
				array(
					'test_form'   => false // no needs to check 'action' parameter
				)
			);

			if (!empty($sideload['error'])) {
				// you may return error message if you want
				return false;
			}

			// it is time to add our uploaded image into WordPress media library
			$attachment_id = wp_insert_attachment(
				array(
					'guid'           => $sideload['url'],
					'post_mime_type' => $sideload['type'],
					'post_title'     => basename($sideload['file']),
					'post_content'   => '',
					'post_status'    => 'inherit',
				),
				$sideload['file']
			);

			if (is_wp_error($attachment_id) || !$attachment_id) {
				return false;
			}

			// update medatata, regenerate image sizes
			require_once(ABSPATH . 'wp-admin/includes/image.php');

			wp_update_attachment_metadata(
				$attachment_id,
				wp_generate_attachment_metadata($attachment_id, $sideload['file'])
			);
			$image = wp_get_image_editor(wp_get_original_image_path($attachment_id));
			if (!is_wp_error($image)) {
				$image->resize(512, 512, true);
				$image->save(wp_get_original_image_path($attachment_id));
			}
			return $attachment_id;
		}

		