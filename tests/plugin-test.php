<?php
// Isolated WordPress API doubles: routing and output tests, not a live WP test.
define('ABSPATH', __DIR__);
$options = array(); $current_id = 0; $singular = true; $admin = false;
$styles = array(); $scripts = array(); $inline = array(); $errors = array();
function add_action(...$args) {}
function add_filter(...$args) {}
function add_shortcode(...$args) {}
function absint($v) { return abs((int)$v); }
function get_option($k, $default = false) { return $GLOBALS['options'][$k] ?? $default; }
function is_admin() { return $GLOBALS['admin']; }
function is_singular($type) { return $GLOBALS['singular']; }
function get_queried_object_id() { return $GLOBALS['current_id']; }
function plugins_url($path, $file) { return 'https://test.invalid/wp-content/plugins/annie-yahaya-site/' . $path; }
function wp_enqueue_style($handle, ...$args) { $GLOBALS['styles'][$handle] = $args; }
function wp_enqueue_script($handle, ...$args) { $GLOBALS['scripts'][$handle] = $args; }
function wp_add_inline_script($handle, $code, $position) { $GLOBALS['inline'][$handle] = $code; }
function wp_json_encode($v) { return json_encode($v); }
function add_query_arg($key, $value, $url) { return $url . '?' . urlencode($key) . '=' . urlencode($value); }
function esc_attr($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function get_permalink($id) { return 'https://test.invalid/?page_id=' . $id; }
function get_post_type($id) { return in_array($id, array(101, 102), true) ? 'page' : 'post'; }
function get_post_status($id) { return 'draft'; }
function add_settings_error(...$args) { $GLOBALS['errors'][] = $args; }
require __DIR__ . '/../wp-plugin/annie-yahaya-site/annie-yahaya-site.php';
function check($condition, $message) { if (!$condition) { throw new Exception($message); } echo "PASS: $message\n"; }
function reset_assets() { $GLOBALS['styles'] = $GLOBALS['scripts'] = $GLOBALS['inline'] = array(); }
function metadata() { ob_start(); AnnieYahayaSite\head_metadata(); return ob_get_clean(); }

AnnieYahayaSite\enqueue_assets();
check(!$styles && !$scripts && metadata() === '', 'Unconfigured installation has no frontend output');
$options[AnnieYahayaSite\OPTION] = array('home' => 101, 'catalogue' => 102);
$current_id = 3;
AnnieYahayaSite\enqueue_assets();
check(!$styles && !$scripts && metadata() === '' && AnnieYahayaSite\enquiry_form() === '', 'Unrelated page has no assets, SEO or form');
check(AnnieYahayaSite\document_title('Privacy Policy') === 'Privacy Policy', 'Unrelated title unchanged');
$current_id = 101;
AnnieYahayaSite\enqueue_assets();
check(array_keys($styles) === array('annie-fonts','annie-styles','annie-coaching','annie-creations','annie-elementor-resets','annie-client-photos'), 'Home stylesheet order matches reference plus extension styles');
check(isset($scripts['annie-home-loader']) && !isset($scripts['annie-catalogue']) && strpos($inline['annie-home-loader'], '/script.js?') !== false, 'Home selects only Home reference script');
$source = file_get_contents(__DIR__ . '/../reference/index.html');
preg_match('/<form\b[^>]*id="enquiry-form"[\s\S]*?<\/form>/', $source, $match);
check(AnnieYahayaSite\enquiry_form() === $match[0], 'Shortcode output is the exact reference form');
check(AnnieYahayaSite\enquiry_form() === '', 'Repeated shortcode avoids duplicate form IDs');
preg_match('/<title>(.*?)<\/title>/', $source, $title);
check(AnnieYahayaSite\document_title('other') === $title[1], 'Home title matches reference exactly');
$head = metadata();
check(strpos($head, 'property="og:image"') !== false && strpos($head, 'future-thread-mwc.png') !== false && substr_count($head, 'name="description"') === 1, 'Home emits description and thread-artwork OG metadata');
reset_assets(); $current_id = 102;
AnnieYahayaSite\enqueue_assets();
check(!isset($styles['annie-coaching']) && isset($scripts['annie-catalogue']) && !isset($scripts['annie-home-loader']), 'Catalogue excludes Home CSS/script');
check(metadata() === '' && in_array('catalogue-page', AnnieYahayaSite\body_classes(array()), true), 'Catalogue gets source body class and no Home SEO');
reset_assets(); $admin = true;
AnnieYahayaSite\enqueue_assets(); check(!$styles && !$scripts, 'Admin screens unaffected');
$admin = false; $singular = false;
check(AnnieYahayaSite\page_role() === '', 'Archives unaffected');
check(AnnieYahayaSite\sanitize_page_ids(array('home'=>101,'catalogue'=>101)) === $options[AnnieYahayaSite\OPTION] && count($errors) === 1, 'Duplicate IDs rejected');
check(AnnieYahayaSite\sanitize_page_ids(array('home'=>999,'catalogue'=>102)) === $options[AnnieYahayaSite\OPTION] && count($errors) === 2, 'Non-page IDs rejected');
foreach (array('styles.css','coaching.css','creations.css','script.js','page.js','future-thread-mwc.png') as $f) {
    check(hash_file('sha256', __DIR__ . '/../reference/' . $f) === hash_file('sha256', __DIR__ . '/../wp-plugin/annie-yahaya-site/assets/' . $f), 'Reference bytes preserved: ' . $f);
}
