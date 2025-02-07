<?php

declare(strict_types=1);

namespace Drupal\Tests\drupal_tests\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

/**
 * Tests the modal.
 *
 * @group block
 */
class ModalTest extends WebDriverTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'drupal_tests',
    'node',
    'block'
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->drupalCreateContentType(['type' => 'page']);
    $this->drupalPlaceBlock('local_tasks_block');
  }

  /**
   * Test that remove/configure contextual links are present in the block.
   */
  public function testModal(): void {
    // Check as a user without proper permission.
    $node = $this->drupalCreateNode([
      'type' => 'page',
      'title' => 'Home page'
    ]);

    $this->drupalLogin($this->rootUser);
    $this->drupalGet($node->toUrl());
    $assert_session = $this->assertSession();
    // Click here link should be there
    $assert_session->linkExists('Click here');
    $this->clickLink('Click here');
    $assert_session->linkExistsExact('You are viewing: "page" Home page');
    $this->clickLink('You are viewing: "page" Home page');
    $this->assertNotEmpty($this->assertSession()->waitForElement('css', '#drupal-modal'));
    sleep(5);
  }

}
