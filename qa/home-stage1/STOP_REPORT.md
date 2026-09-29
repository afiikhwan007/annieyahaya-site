# Stage 1 stop report — 29 September 2026

The pilot is owner-approved. Stage 1 started, but Checkpoint 1 is **not complete**.

## Saved draft work

Home 14 now includes **Why I build** after the thread artwork, with 12 native elements, exact source text and reference classes. Root native ID `5df65e08`; literal `why` saved via Elementor General → ID and Save Draft. No element-level style declarations were added. Seven empty reference classes were registered; their styling comes entirely from the existing scoped plugin CSS.

A fresh signed-out snapshot at 1280×900 confirms matching geometry for the section, section label, heading, copy column, lead, World Within block and signature. Document scroll width equals client width (1265px). `why-comparison-1280.jpg` is a partial section viewport capture, not the requested complete four-width Checkpoint 1 package. The `#why` link reaches the section; the heading/section label are below the sticky header due to source section padding. Other anchor checks remain pending.

Both pages remain Canvas drafts. No photos uploaded yet. No form or later sections added. Catalogue remains empty. No publication, homepage changes or cache actions.

## Boundary found before Work with Annie

Each of the three reference `.route-card` articles contains a native definition list:

```html
<dl><dt>An engagement may be</dt><dd>...</dd></dl>
```

The reference selectors `.route-card dl`, `.route-card dt`, `.route-card dd` control flex placement, borders, spacing and type. The exposed `e-div-block` schema allows div/header/section/article/aside/footer/a/button/main/nav, but not `dl`. `e-paragraph` permits only p/span and strips dt/dd from static text. The actual editor HTML Tag menu also offers no definition-list tag. Buttons cannot supply a nested editable definition-list tree.

Replacing these tags with generic div/span/p elements would cause those source selectors to miss their targets. Compensating with card-specific CSS would cross the owner's explicit stop boundary. No such substitution or CSS patch was made; Work with Annie has not been inserted.

## Proposed resolution for owner decision

Prefer a narrowly scoped **semantic-tag adapter** in the site plugin: keep each list and its text as native editable elements, but render only recorded list/term/description element IDs as dl/dt/dd on page 14. It would alter HTML tags, not style values, so the existing generated source CSS can work unchanged. This extends the existing ARIA-only render approach and has **not** been implemented or installed. It needs validation of balanced opening/closing tags and the editor preview before use.

Alternative: permit the small definition-list fragments in a native Text Editor/HTML widget added through the editor, then validate wrapper behavior. This is not exposed by the MCP composition schema and may require generic wrapper compatibility. It is not yet proven to preserve the source layout.

The MCP now exposes a Shortcode dynamic tag on native text widgets. `[annie_enquiry_form]` rendering remains untested because the build stopped earlier in source order. If it does not render valid form markup, retain the owner's labelled empty-container fallback.

Resume Stage 1 only after resolving this boundary. The original references and installed plugin 0.2.0 are unchanged.
