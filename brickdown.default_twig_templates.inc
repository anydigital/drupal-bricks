<?php
/**
 * @file
 * brickdown.default_twig_templates.inc
 */

/**
 * Implements hook_default_twig_template().
 */
function brickdown_default_twig_template() {
  $export = array();

  $template = new stdClass();
  $template->disabled = FALSE; /* Edit this to true to make a default template disabled initially */
  $template->api_version = 1;
  $template->name = 'brick.html.twig';
  $template->template = '<h3>{{ title }}</h3>
{{ body|raw }}';
  $export['brick.html.twig'] = $template;

  $template = new stdClass();
  $template->disabled = FALSE; /* Edit this to true to make a default template disabled initially */
  $template->api_version = 1;
  $template->name = 'stack.html.twig';
  $template->template = '{% for brick in bricks %}
{% set brick = brick|merge({\'template\': \'brick.html.twig\'}) %}
{% include brick.template with brick only %}
{% endfor %}
';
  $export['stack.html.twig'] = $template;

  return $export;
}
