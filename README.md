# Bricks

[![Gitter](https://img.shields.io/gitter/room/highweb/drupal-bricks.svg)](https://gitter.im/highweb/drupal-bricks)
[![Timezone](https://img.shields.io/badge/time-zone-4682b4.svg)](https://timezone.io/team/drupal-bricks)
[![retweet](https://img.shields.io/badge/re-tweet-00bfff.svg)](https://twitter.com/highwebtech/status/841004866633842689)

**Bricks** — is a new way of building pages on top of Entity Reference, Display Modes, Layout API, tabledrag.js and [Flat Tables](http://evolt.org/node/4047#table). Everything is in Drupal core that makes Bricks ultra-lightweight and developer-friendly.

In terms of concept Bricks is a new generation of Paragraphs, an alternative to Panelizer and a good friend to ECK, Inline Entity Form and your favorite WYSIWYG. Shortly, it allows you to nest Entity Reference field items using Drupal drag & drop UI (exactly like for menu or taxonomy items).

<img src="https://cdn.rawgit.com/highweb/drupal-bricks/media/bricks-8.x-1.2.gif" width="608"/>


## Live demo

1. Open [pre-configured sandbox](https://simplytest.me/project/bricks).
2. Click **Launch sandbox** and wait.
3. Follow the installation (all settings should be pre-filled, don't change them).
4. Go to **Extend** and enable **Bootstrap Kit Demo**.
5. Go to **Appearance** and set **Tweme** as default theme.
6. Find an auto-created node and go to **Edit** mode to check magic out!
7. Finally go to **Content** and create your own first **Bricky** page!


## Requirements

All new Bricks for D8 has no requirements and works with ANY entity types!


## Compatibility

| Drupal | Bricks | Layout API | [ECK](https://www.drupal.org/project/eck) | [IEF](https://www.drupal.org/project/inline_entity_form) | [ERR](https://www.drupal.org/project/entity_reference_revisions) | [Paragraphs](https://www.drupal.org/project/paragraphs) |
| --- | --- | --- | --- | --- | --- | --- |
| 8.3.3 | 1.6 | ✔ | 1.0-alpha3 | 1.0-beta1 | 1.3 | 1.1 |
| 8.3.2 | 1.5 | — | 1.0-alpha3 | 1.0-beta1 | 1.3 | 1.1 |
| 8.2.6 | 1.2 | — | 1.0-alpha3 | 1.0-beta1 | — | — |

### Upgrading from 8.x-1.5

1. Upgrade as usual.
2. Create **Layout** bundle manually to be able to use the newest Layout API integration:
   - ECK: Structure > ECK > Bundle list > Add bundle.
   - Paragraphs: Structure > Paragraphs > Add type.
3. Don't forget to allow this bundle in your Bricks field settings!


## Resources

- Home page: https://uibricks.com
- Project page: https://www.drupal.org/project/bricks
- Source code: https://github.com/highweb/drupal-bricks
- Issue board: https://contribkanban.com/board/bricks
- Working group: https://groups.drupal.org/bricks
- Team: http://timezone.io/team/drupal-bricks
