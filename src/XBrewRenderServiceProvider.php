<?php

declare(strict_types=1);

namespace Drupal\xbrew_render;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\xbrew_render\Element\RemoteIsland;

/**
 * Service provider for xBrew Render.
 */
class XBrewRenderServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container): void {
    $container->getDefinition('plugin.manager.element_info')
      ->addMethodCall('setClass', ['astro_island', RemoteIsland::class]);
  }

}
