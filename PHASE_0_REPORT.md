# Annie Yahaya — Phase 0 discovery

Date: 28 September 2026. Repository: https://github.com/afiikhwan007/annieyahaya-site
Inspected main commit: `4315e125e19ca4548d27da44fa94db8edcaf6ce6`.

No WordPress content, settings, media, plugins or publication state was changed. Only read operations were performed. This report is local; nothing was committed to GitHub.

## Input discrepancies

`CODEX_PROMPT.md` is absent from the repository root (GitHub returned 404). There are no `reference/`, `photos/` or `docs/` directories in the recursive main-branch listing. The attached `Codex_Elementor_MCP_Prompt_Annie_Yahaya.md` was read as the provisional Phase 0 specification, not treated as a file that exists in GitHub.

All eight named reference assets exist in the repository root: index.html, creations.html, styles.css, coaching.css, creations.css, script.js, page.js and future-thread-mwc.png. Both HTML files and all five CSS/JS files were fetched and read. They contain real source, including the required homepage section IDs and 700px/900px CSS breakpoints. The image is listed at 2,179,569 bytes; visual validation is still pending.

All seven photos exist in the root. The Names of Allah session photo is named `Essence of Life 1.jpeg`, with spaces, rather than `Essence_of_Life_1.jpeg`. Photo viewing and optimisation belong to the later media phase and have not been performed.

The root has `Annie_Yahaya_Website_Content_Developer_Handoff (1).pdf`. The design-tokens PDF is absent. The handoff PDF has not yet been compared with the source copy.

Before building, confirm that these root-level files and the attached prompt are the intended inputs, or push the requested folder structure and CODEX_PROMPT.md. The prompt's missing-reference stop condition means building remains paused.

## Verified site facts

These facts come from authenticated WordPress REST GET requests, Elementor's system-info report, and MCP discovery.

| Item | Observed value |
|---|---|
| WordPress | 7.1.2 |
| Active theme | Hello Elementor 3.5.1 |
| Elementor | 4.3.2 |
| Official Elementor Pro | Not installed in the plugin list |
| Pro-related extension | PRO Elements 4.2.3 is active; do not equate this with official Elementor Pro |
| Compatibility | Elementor system info marks PRO Elements as incompatible; actual rendering impact is untested |
| Flexbox Containers | `elementor_experiment-container` = `active` |
| Atomic editor option | `elementor_experiment-e_atomic_editor` returned false; V4 widget schemas are nevertheless exposed by MCP, so editing readiness needs validation before content work |
| Disable Default Colors | Stored option empty; not enabled |
| Disable Default Fonts | Stored option empty; not enabled |
| Homepage | Latest posts (`show_on_front=posts`); front-page and posts-page IDs both 0 |
| Permalinks | `/%postname%/` |
| Global V4 variables | None |
| Other active plugin | LiteSpeed Cache 7.9.1 |
| SEO plugin | None in the installed plugin list |

Existing pages:

| ID | Title | Status | Elementor structure |
|---|---|---|---|
| 8 | Elementor #8 | Draft | Empty element tree |
| 3 | Privacy Policy | Draft | Not inspected |

No existing pages will be repurposed or deleted under the proposed plan. Create two new draft pages after approval.

## Every exposed Elementor MCP tool

Names below omit the common server prefix. There are 20 tools.

| Tool | What it does |
|---|---|
| build_composition | Builds supported Elementor element trees; supports append, replace and non-persisting validation. |
| create_page | Creates a blank Elementor draft page or post. |
| create_preview_link | Creates a signed, time-limited preview snapshot without publishing. |
| get_default_styles | Reads tag-level default CSS from the active kit. |
| get_page_structure | Reads a document's element tree and selected element details. |
| get_widget_schema | Reads one supported widget's settings schema. |
| list_assets | Lists existing Media Library images, SVGs or videos; does not upload. |
| list_components | Lists reusable components and license-dependent capabilities. |
| list_posts | Lists existing pages, posts or products and their statuses. |
| list_resources | Discovers available MCP documentation and design resources. |
| list_widget_schemas | Lists supported widgets or returns their schemas. |
| manage_classes | Creates, updates or deletes V4 reusable CSS classes. |
| manage_component | Creates, updates, renames, archives or publishes reusable components. |
| manage_default_styles | Changes site-wide default styles for supported HTML tags. |
| manage_elements | Updates, moves, duplicates or deletes supported document elements. |
| manage_global_variable | Manages V4 colour, font and size variables. |
| publish_document | Publishes a document or promotes staged changes. |
| read_resource | Reads discovered MCP documentation or design resources. |
| reorder_classes | Changes global-class priority. |
| update_page_settings | Updates an individual Elementor document's settings. |

This table is the complete exposed set observed in this session; no upload, site-parts, arbitrary HTML or site-settings writer is exposed.

## Proposed section mapping

Use e-div-block, e-flexbox or e-grid for structural containers; e-heading for headings; e-paragraph for editable prose and inline markup; e-button for compatible links; e-image for uploaded assets. Check exact tags, IDs and attributes against schemas before construction. Do not assume Elementor's wrappers reproduce the original DOM automatically.

