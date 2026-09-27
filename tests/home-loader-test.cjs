const fs = require('fs');
const vm = require('vm');
const assert = require('assert/strict');
const code = fs.readFileSync(__dirname + '/../wp-plugin/annie-yahaya-site/assets/home-loader.js', 'utf8');
function run(complete) {
  const listeners = {}, classes = new Set(), menuAttributes = {}, appended = [];
  const menu = {addEventListener: (e, f) => listeners.menu = f, setAttribute: (k,v) => menuAttributes[k] = v};
  const nav = {classList: {toggle(k) { if(classes.has(k)) {classes.delete(k);return false;} classes.add(k);return true;}, remove: k => classes.delete(k)}, querySelectorAll: () => [{addEventListener: (e,f) => listeners.link=f}]};
  const year = {};
  const context = {window:{annieYahayaHomeScript:'https://test.invalid/script.js'},document:{querySelector(s) {if(s==='.menu')return menu;if(s==='#nav')return nav;if(s==='#year')return complete?year:null;return complete?{}:null;},createElement: () => ({}),body:{appendChild: el=>appended.push(el)}},Date};
  vm.runInNewContext(code, context);
  return {listeners,menuAttributes,appended,classes};
}
const pilot=run(false); assert.equal(pilot.appended.length,0); pilot.listeners.menu();assert.equal(pilot.menuAttributes['aria-expanded'],'true');pilot.listeners.link();assert.equal(pilot.menuAttributes['aria-expanded'],'false');
const full=run(true);assert.equal(full.appended.length,1);assert.equal(full.appended[0].src,'https://test.invalid/script.js');assert.equal(full.listeners.menu,undefined);
console.log('PASS: pilot menu opens/closes; complete Home loads unchanged script exactly once without duplicate handlers');
