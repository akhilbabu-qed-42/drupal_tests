<?php

namespace Drupal\Tests\drupal_tests\Unit;

use Drupal\drupal_tests\Controller\CustomNodeController;
use Drupal\node\NodeInterface;
use Drupal\Tests\UnitTestCase;

/**
 * Unit tests for the controller.
 *
 * @group drupal_tests
 */
class CustomNodeControllerTest2 extends UnitTestCase {

  /**
   * Tests the getTitle method.
   *
   * @covers ::getTitle
   */
  public function testgetTitle() {
    $node = $this->prophesize(NodeInterface::class);
    $node->bundle()->willReturn('page');
    $node->getTitle()->willReturn('Home page');

    $controller = new CustomNodeController();
    $title = $controller->getTitle($node->reveal());

    $this->assertEquals('You are viewing: "page" Home page', $title);
  }
}
