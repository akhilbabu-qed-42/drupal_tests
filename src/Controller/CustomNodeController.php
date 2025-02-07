<?php

declare(strict_types=1);

namespace Drupal\drupal_tests\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;

/**
 * Returns responses for drupal tests routes.
 */
final class CustomNodeController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke(NodeInterface $node): array {

    $title = $this->getTitle($node);
    $url = $node->toUrl()->toString();

    $build['#attached']['library'] = [
      'core/jquery',
      'core/drupal.dialog.ajax',
    ];

    $build['content'] = [
      '#type' => 'markup',
      '#markup' => $this->t('<h1><a href=":url" class="use-ajax" data-dialog-options="{&quot;width&quot;:800}" data-dialog-type="modal">@title</a></h1>', [
        '@title' => $title,
        ':url' => "$url",
      ]),
    ];

    return $build;
  }

  /**
   * Returns the title to render.
   */
  public function getTitle(NodeInterface $node): string {
    $updated_title = '"' . $node->bundle() . '" ' .  $node->getTitle();
    return self::process($updated_title);
  }

  /**
   * Update the text.
   */
  public static function process(string $title) {
    return 'You are viewing: ' . $title;
  }

}
