<?php

declare(strict_types=1);

namespace Drupal\Tests\drupal_tests\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests user access.
 *
 * @group drupal_tests
 */
class UserAccessTest extends BrowserTestBase {

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
   * Ensures that users with proper permission can access the route.
   */
  public function testUserAccess(): void {
    // Check as a user without proper permission.
    $node = $this->drupalCreateNode([
      'type' => 'page',
      'title' => 'Home page'
    ]);
    $user1 = $this->drupalCreateUser([
      'access administration pages',
      'create page content',
      'edit any page content',
    ]);
    $this->drupalLogin($user1);
    $this->drupalGet($node->toUrl());
    $assert_session = $this->assertSession();
    // Click here link should not be there
    $assert_session->linkNotExists('Click here');
    $this->drupalGet('/get-node-title/' . $node->id());
    // User should get 403 if the path is loaded manually.
    $assert_session->statusCodeEquals(403);

    // Logout and try again with another user having proper permissions.
    $this->drupalLogout();

    $user1 = $this->drupalCreateUser([
      'access administration pages',
      'create page content',
      'edit any page content',
      'open node in modal'
    ]);
    $this->drupalLogin($user1);
    $this->drupalGet($node->toUrl());
    $assert_session = $this->assertSession();
    // Click here link should be there
    $assert_session->linkExists('Click here');
    $this->clickLink('Click here');
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExistsExact('You are viewing: "page" Home page');
  }

}
