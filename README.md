# Bricks

**Bricks** — is a revolutionary new way of creating rich content in Drupal. Thanks to the powerful contributions like ECK and Entity Reference, Bricks itself is just 50 lines of code.

In terms of concept Bricks is a new generation of [Paragraphs](https://www.drupal.org/project/paragraphs), drop-in replacement for [Panelizer](https://www.drupal.org/project/panelizer) and a good friend to [Display Suite](https://www.drupal.org/project/ds) and [CKEditor](https://www.drupal.org/project/ckeditor) or any other [WYSIWYG](https://www.drupal.org/project/wysiwyg).

![Bricks UI](https://www.drupal.org/files/bricks-ui-8.x.png)


## Live sandbox

1. Open [pre-configured sandbox](https://bricks.tonystar.me/sandbox/8.x) on simplytest.me.
2. Click **Launch sandbox** and wait.
3. Follow the installation (all settings should be pre-filled, don't change them).
4. Go to **Extend** and install **Entity Construction Kit**.
5. Go to **Structure** > **ECK Entity Types** and create `brick` entity type.
6. Go to **Extend** and install **Bricks Bootstrap**.
7. Go to **Structure** > **Content types** > **Basic page** > **Manage fields** and delete default `body` field.
8. Go to **Manage form display**, set widget = **Inline entity form - Complex** for `field_body` and **Save**.
9. Go to **Manage display**, set label = **Hidden**, format = **Rendered entity** for `field_body` and **Save**.
10. Finally go to **Content** and create your first bricky page!


## Requirements

- [ECK](https://www.drupal.org/project/eck) = 1.x-dev + [this typo fix](https://www.drupal.org/node/2603526)


## Resources

- Project page: https://www.drupal.org/project/bricks
- Source code: https://github.com/highweb/drupal-bricks
- Issue board: https://contribkanban.com/board/bricks
- Working group: https://groups.drupal.org/bricks
- Team: http://timezone.io/team/drupal-bricks
