<?php
namespace AnnieYahayaSite;
if (!defined('ABSPATH')) { exit; }

/** Obtain token boundaries through the HTML API's protected bookmark spans.
 * No DOM serialisation: replacement touches only opening/closing tag names.
 */
final class Semantic_Tag_Processor extends \WP_HTML_Tag_Processor {
    public function token_start() {
        if (!$this->set_bookmark('annie_token')) { return null; }
        $offset = $this->bookmarks['annie_token']->start;
        $this->release_bookmark('annie_token');
        return $offset;
    }
}

function replace_semantic_wrappers($html, $map) {
    $parser = new Semantic_Tag_Processor($html);
    $stack = array(); $edits = array(); $seen = array();
    $void = array('AREA','BASE','BR','COL','EMBED','HR','IMG','INPUT','LINK','META','PARAM','SOURCE','TRACK','WBR');
    // The Tag Processor consumes these complete elements as single tokens.
    $opaque = array('SCRIPT','STYLE','TEXTAREA','TITLE','IFRAME','NOEMBED','NOFRAMES','XMP');
    $allowed = array('ul','ol','li','dl','dt','dd','article','section','figure','figcaption','blockquote','aside','time','address','em','strong','span');
    while ($parser->next_tag(array('tag_closers' => 'visit'))) {
        $tag = $parser->get_tag();
        $start = $parser->token_start();
        if ($start === null) { return $html; }
        if ($parser->is_tag_closer()) {
            $open = array_pop($stack);
            // Fail closed on unexpected/optional closing structure.
            if (!$open || $open['tag'] !== $tag) { return $html; }
            if ($open['target']) {
                $edits[] = array($open['start'] + 1, strlen($tag), $open['target']);
                $edits[] = array($start + 2, strlen($tag), $open['target']);
            }
            continue;
        }
        $id = $parser->get_attribute('data-interaction-id');
        $target = null;
        if (is_string($id) && isset($map[$id]) && strtolower($tag) === $map[$id][0]) {
            if (isset($seen[$id]) || !in_array($map[$id][1], $allowed, true)) { return $html; }
            $seen[$id] = true;
            $target = $map[$id][1];
        }
        if (in_array($tag, $void, true) || in_array($tag, $opaque, true) || $parser->has_self_closing_flag()) {
            if ($target) { return $html; }
            continue;
        }
        $stack[] = array('tag' => $tag, 'start' => $start, 'target' => $target);
    }
    foreach ($stack as $open) { if ($open['target']) { return $html; } }
    usort($edits, function ($a, $b) { return $b[0] <=> $a[0]; });
    foreach ($edits as $edit) { $html = substr_replace($html, $edit[2], $edit[0], $edit[1]); }
    return $html;
}
