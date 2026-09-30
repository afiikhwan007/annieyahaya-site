# Annie Yahaya website — Elementor build

## Current stage

**Pilot and Why I build approved; semantic adapter 0.2.1 awaiting owner installation (29 September 2026).** Work with Annie, including Evidence in real rooms, is saved on Home 14 as 61 native editable elements. The owner approved recorded-ID semantic wrapper filtering. Local parser tests pass, including all 13 mappings against the actual Elementor-rendered DOM. Live installation, native IDs, an editor text-save test and visual comparison remain pending. See [0.2.1 installation handoff](docs/PLUGIN_0.2.1.md). Checkpoint 1 is incomplete; later sections, photos and Catalogue remain pending.

**0.2.0 installed and pilot ready for owner review (29 September 2026).** The three native Elementor IDs are saved. Fresh signed-out previews pass mobile-menu and horizontal-overflow checks at 375/768/1280/1440; measured pilot geometry matches the reference at all four widths. Expected font families are present and Roboto stylesheets absent. See the [current pilot review and section comparisons](qa/pilot-v020/PILOT_REVIEW.md) for evidence and screenshot limitations. Both pages remain Canvas drafts. Await approval before further sections or publication.

Pilot created on 28 September 2026. Home draft **14** contains header, hero and thread artwork. Catalogue draft **15** has slug **creations** and remains empty. The active plugin is configured with those IDs. Nothing is published; homepage selection remains unchanged. The [original pilot review](qa/pilot/PILOT_REVIEW.md) is historical pre-fix evidence.

The restructure and foundation commits are synced to GitHub main as `f46a6a1` and `7fd4fd6`, with trees matching the original local commits. Reference/photo/PDF blobs are unchanged. The supplied decisions attachment matches the committed root `PHASE_1_DECISIONS.md`; no duplicate or empty commit is needed.

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
4. Current installation is active. Settings → Annie Yahaya Site contains Home **14** and Catalogue **15**.
5. Saving these IDs does not publish or select the homepage. The owner installed compatibility version 0.2.0, verified active on 29 September 2026.

One option, `annie_yahaya_site_page_ids`, stores `home` and `catalogue`. The plugin does not guess IDs from slugs. Duplicate IDs and non-page IDs are rejected.

## Plugin behaviour

### Semantic wrappers and editing

`wp-plugin/annie-yahaya-site/includes/semantic-map.php` is the single documented element ID → native/reference tag map. Version 0.2.1 records 13 Home mappings (three each of dl/dt/dd and four strong figures); Catalogue has none. The render filter requires both a configured page and literal page ID 14/15. It changes only paired tag names, preserving widget content and attributes. It does not write Elementor settings or use HTML widgets. Existing inline em/strong/br/span stay in native editable text.

**If Annie duplicates or deletes a mapped element, its replacement/new element will not receive the special tag. Structural changes must go through us so the mapping can be reviewed and updated.** Editing wording in the existing native widget retains its ID and mapping. A manually changed native tag is left untouched. The parser fails closed on malformed mapped structure or duplicate recorded IDs.

After installing 0.2.1, verify native paragraph `19408f7c` in page 14: edit its description, Save Draft, confirm the new wording renders as a dd, then restore the exact reference wording and Save Draft again. This live editor test is pending; local tests do not substitute for it.

- Exact reference Google Fonts URL, only on configured pages.
- Home CSS: neutraliser → generated scoped styles → scoped coaching → scoped creations → client-photos. Catalogue omits coaching.
- Original CSS, JS and artwork copied unchanged to assets/. Git attributes preserve LF source bytes across Windows checkouts.
- A single generic neutraliser removes atomic defaults before generated reference styles. It has no per-element patches. Photo styles are prepared, but placement remains pending.
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
- Editor opening/editability **passed** in the signed-in session: native heading Title, Tag and ID controls were accessible. No test content was changed.
- Page 8 and Privacy Policy were not changed. The disposable draft remains for the editor check.

LiteSpeed CSS/JS minify and combine are all OFF; no optimization setting was changed. An unintended toolbar action caused a global cache purge during pilot inspection, exceeding the page-only restriction. This was immediately disclosed; no further cache actions were taken. Details are in the pilot review.

## Form placement and editing

The MCP does not expose a Shortcode widget. During the full Home build, leave a labelled empty container at `#begin` → `.begin-grid`, second column beside `.begin-promise`. The owner should add exactly one Elementor **Shortcode** widget containing `[annie_enquiry_form]`. This is the planned location; the container does not exist yet.

Annie will edit headings, prose, links and images using native Elementor elements. Form markup lives in `templates/enquiry-form.html`; behaviour lives in `assets/script.js`. CSS and JS are supplied by the plugin rather than pasted into global Elementor code fields.

## Verification

PHP 8.3.35 lint passed. Isolated PHP checks passed for scoping, page routing, stylesheet order, exact form markup, homepage SEO, invalid ID rejection and original asset hashes. JavaScript checks passed for pilot menu interaction and loading the original Home script without duplicate handlers. Tests use WordPress API doubles, not a live installed plugin.

Installed 0.2.0 resolved the pilot CSS conflict; four-width pilot fidelity and Why I build are approved. Version 0.2.1 adds the semantic adapter and is awaiting owner installation. Full form browser QA and Lighthouse remain pending. Current pilot evidence is in `qa/pilot-v020/`; `qa/pilot/` records the historical pre-fix state. Full-page captures have documented stitching artifacts and are not acceptance evidence.

## Remaining gates

1. Owner installs 0.2.1 and signs in to the editor for the required native dd edit/save verification.
2. Finish Home sections, photos and Checkpoint 1 comparisons/checks; obtain owner approval.
3. Build Catalogue only after Checkpoint 1 approval, then Checkpoint 2 with both-page accessibility checks.
4. Keep both pages as drafts. Publishing, homepage assignment and cache actions are outside the current authorisation.

Thread artwork was uploaded as WebP media **30** with the reference alt text. Client photos remain untouched. No global colours/fonts/breakpoints were changed. Both pages use the approved Canvas template to avoid duplicate theme chrome.