| Source section | Proposed implementation |
|---|---|
| Shared skip link | Native link with `#main` target and reference focus styling; exact fixed-position treatment. |
| Home header | Native brand/link elements and menu button in structural containers. Retain original navigation classes and ARIA behaviour; original menu JS needs separate injection. |
| Home hero `.hero#top` | Three-column grid, editable heading with inline em/br markup, paragraphs, CTA links and note. No photo. |
| `.future-thread` | Image plus native caption with strong markup; original artwork and layout, no client photo. |
| `.why#why` | Section label, asymmetric containers, heading, lead/body paragraphs, World Within callout and signature. |
| `.work-with#work` | Intro grid, three article-style pathway containers, descriptions and links; evidence heading and four figure rows. Add approved two-photo row beneath figures if responsive checks pass. |
| `.coaching-service#coaching` | Intro grid, two service cards, faith-note grid and five-step list. Native semantic list if supported; otherwise editor HTML widget. Seated portrait beside intro only if layout permits. |
| `.moments` | Four A–D article rows with native text and headings. |
| `.built#built` | Nine ledger cards and separate full-catalogue CTA. Add images only to Academy and Essence of Life cards. Preserve card classes and spanning. |
| `.ideas#ideas` | Intro and seven numbered framework rows. Add Names of Allah session image only where it preserves the grid. |
| `.annie#annie` | Existing two-column title/profile, pull quote and four figures; standing portrait in narrow column subject to breakpoint validation. |
| `.research` | Native overline, heading and research paragraph. |
| `.begin#begin` | Native introduction plus exact enquiry form in an HTML widget inserted via the editor, because this widget is not available through MCP. Preserve field IDs, validation and mailto/copy behaviour. |
| Footer | Native brand, text and links, with year span and original JavaScript. |
| Catalogue header | Preserve its actual Home/Tools/Programs/Organisations/Frameworks navigation unless the client explicitly prefers the prompt's shared homepage menu. |
| `.catalogue-hero` | Three-column native grid with index, heading and introduction. |
| `#tools` | Three signature-tool cards with paragraphs and list; Essence of Life photo only. |
| `#learning` | Ten learning entries, including six course-name labels inside the course-suite entry. |
| `#world` | Seven organisation/community/FaithTech rows with monograms; Academy image only. |
| `#frameworks` | Ten numbered method rows. |
| `.catalogue-close` | Native closing heading, homepage enquiry link and email link. |
| Catalogue footer | Preserve its source-specific content; do not silently add the homepage's extra catalogue link. |

## Source behaviour and conflicts to preserve or resolve

- Catalogue source has no filters, overlay, close controls or reveal animations. Do not invent them.
- Enquiry submit prepares the message and shows `Open in email` and `Copy message`; opening the email client is a second click. This differs from the prompt's auto-open wording. Recommend retaining source behaviour.
- Home and catalogue have different navigation. Exact-reference fidelity favours retaining both source menus rather than replacing the catalogue menu with the homepage menu.
- Keep script.js on Home and page.js on Catalogue. Both declare top-level menu/nav constants; injecting both unmodified on the same page would cause declaration conflicts.
- Downloaded HTML contains injected Cloudflare challenge code. It is hosting infrastructure, not authored design or behaviour; omit it from the WordPress implementation while preserving the reference snapshot.
- Original CSS already includes a translucent/blurred header. Preserve existing source effects; the prohibition on adding effects does not justify deleting approved effects.
- Existing arbitrary CSS selectors and precise DOM relationships cannot be assumed to survive conversion into V4 managed classes. Keep original stylesheets as raw CSS and add only documented Elementor resets.

## MCP gaps and proposed workarounds

| Requirement | Limitation and proposed route after approval |
|---|---|
| Media upload and optimisation | MCP lists assets only. Optimise locally, upload through authenticated WordPress Media REST API, then use returned IDs via MCP. |
| Exact HTML form and optional lists | HTML widget is absent from supported widget schemas. Insert through the Elementor editor UI; do not pass unsupported widget types to MCP. |
| Raw site CSS and footer JS | Class/default-style tools do not replace unrestricted stylesheet/script injection. Use supported WordPress/Elementor admin controls, verifying PRO Elements features first; otherwise Additional CSS and per-page HTML widgets. |
| Theme Builder | No list-site-parts/manage-site-parts tools registered. Official Pro is absent. Prefer per-page header/footer fallback; any use of PRO Elements Theme Builder must be verified separately. |
| Global settings and breakpoints | No dedicated MCP operation for default-colour/font toggles, homepage selection or kit breakpoint settings. Use WordPress/Elementor settings UI or supported API routes. The authenticated WordPress settings endpoint is readable. |
| Semantic tags and literal class names | Validate widget schemas and generated DOM; managed-class labels are not proof of exact literal selector output. Use editor custom-class controls where needed. |
| SEO metadata | No SEO plugin installed. Page title alone does not guarantee the requested document title and description. Needs a supported metadata route agreed before implementation. |
| Redirect and CSS/cache regeneration | No corresponding MCP tool. Configure through supported WordPress/admin or hosting controls, if available; do not claim it is done. |
| Existing-content preservation | Site-wide CSS and defaults can affect other pages. Scope necessary resets and check existing content before applying global settings. |

## Approval gate and subsequent order

Await the user's go, resolution of the input layout/prompt mismatch, and acceptance of the non-MCP fallback routes. First validate the installed Elementor/PRO Elements pairing and editor capabilities. Then set foundation settings, build two new drafts, add media, and verify against the source at 375/768/1280/1440px. Share preview links before publication. Publication, homepage reassignment and cache regeneration require the later explicit confirmation specified in the brief.

No WordPress mutation or publication is authorised by this Phase 0 report alone.
