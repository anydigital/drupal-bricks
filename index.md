---
layout: jumbohead
title: Bricks
header: '
  <h1 class="display-1 mt-5">Bricks</h1>
  <p class="lead">Revolutionary new way of creating rich content in Drupal.</p>
  <p class="lead">
    <a class="btn btn-outline-info" href="https://www.drupal.org/project/bricks" target="_blank"><i class="fa fa-drupal"></i> Drupal.org</a>
    <a class="btn btn-outline-info" href="https://github.com/highweb/drupal-bricks" target="_blank"><i class="fa fa-github"></i> GitHub</a>
  </p>
  <p>Currently 8.x-1.4</p>
'
---

**Bricks** — is a revolutionary new way of creating rich content in Drupal. Thanks to the powerful contributions like ECK and Entity Reference, Bricks itself is just ~13 KB of code (gzipped).

In terms of concept Bricks is a new generation of [Paragraphs](https://www.drupal.org/project/paragraphs), drop-in replacement for [Panelizer](https://www.drupal.org/project/panelizer) and a good friend to [Display Suite](https://www.drupal.org/project/ds) and [CKEditor](https://www.drupal.org/project/ckeditor) or any other [WYSIWYG](https://www.drupal.org/project/wysiwyg). Shortly, it allows you to nest field items using Drupal drag & drop UI (exactly like for menu or taxonomy items).

<img src="https://cdn.rawgit.com/highweb/drupal-bricks/media/bricks-8.x-1.2.gif" width="608"/>


## Live demo

1. Open [pre-configured sandbox](https://simplytest.me/project/bricks).
2. Click **Launch sandbox** and wait.
3. Follow the installation (all settings should be pre-filled, don't change them).
4. Go to **Extend** and install **Bricks Bootstrap**.
5. Go to **Appearance**, install **Tweme** and set as default theme.
6. Find a sample node and go to **Edit** mode to check magic out!
7. Finally go to **Content** and create your own first **Bricky** page!
8. Like it? => Support by [★ starring on GitHub](https://github.com/highweb/drupal-bricks) or [sharing on Twitter](https://twitter.com/highwebtech/status/841004866633842689).


## Installation

The most easy-to-use method:

1. Download and install [Bricks Bootstrap](https://www.drupal.org/project/bricks_bootstrap) with its dependencies.
2. Download and enable [Tweme](https://www.drupal.org/project/tweme) (or any other Bootstrap 4 theme).
3. **Done!**

Now you can create **Bricky** pages (content type) using powerful preconfigured **Bricks** such as Text, Image, Accordion, Carousel, Tabs and others (ECK bundles). Use auto-created "All new AirPods" node as a live playground.

![](https://cdn.rawgit.com/highweb/drupal-bricks/media/bricks-bootstrap-8.x-4.1-node.png)

![](https://cdn.rawgit.com/highweb/drupal-bricks/media/bricks-bootstrap-8.x-4.1-node-edit.png)

### Paragraphs setup <sup>8.x-1.3+, in Beta</sup>

1. Download and install [Bootstrap Paragraphs](https://www.drupal.org/project/bootstrap_paragraphs) with its dependencies.
2. Download and enable [Bootstrap](https://www.drupal.org/project/bootstrap) (or any other Bootstrap 3 theme).
3. Download and install [Bricks](https://www.drupal.org/project/bricks) with its dependencies. Also enable **Bricks Inline** and **Bricks Revisions**.
4. Go to **Structure** > **Content types** and create **Bricky** content type.
5. Delete default **Body** field.
6. Create new **Body** field of type **Bricks (revisioned)**:
   - Name: *Body (field_body)*
   - Type of item to reference: *Paragraph*
   - Allowed number of values: *Unlimited*
7. Go to **Manage form display** and set **Bricks tree (Inline entity form)** widget for **Body** field.
8. Go to **Manage display** and hide label for **Body** field.
9. **Done!**

Now you can create **Bricky** pages (content type) using your favorite Paragraphs such as Simple, Image, Accordion, Carousel, Tabs and others (Paragraph types).

![](https://cdn.rawgit.com/highweb/drupal-bricks/media/bricks-8.x-1.3-bootstrap-paragraphs-1.0-beta1-node.png)

![](https://cdn.rawgit.com/highweb/drupal-bricks/media/bricks-8.x-1.3-bootstrap-paragraphs-1.0-beta1-node-edit.png)


## Requirements

All new Bricks for D8 has no requirements and works with ANY entity types!


## Submodules

**Bricks Core**

- **Bricks** field type — An entity field containing a tree of entity reference bricks.
- **Bricks tree (Autocomplete)** widget — A draggable tree of autocomplete text fields.
- **Bricks (Nested)** formatter — Display the referenced entities recursively rendered by entity_view().
- [Paragraphs](https://www.drupal.org/project/paragraphs) support.

**Bricks Inline** <sup>8.x-1.1+</sup> — Integration with [Inline Entity Form](https://www.drupal.org/project/inline_entity_form):

- **Bricks tree (Inline entity form)** widget — A draggable tree of inline entity forms.

**Bricks Revisions** <sup>8.x-1.3+</sup> — Integration with [Entity Reference Revisions](https://www.drupal.org/project/entity_reference_revisions):

- **Bricks (revisioned)** field type — An entity field containing a tree of revisioned entity reference bricks.


## Compatibility

| Drupal | Bricks | [ECK](https://www.drupal.org/project/eck) | [IEF](https://www.drupal.org/project/inline_entity_form) | [ERR](https://www.drupal.org/project/entity_reference_revisions) | [Bricks Bootstrap](https://www.drupal.org/project/bricks_bootstrap) | [Paragraphs](https://www.drupal.org/project/paragraphs) | [Bootstrap Paragraphs](https://www.drupal.org/project/bootstrap_paragraphs) |
| --- | --- | --- | --- | --- | --- | --- | --- |
| **8.x** | **1.x** | **1.x** | **1.x** | **1.x** | **4.x** <sup>+ [Tweme](https://www.drupal.org/project/tweme) 4.x</sup> | **1.x** | **1.x** <sup>+ [Bootstrap](https://www.drupal.org/project/bootstrap) 3.x</sup> |
| 8.2.7 | 1.4 | 1.0-alpha3 | 1.0-beta1 | 1.2 | 4.1 | 1.1 | 1.0-beta1 |
| 8.2.6 | 1.2 | 1.0-alpha3 | 1.0-beta1 | — | 4.0 | — | — |


## Resources

- Project page: [drupal.org/project/bricks](https://www.drupal.org/project/bricks).
- Source code: [github.com/highweb/drupal-bricks](https://github.com/highweb/drupal-bricks).
- Issue board: [contribkanban.com/board/bricks](https://contribkanban.com/board/bricks).
- Working group: [groups.drupal.org/bricks](https://groups.drupal.org/bricks).
- Team: [timezone.io/team/drupal-bricks](https://timezone.io/team/drupal-bricks).


## FAQ

<dl>

<dt>Are brick bundles translatable?</dt>
<dd>100% translatable (thanks Entity Translation and ECK). Just mark them as translatable at /admin/config/regional/content-language.</dd>

<dt>Which entity types are supported?</dt>
<dd>Bricks can hold references to any entities - ECK or Paragraphs, doesn’t matter. And Bricks Bootstrap is just an example of using ECK.</dd>

<dt>Does bricks support revisions of the parent entity?</dt>
<dd>Internally Bricks field is a multi-value Entity Reference field => standard revisioning mechanism works. Moreover, Bricks Revisions (core submodule) allows you to revision referenced entities.</dd>

<dt>Is there a reason why i can not just use bricks form widget for the normal paragraphs field?</dt>
<dd>Paragraphs couldn’t be nested using drag and drop! Bricks field allows you to do (like on gif).</dd>

<dt>How to get non-equal column layout, 4-8 in example?</dt>
<dd>Use universal Wrapper brick with custom CSS classes on it. Bootstrap example:
<pre><code>
Wrapper (.row)
|-- Image (.col-sm-4)
|-- Text (.col-sm-8)
</code></pre>
</dd>

</dl>
