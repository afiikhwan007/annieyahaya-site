<?php
/**
 * Plugin Name: Annie Yahaya Site
 * Description: Page-scoped reference assets, enquiry shortcode and homepage metadata.
 * Version: 0.2.0
 * Requires at least: 6.8
 * Requires PHP: 7.4
 * Author: Annie Yahaya
 */

namespace AnnieYahayaSite;

if (!defined('ABSPATH')) {
    exit;
}

const VERSION = '0.2.0';
const OPTION = 'annie_yahaya_site_page_ids';

/** One option holds both IDs; zero means unconfigured and matches no page. */
function page_ids() {
    $ids = get_option(OPTION, array());
    $ids = is_array($ids) ? $ids : array();
    return array('home' => absint($ids['home'] ?? 0), 'catalogue' => absint($ids['catalogue'] ?? 0));
}

function page_role() {
    if (is_admin() || !is_singular('page')) {
        return '';
    }
    $id = (int) get_queried_object_id();
    $ids = page_ids();
    foreach ($ids as $role => $page_id) {
        if ($page_id > 0 && $id === $page_id) {
            return $role;
        }
    }
    return '';
}

function asset_url($file) {
    return plugins_url('assets/' . $file, __FILE__);
}

function asset_version($file) {
    $path = __DIR__ . '/assets/' . $file;
    return is_file($path) ? (string) filemtime($path) : VERSION;
}

function enqueue_assets() {
    $role = page_role();
    if (!$role) {
        return;
    }
    wp_enqueue_style('annie-fonts', 'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Libre+Caslon+Display&family=Manrope:wght@500;600;700&display=swap', array(), null);
    $files = array('elementor-neutraliser.css', 'scoped/styles.css');
    if ($role === 'home') {
        $files[] = 'scoped/coaching.css';
    }
    $files = array_merge($files, array('scoped/creations.css', 'client-photos.css'));
    $previous = 'annie-fonts';
    foreach ($files as $file) {
        $handle = 'annie-' . basename($file, '.css');
        wp_enqueue_style($handle, asset_url($file), array($previous), asset_version($file));
        $previous = $handle;
    }
    if ($role === 'home') {
        // The unchanged Home script expects the complete enquiry form. The pilot
        // loader handles menu/year while the partial draft has no form yet, then
        // loads script.js once all of its required nodes exist. It never loads page.js.
        wp_enqueue_script('annie-home-loader', asset_url('home-loader.js'), array(), asset_version('home-loader.js'), true);
        wp_add_inline_script('annie-home-loader', 'window.annieYahayaHomeScript = ' . wp_json_encode(add_query_arg('ver', asset_version('script.js'), asset_url('script.js'))) . ';', 'before');
    } else {
        wp_enqueue_script('annie-catalogue', asset_url('page.js'), array(), asset_version('page.js'), true);
    }
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets', 100);

function body_classes($classes) {
    $role = page_role();
    if ($role) {
        $classes[] = 'annie-site';
        $classes[] = 'annie-site-' . $role;
        if ($role === 'catalogue') {
            $classes[] = 'catalogue-page';
        }
    }
    return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_classes');

require_once __DIR__ . '/compatibility.php';

function enquiry_form() {
    if (page_role() !== 'home') {
        return '';
    }
    static $rendered = false;
    if ($rendered) {
        return ''; // Avoid duplicate IDs if a widget is inadvertently duplicated.
    }
    $rendered = true;
    return file_get_contents(__DIR__ . '/templates/enquiry-form.html');
}
add_shortcode('annie_enquiry_form', __NAMESPACE__ . '\\enquiry_form');

function home_meta() {
    static $meta;
    if ($meta === null) {
        $meta = json_decode(file_get_contents(__DIR__ . '/assets/home-meta.json'), true);
    }
    return $meta;
}

function document_title($title) {
    return page_role() === 'home' ? home_meta()['title'] : $title;
}
add_filter('pre_get_document_title', __NAMESPACE__ . '\\document_title', 100);

function head_metadata() {
    if (page_role() !== 'home') {
        return;
    }
    $meta = home_meta();
    echo '<meta name="description" content="' . esc_attr($meta['description']) . '">' . "\n";
    foreach (array('og:type' => 'website', 'og:title' => $meta['title'], 'og:description' => $meta['description'], 'og:image' => asset_url('future-thread-mwc.png'), 'og:image:alt' => 'A vivid green line crossing layered black and white paper', 'og:url' => get_permalink(get_queried_object_id())) as $property => $value) {
        echo '<meta property="' . esc_attr($property) . '" content="' . esc_attr($value) . '">' . "\n";
    }
}
add_action('wp_head', __NAMESPACE__ . '\\head_metadata', 5);

function sanitize_page_ids($input) {
    $input = is_array($input) ? $input : array();
    $ids = array('home' => absint($input['home'] ?? 0), 'catalogue' => absint($input['catalogue'] ?? 0));
    foreach ($ids as $id) {
        if ($id && (get_post_type($id) !== 'page' || in_array(get_post_status($id), array('trash', 'auto-draft'), true))) {
            add_settings_error(OPTION, 'invalid_page', 'Choose existing Home and Catalogue pages, or leave an ID at 0 until its draft exists.');
            return page_ids();
        }
    }
    if ($ids['home'] && $ids['home'] === $ids['catalogue']) {
        add_settings_error(OPTION, 'duplicate_page', 'Home and Catalogue must have different page IDs.');
        return page_ids();
    }
    return $ids;
}

function register_settings() {
    register_setting('annie_yahaya_site', OPTION, array('type' => 'array', 'sanitize_callback' => __NAMESPACE__ . '\\sanitize_page_ids', 'default' => array('home' => 0, 'catalogue' => 0), 'show_in_rest' => false));
}
add_action('admin_init', __NAMESPACE__ . '\\register_settings');

function settings_menu() {
    add_options_page('Annie Yahaya Site', 'Annie Yahaya Site', 'manage_options', 'annie-yahaya-site', __NAMESPACE__ . '\\settings_page');
}
add_action('admin_menu', __NAMESPACE__ . '\\settings_menu');

function settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
    $ids = page_ids();
    ?>
    <div class="wrap">
        <h1>Annie Yahaya Site</h1>
        <p>Enter the two draft page IDs after they are created. Zero disables that page's integration. This does not publish pages or change the homepage.</p>
        <?php settings_errors(); ?>
        <form action="options.php" method="post">
            <?php settings_fields('annie_yahaya_site'); ?>
            <table class="form-table" role="presentation">
                <?php foreach (array('home' => 'Home page ID', 'catalogue' => 'Catalogue page ID') as $role => $label) : ?>
                <tr>
                    <th scope="row"><label for="annie-<?php echo esc_attr($role); ?>"><?php echo esc_html($label); ?></label></th>
                    <td><input type="number" min="0" step="1" id="annie-<?php echo esc_attr($role); ?>" name="<?php echo esc_attr(OPTION); ?>[<?php echo esc_attr($role); ?>]" value="<?php echo esc_attr($ids[$role]); ?>"></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
