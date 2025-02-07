<?php

namespace Drupal\Tests\drupal_tests\Unit;

use Drupal\drupal_tests\Controller\CustomNodeController;
use Drupal\Tests\UnitTestCase;

/**
 * Unit tests for the controller.
 *
 * @group drupal_tests
 */
class CustomNodeControllerTest extends UnitTestCase {

  /**
   * Tests the process method.
   *
   * @covers ::process
   */
  public function testProcess() {
    $this->assertEquals(CustomNodeController::process('Home page'), 'You are viewing: Home page');
  }

}
