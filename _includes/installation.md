## Installation

Default setup (Bricks/ECK/IEF):

1. Install **Bricks Default** (shipped with Bricks) and its dependencies.
2. **Done!** Now you can create **Bricky** pages (content type) using simple pre-configured ECK bricks like Text, Image, Wrapper and special Layout brick (which can render other bricks via [Layout API](https://www.drupal.org/docs/8/api/layout-api)). Use an auto-created node as a live playground.

Theming with Bootstrap 3/4:

1. Additionally install [Bootstrap Kit](https://www.drupal.org/project/bootstrap_kit) and its dependencies.
3. **Done!** Now you can use Columns, Accordion, Carousel and Tabs components via Layout brick. Install **Bootstrap Kit Demo** (shipped with Bootstrap Kit) to get a sample node.

<!--p><a href="https://uibricks.com/#installation">Using with Paragraphs</a> is also natively supported.</p-->

Using with Paragraphs:

1. Additionally install **Paragraphs Demo** (shipped with [Paragraphs](https://www.drupal.org/project/paragraphs)) and its dependencies.
2. Also install **Bricks Revisions** (shipped with **Bricks**) to be able to reference revisionable entities like Paragraphs.
3. Go to **Structure** > **Content types** > **Paragraphed article** > **Manage fields**.
4. Delete default **Paragraphs** field.
5. Create new **Paragraphs** field of type **Bricks (revisioned)**:
   - Name: *Paragraphs (field_paragraphs)*
   - Type of item to reference: *Paragraph*
   - Allowed number of values: *Unlimited*
6. Go to **Manage form display** and set **Bricks tree (Inline entity form)** widget for **Paragraphs** field.
7. Go to **Structure** > **Paragraphs types** and create **Layout** type.
8. **Done!** Now you can create **Paragraphed** pages (content type) using default Paragraphs as bricks: Text, Images, Image + Text, User and special Layout brick (which can render other bricks via [Layout API](https://www.drupal.org/docs/8/api/layout-api)).


## Requirements

All new Bricks for D8 has no requirements and works with ANY entity types!
