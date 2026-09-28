const {test} = require('node:test');
const assert = require('node:assert/strict');
const postcss = require('postcss');
const {scopeCss, scopeSelector} = require('../scripts/scope-css.cjs');
test('grouped and functional selectors retain their meaning', () => {
  assert.equal(scopeSelector('.hero, nav a:is(:hover,:focus)'), 'body.annie-site .elementor .hero, body.annie-site .elementor nav a:is(:hover,:focus)');
});
test('root, document and catalogue body styles', () => {
  for (const [a,b] of [[':root',':root'],['body','body.annie-site'],['html','body.annie-site'],['html body','body.annie-site'],['body.dark .hero','body.annie-site.dark .elementor .hero'],['.catalogue-page','body.annie-site.catalogue-page']]) assert.equal(scopeSelector(a),b);
});
test('media and supports are traversed; animation steps and font declarations are preserved', () => {
  const out = scopeCss('@media(max-width:700px){.hero{display:grid}} @supports(display:grid){.x{gap:1px}} @keyframes turn{from{opacity:0}50%{opacity:.5}to{opacity:1}} @font-face{font-family:"X";src:url(x.woff2)}');
  assert.match(out,/body\.annie-site \.elementor \.hero/);
  assert.match(out,/@keyframes turn\{from\{opacity:0\}50%\{opacity:.5\}to\{opacity:1\}\}/);
  assert.match(out,/@font-face\{font-family:"X";src:url\(x.woff2\)\}/);
});
test('all declarations and rule order in the three sources are unchanged', () => {
  const fs=require('node:fs'), path=require('node:path');
  for(const file of ['styles.css','coaching.css','creations.css']) {
    const source=fs.readFileSync(path.join(__dirname,'../reference',file),'utf8');
    const declarations=css=>{const a=[];postcss.parse(css).walkDecls(d=>a.push([d.prop,d.value,d.important]));return a;};
    assert.deepEqual(declarations(scopeCss(source)),declarations(source));
  }
});
