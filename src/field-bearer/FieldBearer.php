<?php

namespace UWDOEM\Framework\FieldBearer;

use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Field\FieldInterface;

/**
 * Class FieldBearer encapsulates a set of fields and child field bearers.
 * @package UWDOEM\Framework\FieldBearer
 */
class FieldBearer implements FieldBearerInterface
{

    /** @var FieldBearerInterface[] */
    protected $fieldBearers = [];

    /** @var FieldInterface[] */
    protected $fields = [];

    /** @var String[] */
    protected $visibleFieldNames = [];

    /** @var String[] */
    protected $hiddenFieldNames = [];

    /** @var callable */
    protected $saveFunction;

    use VisitableTrait;

    /**
     * @param FieldInterface[]       $fields
     * @param FieldBearerInterface[] $fieldBearers
     * @param string[]               $visibleFieldNames
     * @param string[]               $hiddenFieldNames
     * @param callable|null          $saveFunction
     */
    public function __construct(
        array $fields = [],
        array $fieldBearers = [],
        array $visibleFieldNames = [],
        array $hiddenFieldNames = [],
        $saveFunction = null
    ) {
        $this->fields = $fields;
        $this->fieldBearers = $fieldBearers;
        $this->visibleFieldNames = $visibleFieldNames;
        $this->hiddenFieldNames = $hiddenFieldNames;

        if (is_callable($saveFunction) === true) {
            $this->saveFunction = $saveFunction;
        }
    }

    /**
     * @param string                                   $fieldGetterFunction
     * @param \UWDOEM\Framework\Field\FieldInterface[] $initial
     * @return \UWDOEM\Framework\Field\FieldInterface[]
     */
    public function getFieldsBase($fieldGetterFunction, array $initial)
    {
        foreach ($this->fieldBearers as $name => $fieldBearer) {

            $fields = $fieldBearer->$fieldGetterFunction();

            $prefixedFieldNames = [];
            foreach (array_keys($fields) as $key => $name) {
                while (array_key_exists($name, $initial) === true
                    ||  in_array($name, $prefixedFieldNames, true) === true
                ) {
                    $name = "_" . $name;
                }
                $prefixedFieldNames[$key] = $name;
            }
            $fields = array_combine($prefixedFieldNames, $fields);
            $initial = array_merge($initial, $fields);
        }
        return $initial;
    }

    /**
     * Return the array of child fields.
     * @return \UWDOEM\Framework\Field\FieldInterface[]
     */
    public function getFields()
    {
        $base = $this->fields;
        return $this->getFieldsBase("getFields", $base);
    }

    /**
     * @return string[]
     */
    public function getFieldNames()
    {
        return array_keys($this->getFields());
    }

    /**
     * @return string[]
     */
    public function getVisibleFieldNames()
    {
        return array_keys($this->getVisibleFields());
    }

    /**
     * @return string[]
     */
    public function getHiddenFieldNames()
    {
        return array_keys($this->getHiddenFields());
    }

    /**
     * @return \UWDOEM\Framework\Field\FieldInterface[]
     */
    public function getVisibleFields()
    {
        $base = $this->fields;
        $visibleFields = $this->getFieldsBase("getVisibleFields", $base);

        if ($this->visibleFieldNames !== []) {
            $visibleFields = array_intersect_key($visibleFields, array_flip($this->visibleFieldNames));
            $visibleFields = array_merge(array_flip($this->visibleFieldNames), $visibleFields);
        } elseif ($this->hiddenFieldNames !== []) {
            $visibleFields = array_diff_key($visibleFields, array_flip($this->hiddenFieldNames));
        }
        return $visibleFields;
    }

    /**
     * @return \UWDOEM\Framework\Field\FieldInterface[]
     */
    public function getHiddenFields()
    {
        // Begin with a set of hidden fields from our child fieldBearers...
        $hiddenFields = $this->getFieldsBase("getHiddenFields", []);

        // If we have specified which fields should be hidden for this field bearer...
        if ($this->hiddenFieldNames !== []) {
            // then get those fields should be hidden...
            $myHiddenFields = array_intersect_key($this->getFields(), array_flip($this->hiddenFieldNames));
            // and merge them into the list
            $hiddenFields = array_merge($hiddenFields, $myHiddenFields);
        }

        // If we have specified which should be visible...
        if ($this->visibleFieldNames !== []) {
            // then subtract those fields from the list of hidden fields
            $hiddenFields = array_diff_key($hiddenFields, array_flip($this->visibleFieldNames));
        }

        return $hiddenFields;
    }

    /**
     * Return the labels of the child fields.
     *
     * @return String[]
     */
    public function getFieldLabels()
    {
        return array_map(
            function ($field) {
                return $field->getLabel();
            },
            $this->getFields()
        );
    }

    /**
     * Given a field's string name, return the field.
     *
     * @param string $name
     * @return \UWDOEM\Framework\Field\FieldInterface
     * @throws \Exception If the provided name is not found among this field bearer's fields.
     */
    public function getFieldByName($name)
    {
        return $this->baseGetThingByName("Field", $name);
    }

    /**
     * @param FieldInterface $field
     * @return string
     * @throws \Exception If $field is not among this bearer's fields.
     */
    public function getNameByField(FieldInterface $field)
    {

        $key = array_search($field, $this->getFields());
        if ($key === false) {
            throw new \Exception("Field not found among " . get_called_class() . "'s fields.");
        } else {
            return $key;
        }
    }

    /**
     * @param string $fieldName
     * @return string
     */
    protected function getLabelByFieldName($fieldName)
    {
        return $this->getFieldByName($fieldName)->getLabel();
    }

    /**
     * @return string[]
     */
    public function getLabels()
    {
        return array_map([$this, 'getLabelByFieldName'], $this->getFieldNames());
    }

    /**
     * @return string[]
     */
    public function getVisibleLabels()
    {
        return array_map([$this, 'getLabelByFieldName'], $this->getVisibleFieldNames());
    }

    /**
     * @return string[]
     */
    public function getHiddenLabels()
    {
        return array_map([$this, 'getLabelByFieldName'], $this->getHiddenFieldNames());
    }

    /**
     * @return FieldBearerInterface[]
     */
    public function getFieldBearers()
    {
        return $this->fieldBearers;
    }

    /**
     * @param string $thingType
     * @param string $name
     * @return mixed
     * @throws \Exception If the class does have a get{$thingType}ByName method, or the named
     *                    thing is not found by that method.
     */
    protected function baseGetThingByName($thingType, $name)
    {
        $getterName = "get" . $thingType . "s";

        if (method_exists($this, $getterName) === true) {
            $things = $this->$getterName();
        } else {
            throw new \Exception(
                "Method get$thingType/ByName not not supported by class " .
                get_called_class() . " because class does not contain a $getterName method."
            );
        }

        if (array_key_exists($name, $things) === true) {
            return $things[$name];
        } else {
            $thingNames = implode(" ", array_keys($things));
            throw new \Exception(
                "$thingType name $name not found among [$thingNames] of "
                . get_called_class() . "'s fieldBearers."
            );
        }
    }

    /**
     * @param string $name
     * @return FieldBearerInterface
     * @throws \Exception If the named field bearer is not found.
     */
    public function getFieldBearerByName($name)
    {
        return $this->baseGetThingByName("FieldBearer", $name);
    }

    /**
     * @return mixed
     */
    public function save()
    {
        if (is_callable($this->saveFunction) === true) {
            $args = func_get_args();
            $args = array_merge([$this], $args);

            return call_user_func_array($this->saveFunction, $args);
        } else {
            return null;
        }
    }
}
