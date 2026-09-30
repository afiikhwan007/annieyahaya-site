# Annie Yahaya — build instructions
## Goal and scope
- Reproduce reference/index.html and reference/creations.html, exact wording/layout.
- Home is draft page 14; Catalogue is draft page 15, slug /creations/.
- Both use approved Elementor Canvas, with native per-page header/footer.
- Pilot and Why I build are approved. Continue existing trees; do not duplicate them.
- Repository restructure and foundation plugin are complete; do not redo them.
- Reference files are immutable. Source wins over the brief/PDF; no redesign.
- Design-tokens PDF is optional. Omit Cloudflare injection from WordPress only.
- No catalogue filters/overlay or /creations.html redirect: source has neither.
## Plugin architecture
- Runtime root: wp-plugin/annie-yahaya-site/; owner installs plugin updates.
- Page IDs live in plugin option annie_yahaya_site_page_ids (home=14, catalogue=15).
- Body classes: annie-site plus annie-site-home / annie-site-catalogue.
- Keep original reference asset copies byte-for-byte unchanged.
- scripts/scope-css.cjs generates CSS scoped to body.annie-site .elementor.
- Handle html/body/:root and keyframes/font-face correctly; do not hand-edit output.
- One generic elementor-neutraliser.css loads before generated scoped CSS.
- Home loads styles/coaching/creations; Catalogue loads styles/creations.
- Only reference DM Sans, Libre Caslon Display and Manrope fonts.
- Dequeue Elementor Roboto/Roboto Slab only on pages 14/15.
- Home script.js and Catalogue page.js are mutually exclusive.
- Home loader supports partial builds; preserve source form and footer-year behavior.
- Shortcode [annie_enquiry_form] outputs exact source form: prepare, email, copy.
- Home SEO metadata uses exact reference title/description; no SEO plugin needed.
- Small per-element fixes now approved ONLY in assets/overrides.css, body.annie-site scoped.
- Comment every override with section and reason; never alter reference CSS.
- Photo CSS stays in assets/client-photos.css under /* CLIENT PHOTOS */.
## Native editing and semantic mapping
- Keep text in native editable widgets, with literal reference classes and IDs.
- Native General > ID supplies source IDs. Use recorded-ID filters for source ARIA.
- includes/semantic-map.php is the single documented element-ID to tag mapping.
- Semantic render filter changes tags only, never widget text/content.
- Limit mappings to pages 14/15 and recorded element IDs.
- Standing approval: ul/ol/li, dl/dt/dd, article/section, figure/figcaption,
  blockquote, aside, time, address, inline em/strong/br/span as needed.
- Retain native supported tags and inline markup without unnecessary mappings.
- Test one mapped dd edit in Elementor, Save Draft, verify text/tag; restore source.
- README must warn: duplication/deletion changes IDs; structural edits go through us.
## Fast-track workflow (supersedes previous checkpoint gates)
- Build all remaining Home sections/photos, then full Catalogue continuously.
- No section or stage approval stops; keep progress messages brief.
- During build measure each section at 1280 and 375; screenshot only differences.
- Rebuild plugin ZIP once at end: dist/annie-yahaya-site.zip; owner installs it.
- Batch manual steps (including Shortcode widget if unavailable) into final report.
- Optimise all seven photos to WebP, max long edge 2000; inspect each first.
- Upload via Media REST with exact filenames/alt from CODEX_PROMPT.md section 7.
- Place per section 8, preserving grid; report skipped layout-breaking placements.
- No photos in hero/thread; Catalogue photos only Academy and Essence of Life.
## Final QA and delivery
- Once at end, both pages, signed-out create_preview_link snapshots.
- Save reference-vs-build section captures at 375/768/1280/1440 in qa/final/.
- Section captures are allowed when full-page stitching is unreliable.
- Never share expiring signed preview tokens; share permanent editor links.
- Check nav anchors below sticky header, mobile menus, form prepare/email/copy.
- Check horizontal overflow, only three fonts, alt text and visible focus states.
- Run Lighthouse Accessibility on both pages; target >=90; report actual results.
- One short report: matches, differences, every semantic mapping/override,
  manual owner steps and final plugin ZIP. Keep README current; commit work.
## Hard boundaries
- Do not publish, change homepage, touch other pages/global settings or caches.
- Previous cache-purge instructions are superseded: no cache actions.
- Stop only for true blockers: HTML blob replacing editable text, forbidden scope,
  publishing, or information only owner can provide; batch manual steps at end.
- Owner confirmed backup, default fonts/colors disabled, PRO Elements inactive.
- Media REST uploads/read-only settings allowed; no REST page-write bypass.
