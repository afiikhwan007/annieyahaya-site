/* Partial-draft guard. The reference script.js remains byte-for-byte unchanged. */
(() => {
  const required = ['.menu', '#nav', '#enquiry-form', '#interest', '#status', '#message-actions', '#email-annie', '#copy-message', '#year'];
  if (required.every(selector => document.querySelector(selector))) {
    const script = document.createElement('script');
    script.src = window.annieYahayaHomeScript;
    script.async = false;
    document.body.appendChild(script);
    return;
  }
  // The header/hero/artwork pilot deliberately has no form or footer yet.
  const menu = document.querySelector('.menu');
  const nav = document.querySelector('#nav');
  if (menu && nav) {
    menu.addEventListener('click', () => {
      menu.setAttribute('aria-expanded', String(nav.classList.toggle('open')));
    });
    nav.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
      nav.classList.remove('open');
      menu.setAttribute('aria-expanded', 'false');
    }));
  }
  const year = document.querySelector('#year');
  if (year) year.textContent = new Date().getFullYear();
})();
