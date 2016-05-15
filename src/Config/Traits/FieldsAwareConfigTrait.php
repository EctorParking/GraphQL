<?php
/*
* This file is a part of graphql-youshido project.
*
* @author Alexandr Viniychuk <a@viniychuk.com>
* created: 12/1/15 11:05 PM
*/

namespace Youshido\GraphQL\Config\Traits;


use Youshido\GraphQL\Field\Field;
use Youshido\GraphQL\Field\InputField;
use Youshido\GraphQL\Type\AbstractType;
use Youshido\GraphQL\Type\TypeFactory;
use Youshido\GraphQL\Type\TypeMap;
use Youshido\GraphQL\Type\TypeService;
use Youshido\GraphQL\Validator\Exception\ConfigurationException;

/**
 * Class FieldsAwareTrait
 * @package Youshido\GraphQL\Config\Traits
 */
trait FieldsAwareConfigTrait
{
    protected $fields = [];

    public function buildFields()
    {
        if (!empty($this->data['fields'])) {
            $this->addFields($this->data['fields']);
        }
    }

    /**
     * @param array $fieldsList
     * @return $this
     */
    public function addFields($fieldsList)
    {
        foreach ($fieldsList as $fieldName => $fieldConfig) {

            if ($fieldConfig instanceof Field) {
                $this->fields[$fieldConfig->getName()] = $fieldConfig;
                continue;
            } else {
                $this->addField($fieldName, $this->buildFieldConfig($fieldName, $fieldConfig));
            }
        }

        return $this;
    }

    /**
     * @param Field|string $field Field name or Field Object
     * @param mixed        $fieldInfo Field Type or Field Config array
     * @return $this
     */
    public function addField($field, $fieldInfo = null)
    {
        if (!($field instanceof Field)) {
            $field = new Field($this->buildFieldConfig($field, $fieldInfo));
        }
        $this->fields[$field->getName()] = $field;

        return $this;
    }

    protected function buildFieldConfig($name, $info = null)
    {
        if (!is_array($info)) {
            return [
                'type' => $info,
                'name' => $name
            ];
        }
        if (empty($info['name'])) {
            $info['name'] = $name;
        }

        return $info;
    }

    /**
     * public function addFieldOld($name, $type, $config = [])
     * {
     * if (is_string($type)) {
     * if (!TypeService::isScalarType($type)) {
     * throw new ConfigurationException('You can\'t pass ' . $type . ' as a string type.');
     * }
     *
     * $type = TypeFactory::getScalarType($type);
     * } else {
     * if (empty($config['resolve']) && (method_exists($type, 'resolve'))) {
     * $config['resolve'] = [$type, 'resolve'];
     * }
     * }
     *
     * $config['name'] = $name;
     * $config['type'] = $type;
     *
     * if (
     * isset($this->contextObject)
     * && method_exists($this->contextObject, 'getKind')
     * && $this->contextObject->getKind() == TypeMap::KIND_INPUT_OBJECT
     * ) {
     * $field = new InputField($config);
     * } else {
     * $field = new Field($config);
     * }
     *
     *
     * $this->fields[$name] = $field;
     *
     * return $this;
     * }
     */
    /**
     * @param $name
     *
     * @return Field
     */
    public function getField($name)
    {
        return $this->hasField($name) ? $this->fields[$name] : null;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasField($name)
    {
        return array_key_exists($name, $this->fields);
    }

    public function hasFields()
    {
        return !empty($this->fields);
    }

    /**
     * @return Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    public function removeField($name)
    {
        if ($this->hasField($name)) {
            unset($this->fields[$name]);
        }

        return $this;
    }
}
