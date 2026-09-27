# PHASE 1 DECISIONS — Annie Yahaya site (reply to Phase 0 report)

Thank you for the Phase 0 report. Below are my decisions on every open point. **You have my "go" for Phases 1–2 within these rules.** Publishing still needs my separate confirmation (Phase 3).

---

## A. Repository inputs — fix the layout first
1. The files at the repo root are the correct and intended inputs.
2. **Restructure the repo** in one commit, "Organise inputs into reference/photos/docs", using `git mv` so history is kept:
   - Move `index.html`, `creations.html`, `styles.css`, `coaching.css`, `creations.css`, `script.js`, `page.js` and `future-thread-mwc.png` to `reference/`.
   - Move the 7 photos to `photos/`, and rename `Essence of Life 1.jpeg` to `Essence_of_Life_1.jpeg`.
   - Move `Annie_Yahaya_Website_Content_Developer_Handoff (1).pdf` to `docs/Annie_Yahaya_Website_Content_Developer_Handoff.pdf`.
   - Save the attached brief as `CODEX_PROMPT.md` at the root, and save this file as `PHASE_1_DECISIONS.md`.
   - Commit `PHASE_0_REPORT.md` as well.
3. The **design-tokens PDF** is optional. The reference CSS is the ground truth, so continue without it. I will add it to `docs/` later.
4. Once the restructure is done, the missing-reference stop condition is resolved.

## B. Source-vs-brief conflicts — follow the SOURCE in every case
| Topic | Decision |
|---|---|
| Enquiry form | Keep the source behaviour: submit prepares the message and shows **Open in email** + **Copy message**. |
| Navigation | Keep **both source menus**: the homepage menu on Home and the catalogue's own menu on Catalogue. |
| Scripts | `script.js` on Home only and `page.js` on Catalogue only. Never load both on one page. |
| Cloudflare challenge code | Omit it from WordPress. Leave the reference snapshot untouched. |
| Header blur/translucency | Keep it. It is part of the approved design. |
| Catalogue filters/overlay | Do not add them. The source has none. |
| Wording | The live draft / `reference/` wording, character for character. |
| `/creations.html` redirect | Not needed; skip it. The page slug is `/creations/`. |

## C. Architecture — close the MCP gaps with a small site plugin
Because the MCP cannot upload raw CSS/JS, HTML widgets or SEO meta, create a **small custom WordPress plugin** in the repo at `wp-plugin/annie-yahaya-site/`. I will install it myself. Its job:

1. **Enqueue the Google Fonts link** used by the reference (DM Sans, Libre Caslon Display, Manrope).
2. **Enqueue the reference CSS unchanged**, copied into the plugin's `assets/` folder:
   - Home: `styles.css` + `coaching.css` + `creations.css`, the same set as `reference/index.html`
   - Catalogue: `styles.css` + `creations.css`, the same set as `reference/creations.html`
   - Plus `elementor-resets.css`, containing only the documented wrapper resets
   - Plus `client-photos.css`
3. **Enqueue the scripts in the footer:** `script.js` on Home only and `page.js` on Catalogue only.
4. **Scope everything to the two page IDs only.** Store the IDs in one constant or option; Privacy Policy and any other page must stay unaffected. This removes the risk of global CSS affecting existing content.
5. **Shortcode `[annie_enquiry_form]`** that outputs the reference form markup exactly (same IDs, classes and options).
6. **SEO on Home:** use `pre_get_document_title` / `wp_head` to output the exact title and meta description from the reference, plus OG tags using the thread image. No SEO plugin is needed.
7. **Footer year:** keep the reference `#year` span; `script.js`/`page.js` already fill it.
8. Build the plugin zip at `dist/annie-yahaya-site.zip` and tell me when it's ready.

**Form placement.**
- If the MCP exposes a shortcode/text widget that renders shortcodes, place `[annie_enquiry_form]` with it.
- If not, leave a clearly labelled empty container in `#begin`. **I will add one Shortcode widget in the Elementor editor by hand.** Tell me exactly where to put it.

## D. WordPress/Elementor setup
- **Things I will do myself:**
  - Install the plugin
  - In Elementor → Settings: tick **Disable Default Colors** and **Disable Default Fonts**
  - Take a full backup
  - **Deactivate PRO Elements.** It is not official Elementor Pro, is flagged incompatible, and this plan does not need Theme Builder. Tell me before I deactivate it if your checks show anything currently depends on it.
- **Things you may do via REST:**
  - Upload media
  - Read settings
  - Set `show_on_front=page` / `page_on_front` **only at the Phase 3 publish step**
- **Header/footer:** build them per page with native elements (no Theme Builder).
- **Editor V4 / atomic elements:** first confirm that elements built through the MCP render on the front end and open in the editor with the current experiment settings. Do this on a new throwaway draft titled "MCP test — delete me", not on page 8. If an experiment must be switched on, tell me which one and I will enable it.
- **LiteSpeed Cache:**
  - Don't change it now.
  - Before QA, tell me if CSS/JS minify or combine is on. It can break the reference scripts; we will exclude the plugin assets if needed.
  - Purge the cache after each build step before taking screenshots.

## E. Build order with a pilot gate
1. Restructure the repo (section A), then build the plugin (section C).
2. After I confirm the plugin is installed, create two **drafts**: "Home" and "Complete Body of Work" (slug `creations`).
3. **Pilot:** build only the **header + hero + thread artwork** on Home. Take screenshots against the reference at 375/768/1280/1440px and send them to me with a short diff note.
   - If the Elementor wrappers break the reference selectors, **stop and propose the fix** (e.g. a literal class on a different element, or a reset) before continuing.
   - Do not change `styles.css` itself.
4. After I approve the pilot, build the remaining Home sections, then the Catalogue.
5. **Media:** optimise locally (WebP, max 2000px), upload through the WordPress Media REST API with the filenames and alt text from `CODEX_PROMPT.md` §7, then place the photos per §8.
6. Run the full verification in §10 and share signed preview links from `create_preview_link`.

## F. Deliverables before I approve publishing
- Preview links for both pages
- `/qa/` screenshots at 4 widths, reference vs build, for both pages
- A short diff list
- A checklist result for: mobile menu, anchors, form (prepare → open email → copy), fonts (no Roboto), no horizontal scroll, Lighthouse Accessibility ≥ 90
- An updated `README.md`: page IDs, plugin details, and how Annie edits text in Elementor

Do not publish, change the homepage setting or purge anything outside these pages until I say "publish".
