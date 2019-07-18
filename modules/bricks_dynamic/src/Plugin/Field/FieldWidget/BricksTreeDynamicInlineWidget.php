<?php

namespace Drupal\bricks_dynamic\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\inline_entity_form\Plugin\Field\FieldWidget\InlineEntityFormComplex;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityDisplayRepositoryInterface;
use Drupal\Component\Utility\NestedArray;
use Drupal\dynamic_entity_reference\Plugin\Field\FieldType\DynamicEntityReferenceItem;

/**
 * {@inheritdoc}
 *
 * @FieldWidget(
 *   id = "bricks_tree_dynamic_inline",
 *   label = @Translation("Bricks tree Dynamic (Inline entity form)"),
 *   description = @Translation("A tree of inline entity forms."),
 *   field_types = {
 *     "bricks_dynamic"
 *   },
 *   multiple_values = true
 * )
 */
class BricksTreeDynamicInlineWidget extends InlineEntityFormComplex {


  /**
   * Module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  protected $entityType;

  /**
   * Constructs a InlineEntityFormBase object.
   *
   * @param array $plugin_id
   *   The plugin_id for the widget.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the widget is associated.
   * @param array $settings
   *   The widget settings.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_type_bundle_info
   *   The entity type bundle info.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Entity\EntityDisplayRepositoryInterface
   *   The entity display repository.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   Module handler service.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, array $third_party_settings, EntityTypeBundleInfoInterface $entity_type_bundle_info, EntityTypeManagerInterface $entity_type_manager, EntityDisplayRepositoryInterface $entity_display_repository, ModuleHandlerInterface $module_handler) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings, $entity_type_bundle_info, $entity_type_manager, $entity_display_repository, $module_handler);
    $this->moduleHandler = $module_handler;
  }


  /**
   * Creates an instance of the inline form handler for the current entity type.
   */
  protected function createInlineFormHandler() {
    if (!isset($this->inlineFormHandler) && $this->getEntityType()) {
      $entity_type = $this->getEntityType();
      $this->inlineFormHandler = $this->entityTypeManager->getHandler($entity_type, 'inline_form');
    }
  }

  protected function getEntityType() {
    $name = $this->fieldDefinition->getName();

    // TODO explain why this is used.
    if (isset($_POST[$name]['actions']['entity_type'])) {
      return $_POST[$name]['actions']['entity_type'];
    }
    $entity_types = DynamicEntityReferenceItem::getTargetTypes($this->fieldDefinition->getSettings());

    if (isset($entity_types[0])) {
      return $entity_types[0];
    }
  }


  /**
   * Returns the array of field settings.
   *
   * @return array
   *   The array of settings.
   */
  protected function getFieldSettings() {
    $settings = $this->fieldDefinition->getSettings();
    $settings['target_type'] = $this->getEntityType();
    return $settings;
  }

  /**
   * Returns the value of a field setting.
   *
   * @param string $setting_name
   *   The setting name.
   *
   * @return mixed
   *   The setting value.
   */
  protected function getFieldSetting($setting_name) {
    if ($setting_name == 'target_type') {
      return $this->getEntityType();
    }

    return $this->fieldDefinition->getSetting($setting_name);
  }


  /**
   * Gets the target bundles for the current field.
   *
   * @return string[]
   *   A list of bundles.
   */
  protected function getTargetBundles() {
    $target_bundles = [];
    $entity_type = $this->getEntityType();
    $field_settings = $this->getFieldSettings();
    if (isset($field_settings[$entity_type]) && isset($field_settings[$entity_type]['handler_settings']['target_bundles'])) {
      $entity_type_settings = $field_settings[$entity_type];
      $target_bundles = array_values($entity_type_settings['handler_settings']['target_bundles']);
    }

    return $target_bundles;
  }

  /**
   * Gets the access handler for the target entity type.
   *
   * @return \Drupal\Core\Entity\EntityAccessControlHandlerInterface
   *   The access handler.
   */
  protected function getAccessHandler() {
    return $this->entityTypeManager->getAccessControlHandler($this->getEntityType());
  }

  /**
   * {@inheritdoc}
   */
  public function form(FieldItemListInterface $items, array &$form, FormStateInterface $form_state, $get_delta = NULL) {
    $elements = parent::form($items, $form, $form_state, $get_delta);

    // Signal to content_translation that this field should be treated as
    // multilingual and not be hidden, see
    // \Drupal\content_translation\ContentTranslationHandler::entityFormSharedElements().
    $elements['#multilingual'] = TRUE;
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $element['entities']['#widget'] = 'bricks_tree_inline';

    $allowed_entity_types = DynamicEntityReferenceItem::getTargetTypes($this->getFieldSettings());

    $entity_type_definitions = \Drupal::entityTypeManager()->getDefinitions();

    $entity_type_options = [];

    foreach ($allowed_entity_types as $allowed_entity_type) {
      if (isset($entity_type_definitions[$allowed_entity_type])) {
        $entity_type_options[$allowed_entity_type] = $entity_type_definitions[$allowed_entity_type]->getLabel();
      }
    }

    $element['actions']['entity_type'] = [
      '#type' => 'select',
      '#options' => $entity_type_options,
      '#default_value' => $this->getEntityType(),
      '#weight' => -9,
      '#ajax' => [
        'callback' => [$this, 'rebuild'],
        'wrapper' => 'inline-entity-form-' . $element['#ief_id']
      ]
    ];

    $element['actions']['bundle']['#element_validate'] = [[$this, 'correctBundle']];

    $entities = $form_state->get(['inline_entity_form', $this->getIefId(), 'entities']);
    foreach ($entities as $delta => $value) {
      _bricks_form_element_alter($element['entities'][$delta], $items[$delta], $value['entity']);
    }

    return $element;
  }

  public function rebuild(array &$form, FormStateInterface $form_state) {
    $parents = $form_state->getTriggeringElement()['#parents'];
    array_pop($parents);
    array_pop($parents);
    $fieldset = NestedArray::getValue($form, $parents);

    return $fieldset;
  }

  public function correctBundle(array &$element, FormStateInterface $form_state) {
    if (!isset($element['#options'][$element['#value']])) {
      $form_state->clearErrors();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    $field_name = $this->fieldDefinition->getName();
    $field_value = $form_state->getValue($field_name);

    foreach ($values as $delta => $value) {
      if (isset($field_value['entities'][$delta])) {
        $values[$delta]['depth'] = $field_value['entities'][$delta]['depth'];
        if (isset($field_value['entities'][$delta]['options'])) {
          $values[$delta]['options'] = $field_value['entities'][$delta]['options'];
        }
      }
    }

    return $values;

  }
}
