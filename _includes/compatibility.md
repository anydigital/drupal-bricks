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
