# Annie Yahaya website — Elementor build

## Current stage

Phase 1 foundation package prepared on 28 September 2026. Home and Catalogue have not been created or published. Their page IDs remain unconfigured. The homepage remains latest posts. Next: owner plugin installation confirmation and editor check, followed by the header/hero/artwork pilot.

The local `Organise inputs into reference/photos/docs` commit uses `git mv`; moved source/photo/PDF blobs are unchanged. GitHub rejected writes with `403 Resource not accessible by integration`, so local commits are **not yet synced to main**. The supplied Git bundle preserves the complete history. The GitHub app needs Contents read/write access before syncing.

## Repository inputs

- `reference/`: original HTML, CSS, JS and thread image. Source behaviour wins over prose conflicts.
- `photos/`: seven client originals, including `Essence_of_Life_1.jpeg`.
- `docs/`: content handoff PDF. Design-tokens PDF is optional and not supplied.
- `CODEX_PROMPT.md`: attached Elementor brief.
- `PHASE_1_DECISIONS.md`: owner decisions and phase gates.
- `PHASE_0_REPORT.md`: historical discovery; root layout and PRO Elements status describe the earlier observation.
- `wp-plugin/annie-yahaya-site/`: plugin source.
- `dist/annie-yahaya-site.zip`: installable WordPress plugin.
- `tests/`: isolated PHP and JavaScript checks.
- `qa/mcp-render-test.png`: disposable native-element test, not the later pilot comparison.

Run the reference with `python -m http.server 8000 --directory reference`, then open http://localhost:8000/. The snapshot contains the original host's Cloudflare injection. Preserve the snapshot but omit that injection from WordPress.

## Install the plugin (owner action)

1. Take the requested full backup.
2. WordPress → Plugins → Add New Plugin → Upload Plugin.
3. Upload `dist/annie-yahaya-site.zip`, install and activate **Annie Yahaya Site**.
4. Leave Settings → Annie Yahaya Site → both page IDs at **0** until the two drafts exist. Activation alone has no front-end effect.
5. Confirm installation. We will create the drafts and provide their IDs for this screen. Saving these IDs does not publish or select the homepage.

One option, `annie_yahaya_site_page_ids`, stores `home` and `catalogue`. The plugin does not guess IDs from slugs. Duplicate IDs and non-page IDs are rejected.

## Plugin behaviour

- Exact reference Google Fonts URL, only on configured pages.
- Home CSS: styles → coaching → creations → elementor-resets → client-photos. Catalogue omits coaching.
- Original CSS, JS and artwork copied unchanged to assets/. Git attributes preserve LF source bytes across Windows checkouts.
- Resets are opt-in and documented; further fixes need pilot evidence. Photo styles are prepared, but placement remains pending.
- A small Home footer loader loads unchanged script.js once the full header/form/year DOM exists. On the partial pilot it supports available menu/year nodes without triggering missing-form errors. It never loads page.js on Home. Catalogue loads only page.js.
- `[annie_enquiry_form]` returns the exact source form once on configured Home only. No server submission; original behaviour prepares a message then offers Open in email and Copy message.
- Home title, description and OG tags use exact reference copy and packaged artwork.
- Privacy Policy, archives, admin screens and unconfigured pages receive no plugin assets, metadata or form output.
- Activation does not redirect, suppress fonts globally, clear caches, switch themes, create pages or publish anything.

## Elementor setup and test

Hello Elementor 3.5.1; Elementor 4.3.2; Containers active. PRO Elements is now inactive. Disable Default Colors and Disable Default Fonts now both read `yes`. These settings changed outside this agent's work; no experiment was switched by the agent.

Authorised disposable draft: **MCP test — delete me**, ID **11**.

- Editor: https://aqua-jaguar-251427.hostingersite.com/wp-admin/post.php?post=11&action=elementor
- Logged-in preview: https://aqua-jaguar-251427.hostingersite.com/?page_id=11&preview_id=11&preview=true
- Native e-flexbox and e-heading render on a signed snapshot, including italic markup and local styles.
- Editor access redirected to WordPress login. Editor opening/editability is **not verified**. Please open this draft in your logged-in editor and confirm the container/heading are editable; do not publish it.
- Page 8 and Privacy Policy were not changed. The disposable draft remains for the editor check.

No cache was purged or LiteSpeed settings changed. The screenshot used a new signed draft snapshot rather than a previously cached published page. Inspect minify/combine and perform only page-scoped purges before actual pilot/QA screenshots.

## Form placement and editing

The MCP does not expose a Shortcode widget. During the full Home build, leave a labelled empty container at `#begin` → `.begin-grid`, second column beside `.begin-promise`. The owner should add exactly one Elementor **Shortcode** widget containing `[annie_enquiry_form]`. This is the planned location; the container does not exist yet.

Annie will edit headings, prose, links and images using native Elementor elements. Form markup lives in `templates/enquiry-form.html`; behaviour lives in `assets/script.js`. CSS and JS are supplied by the plugin rather than pasted into global Elementor code fields.

## Verification

PHP 8.3.35 lint passed. Isolated PHP checks passed for scoping, page routing, stylesheet order, exact form markup, homepage SEO, invalid ID rejection and original asset hashes. JavaScript checks passed for pilot menu interaction and loading the original Home script without duplicate handlers. Tests use WordPress API doubles, not a live installed plugin.

The ZIP needs installation and live WordPress integration testing. Four-width fidelity, full form browser QA and Lighthouse remain pending.

## Remaining gates

1. Restore GitHub integration write access and sync saved commits.
2. Owner installs plugin and confirms test draft editor access.
3. Create Home/Catalogue drafts and configure their IDs.
4. Build header + hero + artwork only; compare 375/768/1280/1440px and wait for pilot approval.
5. Complete sections, catalogue, photo optimisation/upload, CONTENT_DIFF.md and full QA.
6. Await explicit publish confirmation before publication, homepage assignment and authorised cache regeneration.

No media was uploaded. No photo placement is completed or skipped yet. No global colours/fonts/breakpoints were changed by the agent.
