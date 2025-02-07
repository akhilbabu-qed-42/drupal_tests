<?php

declare(strict_types=1);

namespace Drupal\Tests\drupal_tests\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group drupal_tests
 */
class CustomNodeTitleAccessTest extends KernelTestBase {


  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'node',
    'user',
    'drupal_tests',
    'system'
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installEntitySchema('node');
    $this->installEntitySchema('user');
    $node_type = NodeType::create([
      'type' => 'page',
      'name' => 'Page',
    ]);
    $node_type->save();
  }


  /**
   * Verifies that anonymous user cannot access the page.
   */
  public function testAnonymousUserAccess(): void {
    // Create a new node.
    $page = Node::create([
      'type' => 'page',
      'title' => 'Home page',
    ]);
    $page->save();

    $id = $page->id();

    $http_kernel = $this->container->get('http_kernel');

    $request = Request::create('/get-node-title/' . $id);

    $response = $http_kernel->handle($request);
    $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());


  }

}