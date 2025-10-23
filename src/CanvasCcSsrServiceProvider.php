<?php

declare(strict_types=1);

namespace Drupal\canvas_cc_ssr;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\canvas_cc_ssr\Element\RemoteIsland;

/**
 * Service provider for Canvas CC SSR.
 */
class CanvasCcSsrServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container): void {
    $container->getDefinition('plugin.manager.element_info')
      ->addMethodCall('setClass', ['astro_island', RemoteIsland::class]);
  }

}
