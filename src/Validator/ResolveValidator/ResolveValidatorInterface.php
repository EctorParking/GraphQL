<?php
/**
 * Date: 01.12.15
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\GraphQL\Validator\ResolveValidator;


use Youshido\GraphQL\Field\Field;
use Youshido\GraphQL\Parser\Ast\Query;
use Youshido\GraphQL\Request;
use Youshido\GraphQL\Type\AbstractType;

interface ResolveValidatorInterface
{

    /**
     * @param $field
     * @param $query     Query
     * @param $request   Request
     *
     * @return bool
     */
    public function validateArguments(Field $field, $query, Request $request);

    /**
     * @param mixed        $value
     * @param AbstractType $type
     *
     * @return bool
     */
    public function validateResolvedValue($value, $type);
}
