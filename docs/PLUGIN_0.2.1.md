# Plugin 0.2.1 — semantic wrapper installation handoff

29 September 2026. Owner installation required before live verification.

## Delivered

- Work with Annie / Evidence in real rooms added to Home draft 14: 61 native widgets, root `84df354`, exact reference wording and classes. No inline CSS or HTML widget.
- Tag-name-only render adapter using WordPress's HTML tokenizer and paired opening/closing tags. All content and attribute bytes stay intact. Page and recorded-ID guards apply.
- One central map: `wp-plugin/annie-yahaya-site/includes/semantic-map.php`.
- Existing source ARIA filter extended to Work/Evidence labels and three link arrows. Native General IDs still need editor entry after installation.
- No CSS files, reference files, other pages, homepage setting, caches or publication changed.

## Recorded mappings (page 14 only)

| Element ID | Native → reference tag | Purpose |
| --- | --- | --- |
| 3cfaced7 | div → dl | Coaching engagement |
| 1461f8a0 | span → dt | Coaching term |
| 19408f7c | span → dd | Coaching description; editor test target |
| 9b41f66 | div → dl | Organisation engagement |
| 4fe773c0 | span → dt | Organisation term |
| 32d3ff8 | span → dd | Organisation description |
| 19c70720 | div → dl | Build engagement |
| 600a7edb | span → dt | Build term |
| 6813a958 | span → dd | Build description |
| 597598f8 | span → strong | 350+ |
| faa13f8 | span → strong | 2,800+ |
| 2349c73a | span → strong | AKEPT × UNIMAP |
| 6b7d3124 | span → strong | Since 2014 |

Catalogue map is empty. Inline em/br/span are already native text; article/section tags are native container settings and need no filter mappings.

## Validation completed

Real WordPress HTML tokenizer tests verify exact preservation of content/attributes, nested inline tags, comments, raw script text, changed widget wording, idempotence, unrelated pages, admin output, new duplicate IDs, unexpected tags, incomplete structure and duplicate recorded IDs. Applying the adapter locally to the actual signed-out Elementor draft DOM converts all 13 wrappers and preserves all text. These are local checks, not a live installed-plugin result.

## Owner action and next steps

Upload the supplied `annie-yahaya-site-0.2.1.zip` through Plugins → Add New Plugin → Upload Plugin and replace the existing Annie Yahaya Site installation. Keep Home 14 and Catalogue 15 configured. No cache purge requested.

After installation, sign in to WordPress in the in-app browser. The agent will:

1. Set native General IDs: `84df354` → work, `6de7b299` → work-title, `1f0f375e` → evidence-title.
2. Edit native description `19408f7c`, Save Draft, verify new wording and dd wrapper, then restore the source wording and Save Draft.
3. Complete source link data-interest attributes through supported native controls if available; verify enquiry preselection at Checkpoint 1.
4. Validate Work against the reference at four widths; stop if a per-element CSS fix becomes necessary.
5. Continue remaining Home sections and Checkpoint 1. Stage 2 remains gated on Checkpoint 1 approval.

No claim of visual parity or Checkpoint 1 completion is made before installation and live checks. The pre-install draft still renders the fallback span/div tags under plugin 0.2.0.

Duplicated/deleted mapped widgets require our structural review and a new ID mapping. Ordinary edits to existing native text remain supported.
