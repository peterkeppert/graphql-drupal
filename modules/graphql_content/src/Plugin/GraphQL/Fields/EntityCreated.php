<?php

namespace Drupal\graphql_content\Plugin\GraphQL\Fields;

use Drupal\graphql_core\GraphQL\FieldPluginBase;
use Youshido\GraphQL\Execution\ResolveInfo;
use DateTime;

/**
 * Get the entities created date if available.
 *
 * @GraphQLField(
 *   id = "entity_created",
 *   name = "entityCreated",
 *   type = "String",
 *   types = {"Entity"}
 * )
 */
class EntityCreated extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function resolveValues($value, array $args, ResolveInfo $info) {
    // `getCreatedTime` is on NodeInterface which feels weird, since there
    // is a generic `EntityInterface`. Checking for method existence for now.
    if (method_exists($value, 'getCreatedTime')) {
      $datetime = new DateTime();
      $datetime->setTimestamp($value->getCreatedTime());
      yield $datetime->format(DateTime::ISO8601);
    }
  }

}
