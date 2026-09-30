<?php
require __DIR__ . '/compatibility-test.php';
$admin = false; $current_id = 14;
$fixture = '<div class="outer"><div data-interaction-id="3cfaced7" class="e-div-block-base"><span data-interaction-id="1461f8a0">An engagement may be</span><span data-interaction-id="19408f7c" title="a > b">A <em>native</em> <span>editable</span> description &amp; du’a.<br><!-- untouched --></span></div><span data-interaction-id="597598f8">350+</span><script>const x = "<span>not markup</span>";</script></div>';
$expected = str_replace(array('<div data-interaction-id="3cfaced7"','<span data-interaction-id="1461f8a0"','may be</span>','<span data-interaction-id="19408f7c"','untouched --></span></div>','<span data-interaction-id="597598f8"','350+</span>'), array('<dl data-interaction-id="3cfaced7"','<dt data-interaction-id="1461f8a0"','may be</dt>','<dd data-interaction-id="19408f7c"','untouched --></dd></dl>','<strong data-interaction-id="597598f8"','350+</strong>'), $fixture);
$result = AnnieYahayaSite\source_semantics($fixture);
check($result === $expected, 'Only paired wrapper names change; all content, inline tags, attributes and script bytes preserved');
check(AnnieYahayaSite\source_semantics($result) === $result, 'Semantic filter is idempotent');
$edited = str_replace('description &amp;', 'new saved wording &amp;', $fixture);
check(AnnieYahayaSite\source_semantics($edited) === str_replace('description &amp;', 'new saved wording &amp;', $expected), 'New native widget text remains authoritative');
$unmapped = '<span data-interaction-id="new-duplicate-id">Copied description</span>';
check(AnnieYahayaSite\source_semantics($unmapped) === $unmapped, 'Duplicated elements with new IDs are not mapped');
$wrong_tag = '<p data-interaction-id="19408f7c">Manually changed widget type</p>';
check(AnnieYahayaSite\source_semantics($wrong_tag) === $wrong_tag, 'Unexpected native tags remain unchanged');
$broken = '<div data-interaction-id="3cfaced7"><span data-interaction-id="19408f7c">Incomplete';
check(AnnieYahayaSite\source_semantics($broken) === $broken, 'Incomplete mapped structures fail closed');
$duplicates = '<span data-interaction-id="19408f7c">A</span><span data-interaction-id="19408f7c">B</span>';
check(AnnieYahayaSite\source_semantics($duplicates) === $duplicates, 'Ambiguous duplicate recorded IDs fail closed');
foreach (array(3, 15, 11) as $current_id) {
    check(AnnieYahayaSite\source_semantics($fixture) === $fixture, 'No Home mappings on page ' . $current_id);
}
$current_id = 14; $admin = true;
check(AnnieYahayaSite\source_semantics($fixture) === $fixture, 'Admin output unchanged');
$admin = false; $options[AnnieYahayaSite\OPTION] = array('home'=>99,'catalogue'=>15);
check(AnnieYahayaSite\source_semantics($fixture) === $fixture, 'Recorded page must also be configured in plugin');
