## Installation

The most easy-to-use method:

1. Download and install [Bricks Bootstrap](https://www.drupal.org/project/bricks_bootstrap) with its dependencies.
2. Download and enable [Tweme](https://www.drupal.org/project/tweme) (or any other Bootstrap 4 theme).
3. **Done!**

Now you can create **Bricky** pages (content type) using powerful preconfigured **Bricks** such as Text, Image, Accordion, Carousel, Tabs and others (ECK bundles). Use auto-created "All new AirPods" node as a live playground.

Video tutorial: [vimeo.com/211714437](https://vimeo.com/211714437).

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
