# Annie Yahaya Site 0.2.0 — installation handoff

Prepared 28 September 2026. **Local tests pass; live pilot QA pending installation.**

## Install

1. WordPress → Plugins → Add Plugin → Upload Plugin.
2. Select `dist/annie-yahaya-site.zip` and replace the existing Annie Yahaya Site plugin with this update. Keep it active.
3. Verify version **0.2.0** and Settings → Annie Yahaya Site: Home **14**, Catalogue **15**. The existing option is preserved by the update.
4. Tell Codex the update is installed and sign in to the in-app WordPress browser. Do not publish either page.

No activation migration, homepage switch, cache purge, automatic installation or unrelated-page change is performed by this package.

## Generic CSS pipeline

`scripts/scope-css.cjs` uses locked PostCSS and selector-parser dependencies. Run `pnpm install --frozen-lockfile`, then `pnpm build:css`. Generated output lives in `wp-plugin/annie-yahaya-site/assets/scoped/`. Source SHA-256 values are recorded alongside it.

Each ordinary selector is prefixed with `body.annie-site .elementor`. Selector groups and functional pseudo-classes are parsed correctly; media/supports rules retain their structure. `:root` remains the variable root. `html` and `body` map to `body.annie-site`; descendant rules retain an Elementor boundary. `.catalogue-page` is mapped to the scoped body because the reference attaches that class to `<body>`. Keyframe steps and font-face declarations are not prefixed.

The three reference CSS files and their original plugin asset copies are unchanged. Only the generated copies are enqueued. Order: reference Google Fonts → **one generic neutraliser** → scoped styles → scoped coaching (Home only) → scoped creations → client photos.

The neutraliser uses `all: revert` on structural atomic/container elements, native text/image elements and buttons. It removes author-level builder defaults and restores UA/inherited behavior. `:where()` keeps specificity low enough for the later scoped reference rules. It contains no element IDs, section-specific styling or copied breakpoint values. The unused legacy resets file was removed.

## ARIA and IDs

The `elementor/frontend/the_content` filter uses WordPress's HTML Tag Processor. It requires both a configured page role and page ID 14 or 15. Page 14 mappings:

| Native element | Attribute |
|---|---|
| d4617b3 (Menu button) | aria-expanded=false; aria-controls=nav |
| 282c8e1a (Navigation) | aria-label=Main navigation |
| 2a39dad0 (Thread section) | aria-label=The thread running through Annie’s work |
| 29e9c792, 17887ea4 (Hero links) | first source arrow span: aria-hidden=true |

Page 15's map is empty until its content build is approved. Main **6333a47a** → `main`, Hero **2f9459a5** → `top`, Navigation **282c8e1a** → `nav` must be saved in Elementor General → ID. The filter deliberately does not inject IDs. This browser session required sign-in, so these editor changes remain pending.

Font handling dequeues only Elementor Roboto/Roboto Slab handles (including local Google-font variants) on pages 14/15, with a final output guard for late enqueues. Reference font links and other families/pages remain intact; mixed-family links are not discarded.

Hook references: [Elementor frontend content](https://developers.elementor.com/docs/hooks/frontend-content/), [WordPress HTML Tag Processor](https://developer.wordpress.org/reference/classes/wp_html_tag_processor/).

## Validation performed

- CSS generation tests: grouped/functional selectors, document roots, media/supports, keyframes/font-face, declaration/order preservation.
- PHP lint, original plugin routing/asset/form/metadata tests, source hashes.
- ARIA integration using the real WordPress 6.8 HTML Tag Processor: exact attributes, unrelated elements/pages, idempotence.
- Font exclusion boundaries and existing Home loader/menu unit tests.
- ZIP extraction bytes match plugin files; no build dependencies are shipped.

Commands: `node --test tests/scope-css.test.cjs`; `php tests/plugin-test.php`; set `WP_HTML_API_DIR` to a WordPress `wp-includes/html-api` directory then run `php tests/compatibility-test.php`; `node tests/home-loader-test.cjs`; `python scripts/build-plugin.py`.

## Next — after owner installation

Finish the three IDs in the editor, then validate a fresh signed preview in a signed-out browser. Capture reference/build at 375/768/1280/1440 and use section captures if full-page stitching fails. Check mobile-menu toggling, expected fonts without Roboto, and horizontal overflow. Keep only header/hero/thread on Home; do not extend Catalogue, add other Home sections or publish before pilot approval.
