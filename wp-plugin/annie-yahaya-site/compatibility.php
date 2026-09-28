<?php
namespace AnnieYahayaSite;
if (!defined('ABSPATH')) { exit; }

/** Only these recorded native elements may receive source ARIA attributes.
 * IDs main/top/nav belong in Elementor General > ID, never injected here.
 * Catalogue is intentionally empty until its build is approved.
 */
function source_aria($html) {
    if (!page_role() || !in_array((int) get_queried_object_id(), array(14, 15), true)) {
        return $html;
    }
    $maps = array(
        14 => array(
            'd4617b3' => array('tag' => 'BUTTON', 'attributes' => array('aria-expanded' => 'false', 'aria-controls' => 'nav')),
            '282c8e1a' => array('tag' => 'NAV', 'attributes' => array('aria-label' => 'Main navigation')),
            '2a39dad0' => array('tag' => 'SECTION', 'attributes' => array('aria-label' => 'The thread running through Annie’s work')),
        ),
        15 => array(),
    );
    $map = $maps[(int) get_queried_object_id()];
    $arrows = (int) get_queried_object_id() === 14 ? array('29e9c792', '17887ea4') : array();
    $processor = new \WP_HTML_Tag_Processor($html);
    $arrow = false;
    while ($processor->next_tag(array('tag_closers' => 'visit'))) {
        $tag = $processor->get_tag();
        if ($processor->is_tag_closer()) {
            if ($tag === 'A') { $arrow = false; }
            continue;
        }
        $id = $processor->get_attribute('data-interaction-id');
        if (isset($map[$id]) && $tag === $map[$id]['tag']) {
            foreach ($map[$id]['attributes'] as $name => $value) { $processor->set_attribute($name, $value); }
        }
        if ($tag === 'A') { $arrow = in_array($id, $arrows, true); }
        if ($arrow && $tag === 'SPAN') {
            $processor->set_attribute('aria-hidden', 'true');
            $arrow = false; // Exact source arrow span only.
        }
    }
    return $processor->get_updated_html();
}
add_filter('elementor/frontend/the_content', __NAMESPACE__ . '\\source_aria', 20);

/** Match only Elementor-owned, single-family Roboto/Roboto Slab stylesheets. */
function unwanted_elementor_font($handle, $src) {
    if (strpos($handle, 'elementor-') !== 0) { return false; }
    // Elementor's locally hosted Google-font handles.
    if (preg_match('/^elementor-gf-(?:local-)?(?:roboto|robotoslab|roboto-slab)$/i', $handle)) { return true; }
    $parts = parse_url(html_entity_decode((string) $src, ENT_QUOTES, 'UTF-8'));
    if (strtolower($parts['host'] ?? '') !== 'fonts.googleapis.com') { return false; }
    preg_match_all('/(?:^|&)family=([^&]+)/', $parts['query'] ?? '', $matches);
    if (empty($matches[1])) { return false; }
    foreach ($matches[1] as $group) {
        foreach (explode('|', urldecode($group)) as $family) {
            $name = trim(explode(':', $family)[0]);
            if (!in_array($name, array('Roboto', 'Roboto Slab'), true)) { return false; }
        }
    }
    return true;
}

function dequeue_default_fonts() {
    if (!page_role() || !in_array((int) get_queried_object_id(), array(14, 15), true)) { return; }
    $styles = wp_styles();
    foreach ($styles->queue as $handle) {
        if (isset($styles->registered[$handle]) && unwanted_elementor_font($handle, $styles->registered[$handle]->src)) {
            wp_dequeue_style($handle);
        }
    }
}
add_action('wp_print_styles', __NAMESPACE__ . '\\dequeue_default_fonts', PHP_INT_MAX);
add_action('wp_footer', __NAMESPACE__ . '\\dequeue_default_fonts', 19);

// Elementor can enqueue a font late, while rendering the document. Keep the
// same narrow guard at the final print boundary; reference font links survive.
function filter_default_font_tag($html, $handle, $href) {
    return page_role() && in_array((int) get_queried_object_id(), array(14, 15), true) && unwanted_elementor_font($handle, $href) ? '' : $html;
}
add_filter('style_loader_tag', __NAMESPACE__ . '\\filter_default_font_tag', 20, 3);
