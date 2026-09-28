# Pilot review — 28 September 2026

Status: **STOPPED at the CSS compatibility gate; not approved for publication.**

## Completed

- User confirmed a full Hostinger backup.
- Page 11 opened in the signed-in Elementor editor; the native heading's title, tag and ID controls are editable. No experiment change was required.
- Disable Default Colors and Disable Default Fonts read `yes`; PRO Elements is inactive.
- Existing repo restructure and plugin were not rebuilt. The attached PHASE_1_DECISIONS.md matches the committed root file after line-ending normalization (commit f46a6a1).
- Home draft **14** and Complete Body of Work draft **15** exist. Catalogue slug is **creations**, verified with authenticated REST readback.
- Plugin option saved with Home 14 / Catalogue 15.
- Home contains only skip link, header/navigation, hero and thread artwork. Catalogue remains empty.
- Native widgets retain literal reference classes and direct child markup. Thread uploaded as 1536×1024 WebP, media **30**, with reference alt text.
- Both drafts currently use Elementor Canvas to avoid Hello's duplicate header/footer. This differs from the brief's Full Width setting and is documented for review.

## LiteSpeed

CSS Minify OFF; CSS Combine OFF; JS Minify OFF; JS Combine OFF. The subordinate “Combine External and Inline” switches are ON but inactive while Combine is OFF. Async CSS, UCSS and JS defer/delay were OFF. No optimization setting was changed.

**Incident:** opening the toolbar's advertised Expand action unexpectedly activated global purge. The dashboard reported “Purged all caches successfully.” This exceeded the instruction to purge only the two pilot pages. The action was disclosed immediately and no further cache actions were taken. No publication or page-content change resulted from the purge.

## Why the pilot stopped

The original selectors still match, but Elementor's higher-specificity base styles win:

| Element | Reference | Observed build at 1280px |
|---|---|---|
| Header | flex, sticky, 0 3.5vw padding | block, relative, 10px padding |
| Hero | grid, three columns, 6vw 3.5vw 3.5vw padding | block, 10px padding |
| Brand/nav links | plain links | blue #375EFB button background, 12px 24px padding |
| Hero description | 2.5rem 0 2rem margin | 0 margin |
| Artwork section | edge-to-edge image | inherited container padding creates an inset |

For example `.elementor .e-div-block-base { padding:10px; display:block }` outranks `.hero`. `.elementor .e-button-base` introduces the unwanted blue background. `.e-con` also supplies builder positioning/sizing defaults. Existing reset CSS targets legacy container variables, which does not neutralize these atomic defaults.

Roboto and Roboto Slab stylesheet requests remain present despite Disable Default Fonts being enabled. Reference fonts also load. Do not claim font QA passed.

The MCP configuration schema omits CSS IDs/custom attributes. `main`, `top`, `nav`, the navigation label and menu ARIA state remain to be set through supported editor controls or a narrowly scoped render adapter. Inline arrow aria-hidden attributes were stripped on save. Mobile-menu/anchor QA is therefore **not passed**.

## Proposed fix — not applied

1. Add a documented **pilot-only V4 compatibility section** in `assets/elementor-resets.css`, scoped to `body.annie-site-home .elementor-14`. Explicitly restore the original header/nav/hero/hero-label/hero-actions display, positioning, padding and paragraph margins at the original 700/900px breakpoints. Restore plain-link defaults, with the original nav-action/hero-primary declarations taking precedence. Neutralize only the generated outer/root and Main containers' padding, sizing and positioning. Keep native editable widgets and the original styles.css byte-for-byte unchanged.
2. Set IDs `main`, `top`, `nav` through Elementor General → ID. If custom ARIA attributes remain unavailable without Pro, add a documented render filter restricted to the recorded native element IDs on page 14 to emit only the exact source attributes. Do not substitute HTML blobs for editable text or add global JavaScript behavior.
3. Remove only Elementor-generated Roboto/Roboto Slab font enqueues on the two configured pages, preserving the reference font URL and other pages.
4. Rebuild the plugin ZIP for owner installation (no automatic installation was authorized by the decisions file). After installation, repeat the pilot screenshots and mobile-menu/font/overflow checks. Keep the full build gated on pilot approval.

No reset/filter/font fix has been implemented or deployed. Approval is requested because PHASE_1_DECISIONS.md §E says to “stop and propose the fix ... before continuing.”

## Responsive observations

All captures used requested CSS viewports 375/768/1280/1440 and height 900. DOM scroll widths were 360/753/1265/1425 respectively (scrollbar excluded): no horizontal overflow detected. Layout fidelity fails at all widths.

Full-page browser captures exhibit stitching/scale artifacts (repeated artwork bands and blank areas), so they are diagnostic evidence, **not pixel-accurate approval images**. Repeated artwork in those images must not be mistaken for duplicate DOM sections; the DOM contains one thread section. This screenshot limitation must be resolved before final visual approval. WordPress captures taken while signed in show the admin toolbar.

Clean viewport-only comparisons were subsequently captured in a signed-out session and are the `comparison-*.jpg` deliverables. These show header/hero, not the complete thread section. Browser image dimensions may be scaled by the UI; labels refer to the requested CSS viewport. Raw full-page captures and metrics are retained locally as diagnostic data. No full-site accessibility, form or catalogue QA was performed at this pilot stop.

## Draft access (WordPress editor login required)

- Home: https://aqua-jaguar-251427.hostingersite.com/?page_id=14&preview_id=14&preview=true
- Catalogue: https://aqua-jaguar-251427.hostingersite.com/?page_id=15&preview_id=15&preview=true

Nothing was published. Homepage selection remains unchanged. Existing page 8 and Privacy Policy were not edited.
