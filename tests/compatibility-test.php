<?php
require __DIR__ . '/plugin-test.php';
$singular = true; $admin = false;
$options[AnnieYahayaSite\OPTION] = array('home'=>14,'catalogue'=>15);
$current_id = 14;
check(AnnieYahayaSite\unwanted_elementor_font('elementor-gf-roboto', 'https://fonts.googleapis.com/css?family=Roboto:400'), 'Roboto CDN handle detected');
check(AnnieYahayaSite\unwanted_elementor_font('elementor-gf-local-robotoslab', '/wp-content/uploads/elementor/google-fonts/css/robotoslab.css'), 'Roboto Slab local handle detected');
check(!AnnieYahayaSite\unwanted_elementor_font('annie-fonts', 'https://fonts.googleapis.com/css?family=Roboto'), 'Non-Elementor handles preserved');
check(!AnnieYahayaSite\unwanted_elementor_font('elementor-other', 'https://fonts.googleapis.com/css?family=Roboto%7CDM+Sans'), 'Mixed-family stylesheet never discarded');
check(!AnnieYahayaSite\unwanted_elementor_font('elementor-gf-dmsans', 'https://fonts.googleapis.com/css?family=DM+Sans'), 'Reference font preserved');
check(AnnieYahayaSite\filter_default_font_tag('<link>', 'elementor-gf-roboto', '') === '', 'Late target font output blocked');
$current_id = 3;
check(AnnieYahayaSite\filter_default_font_tag('<link>', 'elementor-gf-roboto', '') === '<link>', 'Other pages retain fonts');
check(AnnieYahayaSite\source_aria('<nav data-interaction-id="282c8e1a"></nav>') === '<nav data-interaction-id="282c8e1a"></nav>', 'Other pages retain markup');
function wp_styles() { return $GLOBALS['style_registry']; }
function wp_dequeue_style($handle) { $GLOBALS['dequeued'][] = $handle; }
$style_registry = (object) array('queue'=>array('elementor-gf-roboto','annie-fonts'), 'registered'=>array('elementor-gf-roboto'=>(object)array('src'=>'https://fonts.googleapis.com/css?family=Roboto'), 'annie-fonts'=>(object)array('src'=>'https://fonts.googleapis.com/css?family=DM+Sans')));
$dequeued = array();
AnnieYahayaSite\dequeue_default_fonts();
check(!$dequeued, 'No dequeue on unrelated page');
$current_id = 15;
AnnieYahayaSite\dequeue_default_fonts();
check($dequeued === array('elementor-gf-roboto'), 'Catalogue dequeues only the unwanted Elementor font');
check(in_array('annie-site', AnnieYahayaSite\body_classes(array()), true) && in_array('annie-site-catalogue', AnnieYahayaSite\body_classes(array()), true), 'Both scoping classes present on Catalogue');

// Use the real WordPress HTML parser, not a parser double. Set WP_HTML_API_DIR
// to wp-includes/html-api in a local WordPress 6.8+ source checkout.
$api = getenv('WP_HTML_API_DIR');
if (!$api) { throw new Exception('Set WP_HTML_API_DIR for actual parser integration tests'); }
foreach (array('class-wp-html-decoder.php','class-wp-html-attribute-token.php','class-wp-html-span.php','class-wp-html-text-replacement.php','class-wp-html-tag-processor.php') as $file) { require_once $api . '/' . $file; }
function wp_kses_uri_attributes() { return array('href','src'); }
function _doing_it_wrong($function, $message, $version) { throw new Exception($message); }
$current_id = 14;
$fixture = '<nav data-interaction-id="282c8e1a"></nav><button data-interaction-id="d4617b3">Menu</button><a data-interaction-id="29e9c792">I want Annie involved <span>→</span></a><span>Keep me</span><nav data-interaction-id="other"></nav>';
$result = AnnieYahayaSite\source_aria($fixture);
check(strpos($result, 'aria-label="Main navigation"') !== false && strpos($result, 'aria-controls="nav"') !== false && strpos($result, 'aria-expanded="false"') !== false, 'Actual parser adds source navigation ARIA');
check(substr_count($result, 'aria-hidden="true"') === 1 && strpos($result, '<span>Keep me</span>') !== false, 'Only the recorded arrow is hidden');
check(strpos($result, '<nav data-interaction-id="other"></nav>') !== false, 'Unrecorded elements remain unchanged');
check(AnnieYahayaSite\source_aria($result) === $result, 'Render filtering is idempotent');
$current_id = 15;
check(AnnieYahayaSite\source_aria($fixture) === $fixture, 'Home element IDs never affect Catalogue');
$current_id = 14; $admin = true;
check(AnnieYahayaSite\source_aria($fixture) === $fixture, 'Admin markup is unaffected');
