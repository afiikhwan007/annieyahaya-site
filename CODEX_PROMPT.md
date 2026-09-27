# PROMPT FOR CHATGPT CODEX — Build Annie Yahaya Website in WordPress + Elementor (via Elementor MCP)

## 1. Objective
Rebuild the client-approved draft site as a WordPress site built in **Elementor**, published through the connected **Elementor MCP**:
- **Home:** https://annie-builds.annieyahaya.chatgpt.site/
- **Catalogue:** https://annie-builds.annieyahaya.chatgpt.site/creations.html

The result must look and behave **as close to identical as possible** to the draft. That means the same layout, section order, fonts, colours, spacing, borders, breakpoints, interactions and **the exact wording of the live draft**.

The only addition is the client's photos, placed as described in section 8.

**Do not:**
- redesign, "improve" or add pages, sections, colours, rounded corners, shadows, gradients or animations
- use Elementor kit templates or theme demo content

---

## 2. Inputs in this repo (`annieyahaya-site`)
| Path | Contents |
|---|---|
| `/reference/` | Original draft source: `index.html`, `creations.html`, `styles.css`, `coaching.css`, `creations.css`, `script.js`, `page.js`, `future-thread-mwc.png`. **This is the ground truth** for structure, class names, CSS values and JS behaviour. |
| `/photos/` | Client photos: `pic1.jpeg`, `pic3.jpeg`, `Essence_of_Life_1.jpeg`, `G2.jpeg`, `G3.jpeg`, `G8.jpeg`, `G12.jpeg` |
| `/docs/` | `Annie_Yahaya_Website_Content_Developer_Handoff.pdf` and `Annie_Yahaya_Website_Design_Tokens.pdf` |

If `/reference/` is empty or incomplete, **stop and tell me**. Do not rebuild from memory or screenshots.

If you need to fetch anything from the draft site on this Windows machine, use:
`curl.exe --ssl-no-revoke -fsSL -o <file> <url>`

---

## 3. Phase 0 — Discovery (report to me before building)
Do not change anything on WordPress yet. Report the following:

1. **Elementor MCP tools.** List every tool the Elementor MCP exposes, with one line on what each does (e.g. create page, add/update elements, set global colours/fonts, upload media, custom CSS, theme builder, publish).
2. **Site facts.** From the MCP or the WordPress API, report:
   - WordPress version
   - Active theme
   - Elementor version and whether **Elementor Pro** is active
   - Whether Flexbox **Containers** are enabled
   - Existing pages
   - The current homepage setting
3. **Build plan.** Map each section of `reference/index.html` and `reference/creations.html` to Elementor elements, using native widgets vs HTML widgets (see section 5). Note anything the MCP **cannot** do (e.g. site-wide custom CSS, theme builder header/footer) and propose the workaround.
4. **Wait for my "go"** before making changes.

---

## 4. Phase 1 — Site foundation (settings only, no content yet)
1. **Theme.** Use **Hello Elementor**. If it isn't active, tell me rather than switching automatically.
2. **Elementor settings:**
   - Disable Default Colors and Disable Default Fonts.
   - Containers on.
   - Default page layout = **Elementor Full Width**, with page title hidden.
   - Content width boxed 100% / full width, and default container padding **0**. Spacing is controlled by the reference CSS.
   - Breakpoints: mobile **700px**, tablet **900px** (to match the reference CSS).
3. **Global Colors** (Site Settings → Global Colors). Use these exact names:

   | Name | Hex |
   |---|---|
   | MWC Green | `#6EC24C` |
   | Deep Teal | `#004A52` |
   | Soft Green | `#9BDC81` |
   | Ink | `#0E0E0D` |
   | Warm Paper | `#F3F0E8` |
   | Line Grey | `#C9C4BA` |
   | Warm Grey | `#E5E0D6` |
   | Focus | `#2F8F6C` |

4. **Global Fonts** (Google Fonts). Headings are **never bold**.

   | Role | Font |
   |---|---|
   | Primary / Display | **Libre Caslon Display** 400 |
   | Secondary / Labels | **Manrope** 600/700 |
   | Text | **DM Sans** 400 |
   | Accent | **Manrope** 700 |

