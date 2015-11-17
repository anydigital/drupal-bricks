<?php

class EROptionsBehavior extends EntityReference_BehaviorHandler_Abstract {

  public function schema_alter(&$schema, $field) {
    $schema['columns']['options'] = array(
      'type' => 'blob',
      'size' => 'big',
      'description' => 'Serialized data containing the target entity view options.',
    );
  }

  public function load($entity_type, $entities, $field, $instances, $langcode, &$items) {
    foreach ($items as &$by_entity) {
      foreach ($by_entity as &$item) {
        $item['options'] = unserialize($item['options']);
      }
    }
  }

  public function insert($entity_type, $entity, $field, $instance, $langcode, &$items) {
    foreach ($items as &$item) {
      $item['options'] = serialize($item['options']);
    }
  }

  public function update($entity_type, $entity, $field, $instance, $langcode, &$items) {
    foreach ($items as &$item) {
      $item['options'] = serialize($item['options']);
    }
  }

}
