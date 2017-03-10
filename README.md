# Bricks

[![Gitter](https://img.shields.io/gitter/room/highweb/drupal-bricks.svg)](https://gitter.im/highweb/drupal-bricks)
[![Timezone](https://img.shields.io/badge/time-zone-4682b4.svg)](https://timezone.io/team/drupal-bricks)

**Bricks** — is a revolutionary new way of creating rich content in Drupal. Thanks to the powerful contributions like ECK and Entity Reference, Bricks itself is just ~9 KB of code.

In terms of concept Bricks is a new generation of [Paragraphs](https://www.drupal.org/project/paragraphs), drop-in replacement for [Panelizer](https://www.drupal.org/project/panelizer) and a good friend to [Display Suite](https://www.drupal.org/project/ds) and [CKEditor](https://www.drupal.org/project/ckeditor) or any other [WYSIWYG](https://www.drupal.org/project/wysiwyg).

![Bricks UI](https://www.drupal.org/files/bricks-ui-8.x.png)


## Live demo

1. Open [pre-configured sandbox](https://simplytest.me/project/bricks/8.x-1.x) on simplytest.me.
2. Click **Launch sandbox** and wait.
3. Follow the installation (all settings should be pre-filled, don't change them).
4. Go to **Extend** and install **Bricks Bootstrap**.
5. Go to **Appearance**, install **Tweme** and set as default theme.
6. Finally go to **Content** and create your first **Bricky** page!

Proposed page layout:

```
Columns
|-- Image
|-- Text
|-- Text
```

You can nest items using Drupal drag & drop UI (like for menu or taxonomy items).


## Requirements

All new Bricks for D8 has no requirements and works with ANY entity types!

*Just make sure nested entities have a proper templates, like `templates/brick--columns.html.twig`.*


## Resources

- Project page: https://www.drupal.org/project/bricks
- Source code: https://github.com/highweb/drupal-bricks
- Issue board: https://contribkanban.com/board/bricks
- Working group: https://groups.drupal.org/bricks
- Team: http://timezone.io/team/drupal-bricks