5. **Site background:** Warm Paper `#F3F0E8`. **Body text:** Ink, DM Sans 16px, line-height 1.55.
6. **Custom CSS:**
   - Port `reference/styles.css`, `coaching.css` and `creations.css` into the site-wide Custom CSS (Elementor Pro Site Settings → Custom CSS). If Pro isn't available, use Appearance → Customize → Additional CSS.
   - Keep the **original class names** and values.
   - Only add the Elementor-specific overrides needed to neutralise Elementor's default wrappers, e.g. `.elementor-widget-container` margins and `.e-con` default padding/gap. Put them in a clearly commented block at the top: `/* ELEMENTOR RESETS */`.
7. **Scripts.** Add the behaviour from `reference/script.js` and `page.js` (mobile menu toggle, smooth anchor scroll with header offset, catalogue interactions, enquiry form) as a site-wide footer script. Use Elementor Pro Custom Code (body end), or an HTML widget on each page if Pro isn't available.

---

## 5. How to build with Elementor (fidelity rules)
- **Rebuild the reference DOM structure** with Containers, and give each container/widget the **same CSS classes and IDs** as the reference HTML (Advanced → CSS Classes / CSS ID). This way the ported reference CSS styles the Elementor build exactly as it styles the draft.
- **Use native widgets wherever the output matches:**
  - Heading
  - Text Editor
  - Button
  - Image
  - Icon List for simple lists

  This lets Annie edit the text later in Elementor.
- **Use an HTML widget** only for parts that native widgets cannot reproduce exactly:
  - Headlines with italic accent words: a Heading widget with `<em>` inside is fine if Elementor keeps the markup; otherwise use an HTML widget.
  - The enquiry form (it builds a mailto message; the Elementor Form widget cannot do this)
  - The catalogue filters/overlay on `creations.html`
  - The numbered session list, if needed
- **Do not use:**
  - Elementor animations/motion effects
  - Shadows, border-radius or gradients
  - Stock images
  - Icons that aren't in the reference
- **Section IDs must match the reference anchors:** `main`, `why`, `work`, `coaching`, `ideas`, `annie`, `begin`.

---

## 6. Phase 2 — Pages & structure

### Header and footer
- **If Elementor Pro:** build them in Theme Builder (Header + Footer, display on the entire site).
- **Otherwise:** build them as the first and last containers on both pages.
- **Header:**
  - Brand mark "ANNIE YAHAYA." (the full stop is MWC Green)
  - Nav links: Why I build `#why` · Work with Annie `#work` · Private coaching `#coaching` · Complete body of work → `/creations/` · The thinking `#ideas` · Annie `#annie` · **I want Annie involved** `#begin` (primary ink button)
  - Mobile "Menu" toggle, exactly as the reference
  - On the Creations page, prefix the anchor links with `/` so they go back to the homepage sections.
- **Footer:** exactly as the reference, with the copyright year set automatically.

### Page 1: Home (set as the static front page), slug `/`
Replicate `reference/index.html` in this order:
1. Skip link
2. Hero
3. Thread artwork + caption
4. 01 Why I build
5. 02 Work with Annie (3 pathways + Evidence in real rooms)
6. 03 Coaching with Annie
7. 04 One instinct, many forms
8. 05 What I have built (9 cards + "See everything" link card)
9. 06 The thinking behind the work
10. 07 The builder
11. Doctoral research
12. Bring Annie in (form)
13. Footer

### Page 2: Complete Body of Work, slug `/creations/`
- Replicate `reference/creations.html` exactly, including its interactions.
- Set up a 301 redirect from `/creations.html` to `/creations/` if a redirect tool is available.

### Copy
- Copy the text **character for character from the live draft / `/reference/` HTML**: ™ symbols, curly quotes (’ “ ”), em dashes (—), "A NEW VIEW™", "NURANI", "AKEPT × UNIMAP" and the stats exactly as on the draft.
- Write any differences from the handoff PDF into `CONTENT_DIFF.md` in the repo, but **use the draft wording**.

### Enquiry form (HTML widget, keep reference behaviour)
- Same fields and dropdown options as the draft.
- The button "Prepare my message →" builds:
  `Assalamualaikum Annie, I would like to begin a conversation about [selected option]. What is happening: [message]. Name: [name]. Email: [email]. Organisation: [optional].`
  It then opens `mailto:sheis@annieyahaya.com` and offers "Copy message".

---

## 7. Media
1. Upload `reference/future-thread-mwc.png` and all photos to the WordPress **Media Library** via the MCP. Convert them to WebP if the MCP or WordPress supports it, with a maximum long edge of 2000px.
2. Rename the photos and set their alt text:

