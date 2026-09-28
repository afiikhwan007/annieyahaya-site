# Pilot review — installed plugin 0.2.0

29 September 2026 (Asia/Kuala_Lumpur). **Pilot ready for owner review; no publication or further sections.**

## Saved state

- Annie Yahaya Site **0.2.0** active; PRO Elements inactive.
- Home **14** and Catalogue **15** remain **draft**, both `elementor_canvas`.
- Home contains only native header, hero and thread artwork. Catalogue remains empty.
- Saved through Elementor **General → ID**: Navigation `282c8e1a` → `nav`; Main `6333a47a` → `main`; Hero `2f9459a5` → `top`. Save Options → Save Draft used. Fresh signed preview confirms all three exact IDs.
- Verified body classes on both pages: `annie-site`, plus `annie-site-home` / `annie-site-catalogue`; Catalogue also has `catalogue-page`.
- Exact source ARIA attributes appear on the recorded native elements: navigation label, menu controls/expanded state, decorative arrow spans, thread label. Artwork alt text preserved.
- No theme/global settings, other pages, cache settings or homepage setting changed.

## Reference versus build

Use `comparison-375.jpg`, `comparison-768.jpg`, `comparison-1280.jpg`, `comparison-1440.jpg`. Reference is left, WordPress build is right. Each contains a top capture and a lower hero/artwork capture.

| Requested width | Content width / scroll width | Hero height | Artwork height | Maximum measured geometry difference |
|---:|---:|---:|---:|---:|
| 375 | 360 / 360 | 1048.625 | 375.333 | 0 px |
| 768 | 753 / 753 | 824 | 476.156 | 0 px |
| 1280 | 1265 / 1265 | 824 | 760 | 0 px |
| 1440 | 1425 / 1425 | 824 | 760 | 0 px |

Measurements compare x/y/width/height of the header, hero, hero label, hero statement, hero note, thread section, image and caption. Requested viewport height was 900. The 15px difference between requested and content width is the browser scrollbar, not horizontal overflow. Raw readings are in `capture-metrics.json`.

**Diff note:** layout, line wrapping, spacing, colours and caption placement match the reference in the inspected pilot. The artwork uses the approved WebP conversion, so texture pixels can differ slightly from the reference PNG. Scrollbar thumb length differs because the reference includes the full site and the build is pilot-only. No per-element CSS correction was needed after installing 0.2.0.

## Functional and font checks

- At 375px, Menu opens the navigation (`aria-expanded=true`, `display:flex`), closes it (`false`, `display:none`), and closes after selecting a navigation link.
- No horizontal overflow at any requested width: document scroll width equals client width.
- Computed fonts: DM Sans for body, Manrope for labels, Libre Caslon Display for the headline/note/caption. Only the expected three-family Google Fonts stylesheet is present; no Roboto or Roboto Slab stylesheet on Home or Catalogue. This is DOM/stylesheet verification, not a network-font download audit.
- Focus indicator uses source green `rgb(47,143,108)`; brand punctuation uses source green `rgb(110,194,76)`.
- Neutraliser is loaded before generated scoped CSS. Catalogue omits coaching CSS as intended. `catalogue-scope.json` records its empty signed-out state.
- Links to later sections, enquiry form, Catalogue interactions and full-site accessibility audit are deferred because they are outside this pilot.

## Capture method and limits

Fresh `create_preview_link` snapshots were opened after the draft save. WordPress was explicitly signed out before all comparison captures; previews show no admin bar or `logged-in` body class. No signed URLs are committed.

The browser's full-page screenshot function still duplicates bands and changes layout during stitching. The approved section-capture fallback was used. These are genuine viewport captures with browser scaling; they are not claimed as lossless full-page images. The capture surface trims a small bottom strip, so the final edge of the artwork is supported by geometry measurements rather than a complete stitched image. Lower capture scroll offsets are recorded in the metrics. Sticky headers repeat naturally in each section capture.

Reference was served from a temporary local copy of `/reference/`. Only its injected Cloudflare challenge script was removed from that temporary HTML copy to avoid a hidden iframe interfering with browser measurements. Repository reference HTML/CSS/JS and artwork were not edited.

## Approval gate

Await owner approval of this pilot before building further Home sections or Catalogue content. Do not publish.

Stable editor links (WordPress sign-in required):
- [Home 14](https://aqua-jaguar-251427.hostingersite.com/wp-admin/post.php?post=14&action=elementor)
- [Catalogue 15](https://aqua-jaguar-251427.hostingersite.com/wp-admin/post.php?post=15&action=elementor)
