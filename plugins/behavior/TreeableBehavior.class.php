<?php

class TreeableBehavior extends EntityReference_BehaviorHandler_Abstract {
  public function schema_alter(&$schema, $field) {
    $schema['columns']['depth'] = array(
      'type' => 'int',
      'unsigned' => TRUE,
      'not null' => FALSE,
      'description' => 'The depth for this field item, used for multi-value fields stored as trees',
    );
  }
}