| Original | New name | Alt text |
|---|---|---|
| `pic1.jpeg` | `annie-portrait-standing` | Annie Yahaya |
| `pic3.jpeg` | `annie-portrait-seated` | Annie Yahaya seated with coffee |
| `Essence_of_Life_1.jpeg` | `session-essence-of-life-names` | A small-group session with Names of Allah and reflection cards |
| `G8.jpeg` | `session-essence-of-life-cafe` | Participants working with Essence of Life™ cards |
| `G2.jpeg` | `mwc-cohort-group` | An International Muslim Women Coaching Academy certification cohort |
| `G3.jpeg` | `workshop-group` | Participants in a workshop with Annie |
| `G12.jpeg` | `speaking-panel` | Annie Yahaya speaking on a panel |

Open each photo to confirm it matches its description before using it.

---

## 8. Photo placement (keep the draft layout exactly)
**Photo styling:**
- Square corners, 1px Ink border, no shadow
- `object-fit: cover`, with portraits at 4:5 and landscapes at 3:2
- Optional caption in the reference label style (Manrope, 0.7rem, uppercase, tracked)
- Put all photo CSS in a separate commented block: `/* CLIENT PHOTOS */`

**No photos in the hero or the thread-artwork section.**

| # | Section | Photo | Placement |
|---|---|---|---|
| 1 | 07 The builder `#annie` | `annie-portrait-standing` | Portrait in the narrower column beside the name/profile. On mobile, stack it above the name. |
| 2 | 03 Coaching `#coaching` | `annie-portrait-seated` | Beside the intro copy. On mobile, stack it below the intro. |
| 3 | 02 Evidence in real rooms | `workshop-group` + `speaking-panel` | 2-image row under the 4 figures, sharing one 1px border. Captions: "In the room" and "Speaking". |
| 4 | 05 MWC Academy card | `mwc-cohort-group` | Top of the card at 3:2, with `object-position: center 70%` to crop out most of the banner text. |
| 5 | 05 Essence of Life™ card | `session-essence-of-life-cafe` | Top of the card at 3:2. |
| 6 | 06 The thinking | `session-essence-of-life-names` | Beside the I.S.L.A.M. row, or as a band between the intro and the list, whichever keeps the existing grid unchanged. |
| 7 | `/creations/` | Reuse images #4 and #5 | Only on the MWC Academy and Essence of Life™ entries. |

If any placement would break the original layout at any breakpoint, skip it and tell me.

---

## 9. Phase 3 — Publish safely
1. Build both pages as **Draft** first.
2. Share the preview links with me.
3. Run the verification in section 10.
4. **Publish only after I confirm.** Then:
   - Set Home as the static front page.
   - Clear the Elementor cache: Tools → Regenerate CSS & Data.
5. Don't delete or modify any other existing pages, posts, menus or plugins.

---

## 10. Verification
1. **Visual diff.** Use Playwright to take full-page screenshots of the draft site and the WordPress preview at **375, 768, 1280 and 1440px**, for both pages.
   - Report any section that differs (apart from the added photos) and fix it.
   - Save the screenshots in `/qa/` in the repo.
2. **Functional checks:**
   - No horizontal scroll at any width.
   - The mobile menu works.
   - Anchors land below the sticky header.
   - The form builds the message and opens the mail client, and "Copy message" works.
   - The catalogue interactions work.
3. **Fonts.** Check that only Libre Caslon Display, DM Sans and Manrope load, and that no Elementor default fonts (Roboto) load.
4. **Accessibility.**
   - Visible focus: 3px solid `#2F8F6C` with a 3px offset.
   - Alt text on all images.
   - Lighthouse Accessibility score of 90 or higher.
5. **SEO.** Set the homepage title and meta description exactly as the draft:
   - Title: "Annie Yahaya — I Build What the Human Moment Requires"
   - Description: "Annie Yahaya is a creator, builder, faith-aligned executive coach, life coach and human development architect. She creates what helps people move forward with dignity, humility and impact."

   Use the SEO plugin if one is installed; otherwise tell me.
6. **Report.** Write `README.md` in the repo listing:
   - Elementor settings changed
   - Pages created (with IDs and URLs)
   - Media uploaded
   - Where the custom CSS/JS lives
   - Skipped placements
   - How Annie can edit text in Elementor
