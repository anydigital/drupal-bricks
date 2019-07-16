<?php

namespace Drupal\bricks\EventSubscriber;

use Drupal\paragraphs\EventSubscriber\ReplicateFieldSubscriber as BaseReplicateFieldSubscriber;
use Drupal\replicate\Events\ReplicatorEvents;

/**
 * Event subscriber that handles cloning through the Replicate module.
 */
class ReplicateFieldSubscriber extends BaseReplicateFieldSubscriber {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[ReplicatorEvents::replicateEntityField('bricks_revisioned')][] = 'onClone';
    return $events;
  }

}
