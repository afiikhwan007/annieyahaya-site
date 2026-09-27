# Annie Yahaya website reference

This package is a snapshot of the publicly served static files from https://annie-builds.annieyahaya.chatgpt.site/ retrieved on 27 September 2026. It is suitable as a GitHub repository and a starting reference for redevelopment in Codex.

## Contents

- `index.html` — homepage
- `creations.html` — complete body of work page
- `styles.css`, `coaching.css`, `creations.css` — styling
- `script.js`, `page.js` — menu, enquiry message, and footer interactions
- `future-thread-mwc.png` — image asset

## Run locally

From this folder, run `python3 -m http.server 8000` and open http://localhost:8000/ . There is no build step or package manager dependency.

## Notes for redevelopment

The original site loads Google Fonts externally. The enquiry form prepares an email message for the visitor to send or copy; it does not submit to a backend. This is a copy of files accessible through the published website, not an export of its Git history, unpublished project files, hosting configuration, or server-side secrets.
