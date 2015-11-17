# Drupal Bricks

**Bricks** — is a revolutionary new way of creating rich content in Drupal. Thanks to the powerful contributions like ECK and Entity Reference, Bricks itself is just 200 lines of code.

In terms of concept Bricks is a new generation of [Paragraphs](https://www.drupal.org/project/paragraphs), drop-in replacement for [Panelizer](https://www.drupal.org/project/panelizer) and a good friend to [Display Suite](https://www.drupal.org/project/ds) and [WYSIWYG](https://www.drupal.org/project/ckeditor).

![Bricks UI](https://www.drupal.org/files/bricks-ui.png)


## Live sandbox

1. Open [pre-configured sandbox](https://ply.st/bricks_bootstrap/7.x-3.x) on simplytest.me.
2. Click **Launch sandbox** and wait.
3. Click **Log in** (email and password should be pre-filled).
4. Go to **Appearance** and click **Set default** near the Bootstap theme.
5. Go to **Structure** > **Content types** > **Page** > **Manage fields** and:
   - **Edit** and **Save** `field_body` (this enforces Field API to alter database schema).
   - Optionally **Delete** useless `body` field.
6. Finally click **Add content** on the toolbar and create your first bricky page!


## Requirements

- [ECK](https://www.drupal.org/project/eck) >= 2.0
- [Entity Reference](https://www.drupal.org/project/entityreference) >= 1.1
- [Tree](https://www.drupal.org/project/tree) = 1.x-dev


## Resources

- Project page: https://www.drupal.org/project/bricks
- Source code: https://github.com/highweb/drupal-bricks
- Issue board: https://contribkanban.com/board/bricks
- Working group: https://groups.drupal.org/bricks
- Team: http://timezone.io/team/drupal-bricks
