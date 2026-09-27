const menu = document.querySelector('.menu');
const nav = document.querySelector('#nav');

menu.addEventListener('click', () => {
  const open = nav.classList.toggle('open');
  menu.setAttribute('aria-expanded', String(open));
});

nav.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => {
  nav.classList.remove('open');
  menu.setAttribute('aria-expanded', 'false');
}));

const enquiryForm = document.querySelector('#enquiry-form');
const interest = document.querySelector('#interest');
const status = document.querySelector('#status');
const messageActions = document.querySelector('#message-actions');
const emailAnnie = document.querySelector('#email-annie');
const copyMessage = document.querySelector('#copy-message');
const annieContactEmail = 'sheis@annieyahaya.com';
let preparedMessage = '';

document.querySelectorAll('[data-interest]').forEach((link) => {
  link.addEventListener('click', () => {
    interest.value = link.dataset.interest;
  });
});

enquiryForm.addEventListener('submit', (event) => {
  event.preventDefault();
  if (!enquiryForm.reportValidity()) return;

  const name = document.querySelector('#name').value.trim();
  const senderEmail = document.querySelector('#email').value.trim();
  const organisation = document.querySelector('#organisation').value.trim();
  const situation = document.querySelector('#situation').value.trim();
  const topic = interest.options[interest.selectedIndex].text;
  const organisationLine = organisation ? `\nOrganisation: ${organisation}` : '';

  preparedMessage = `Assalamualaikum Annie,\n\nI would like to begin a conversation about ${topic}.\n\nWhat is happening:\n${situation}\n\nName: ${name}\nEmail: ${senderEmail}${organisationLine}`;

  const subject = encodeURIComponent(`Conversation with Annie — ${topic}`);
  const body = encodeURIComponent(preparedMessage);
  messageActions.hidden = false;

  if (annieContactEmail) {
    emailAnnie.href = `mailto:${annieContactEmail}?subject=${subject}&body=${body}`;
    emailAnnie.hidden = false;
    status.textContent = 'Your message is ready. Open it in email or copy it.';
  } else {
    emailAnnie.hidden = true;
    status.textContent = 'Your message is ready. Copy it to send to Annie.';
  }
});

copyMessage.addEventListener('click', async () => {
  try {
    await navigator.clipboard.writeText(preparedMessage);
    status.textContent = 'Message copied.';
  } catch {
    status.textContent = preparedMessage;
  }
});

document.querySelector('#year').textContent = new Date().getFullYear();
