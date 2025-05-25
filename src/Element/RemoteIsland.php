<?php

declare(strict_types=1);

namespace Drupal\xbrew_render\Element;

use Drupal\Core\Render\Attribute\RenderElement;
use Drupal\Core\Render\Element\RenderElementBase;
use Drupal\experience_builder\Entity\JavaScriptComponent;

/**
 * Provides a render element to replace XB's astro_island.
 *
 * @see \Drupal\experience_builder\Element\AstroIsland
 */
#[RenderElement(self::PLUGIN_ID)]
final class RemoteIsland extends RenderElementBase {

  public const PLUGIN_ID = 'astro_island';

  /**
   * {@inheritdoc}
   *
   * @return array{
   *   '#pre_render': array<array{0: class-string, 1: string}>,
   *   '#slots': array<string, mixed>,
   *   '#props': array<string, mixed>,
   *   '#framework': string,
   *   '#preview': bool
   *   }
   */
  public function getInfo(): array {
    return [
      '#pre_render' => [
        [static::class, 'preRenderIsland'],
      ],
      '#slots' => [],
      '#props' => [],
      '#framework' => 'preact',
      '#preview' => FALSE,
    ];
  }

  /**
   * Pre-render callback.
   *
   * @param array<string, mixed> $element
   *   The element being processed.
   *
   * @return array<string, mixed>
   *   The processed element with the following structure:
   *   - '#plain_text'?: string
   *   - 'inline-template'?: array{
   *       '#type': string,
   *       '#template': string,
   *       '#context': array<string, mixed>
   *     }
   */
  public static function preRenderIsland(array $element): array {
    $component_name = $element['#name'] ?? NULL;
    if ($component_name === NULL) {
      return ['#plain_text' => \sprintf('You must pass a #name for an element of #type %s', self::PLUGIN_ID)];
    }

    if (!\is_string($component_name)) {
      return ['#plain_text' => \sprintf('The #name property must be a string, %s given', \get_debug_type($component_name))];
    }

    // @todo XB: Pass machine name and JS source to the element.
    $query = \Drupal::entityQuery('js_component')
      ->condition('name', $component_name)
      ->accessCheck(TRUE);
    /** @var array<int, string> $ids */
    $ids = $query->execute();

    if (empty($ids)) {
      return ['#plain_text' => \sprintf('No JavaScriptComponent found with name: %s', $component_name)];
    }

    $id = reset($ids);
    $component_entity = JavaScriptComponent::load($id);
    if ($component_entity === NULL) {
      return ['#plain_text' => \sprintf('Failed to load JavaScriptComponent with ID: %s', $id)];
    }

    // @todo XB: Add public method in JavaScriptComponent to get the JS source.
    $component = $component_entity->normalizeForClientSide()->values;

    $build = [
      '#type' => 'inline_template',
      '#template' => '<div style="border: 1px solid #ccc; padding: 10px;">
        <p style="font-weight: bold; font-size: 1.2em; margin-bottom: 10px;">xBrew Render: <code>{{ machine_name }}</code></p>
        <pre style="font-size: 0.75em;line-height: 1.25;">{{ js_source }}</pre>
      </div>',
      '#context' => [
        'machine_name' => $component['machineName'],
        'js_source' => $component['source_code_js'],
      ],
    ];
    $element['inline-template'] = $build;
    return $element;
  }

}
