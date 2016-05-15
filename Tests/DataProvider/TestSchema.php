<?php
/*
 * This file is a part of GraphQL project.
 *
 * @author Alexandr Viniychuk <a@viniychuk.com>
 * created: 10:48 PM 5/14/16
 */

namespace Youshido\Tests\DataProvider;


use Youshido\GraphQL\Config\Schema\SchemaConfig;
use Youshido\GraphQL\Schema\AbstractSchema;

class TestSchema extends AbstractSchema
{
    private $testStatusValue = 0;

    public function build(SchemaConfig $config)
    {
        $config->getQuery()->addFields([
            'me' => [
                'type' => new TestObjectType(),
                'resolve' => function($value, $args, TestObjectType $type) {
                    return $type->getData();
                }
            ],
            'status' => [
                'type' => new TestEnumType(),
                'resolve' => function() {
                    return $this->testStatusValue;
                }
            ],
        ]);
        $config->getMutation()->addFields([
            'updateStatus' => [
                'type' => new TestEnumType(),
                'resolve' => function() {
                    return $this->testStatusValue;
                },
                'args' => [
                    'newStatus' => new TestEnumType()
                ]
            ]
        ]);
    }


}