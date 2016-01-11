<?php

namespace UWDOEM\Framework\FieldBearer;

use Propel\Runtime\ActiveRecord\ActiveRecordInterface;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\Etc\ORMUtils;
use UWDOEM\Framework\Field\FieldInterface;
use UWDOEM\Framework\Field\Field;

/**
 * Class FieldBearerBuilder
 * @package UWDOEM\Framework\FieldBearer
 */
class FieldBearerBuilder extends AbstractBuilder
{
    /** @var FieldBearerInterface[] */
    protected $fieldBearers = [];

    /** @var FieldInterface[] */
    protected $fields = [];

    /** @var string[] */
    protected $visibleFieldNames = [];

    /** @var string[] */
    protected $hiddenFieldNames = [];

    /** @var mixed[] */
    private $initialFieldValues = [];

    /** @var string[] */
    private $fieldLabels = [];

    /** @var mixed[] */
    private $fieldChoices = [];

    /** @var callable */
    protected $saveFunction;

    /** @var boolean */
    protected $makeLiteral = false;

    /**
     * @param FieldBearerInterface[] $fieldBearers
     * @return FieldBearerBuilder
     */
    public function addFieldBearers(array $fieldBearers)
    {
        $this->fieldBearers = array_merge($this->fieldBearers, $fieldBearers);
        return $this;
    }

    /**
     * @param FieldInterface[] $fields
     * @return FieldBearerBuilder
     */
    public function addFields(array $fields)
    {

        $fieldBearer = new FieldBearer(
            $fields,
            [],
            [],
            [],
            function () {
            }
        );

        $this->addFieldBearers([$fieldBearer]);
        return $this;
    }

    /**
     * @param ActiveRecordInterface $object
     * @return FieldBearerBuilder
     */
    public function addObject(ActiveRecordInterface $object)
    {
        $saveFunction = function (ClassFieldBearer $fieldBearer) use ($object) {

            ORMUtils::fillObjectFromFields($object, $fieldBearer->getFields());
            $object->save();

            $primaryKey = $object->getId();

            foreach ($fieldBearer->getFields() as $field) {
                if ($field->getType() === Field::FIELD_TYPE_PRIMARY_KEY) {
                    $field->setInitial($primaryKey);
                    break;
                }
            }
        };
        $this->addFieldBearers([new ClassFieldBearer($object, $saveFunction)]);
        return $this;
    }

    /**
     * @param string $classTableMapName
     * @return FieldBearerBuilder
     */
    public function addClassTableMapName($classTableMapName)
    {
        $object = ORMUtils::makeNewObjectFromClassTableMapName($classTableMapName);
        return $this->addObject($object);
    }

    /**
     * @param \string[] $visibleFieldNames
     * @return FieldBearerBuilder
     */
    public function setVisibleFieldNames(array $visibleFieldNames)
    {
        $this->visibleFieldNames = $visibleFieldNames;
        return $this;
    }

    /**
     * @param string[] $hiddenFieldNames
     * @return FieldBearerBuilder
     */
    public function setHiddenFieldNames(array $hiddenFieldNames)
    {
        $this->hiddenFieldNames = $hiddenFieldNames;
        return $this;
    }

    /**
     * @param callable $saveFunction
     * @return FieldBearerBuilder
     */
    public function setSaveFunction(callable $saveFunction)
    {
        $this->saveFunction = $saveFunction;
        return $this;
    }

    /**
     * @param string $fieldName
     * @param mixed  $value
     * @return FieldBearerBuilder
     */
    public function setInitialFieldValue($fieldName, $value)
    {
        $this->initialFieldValues[$fieldName] = $value;

        return $this;
    }

    /**
     * @param string $fieldName
     * @param mixed  $label
     * @return FieldBearerBuilder
     */
    public function setFieldLabel($fieldName, $label)
    {
        $this->fieldLabels[$fieldName] = $label;

        return $this;
    }

    /**
     * @param string $fieldName
     * @param array  $choices
     * @return FieldBearerBuilder
     */
    public function setFieldChoices($fieldName, array $choices)
    {
        $this->fieldChoices[$fieldName] = $choices;

        return $this;
    }

    /**
     * @return FieldBearerBuilder
     */
    public function makeLiteral()
    {
        $this->makeLiteral = true;

        return $this;
    }

    /**
     * @return FieldBearer
     * @throws \Exception If neither fields nor fieldBearers has been set.
     */
    public function build()
    {
        if ($this->saveFunction === null) {
            $this->saveFunction = function (FieldBearerInterface $fieldBearer) {
                foreach ($fieldBearer->getFieldBearers() as $childFieldBearer) {
                    $args = array_merge([$fieldBearer], func_get_args());

                    $func = [$childFieldBearer, "save"];
                    call_user_func_array($func, $args);
                }
            };
        }

        $fieldBearer = new FieldBearer(
            $this->fields,
            $this->fieldBearers,
            $this->visibleFieldNames,
            $this->hiddenFieldNames,
            $this->saveFunction
        );

        if ($this->makeLiteral === true) {
            foreach ($fieldBearer->getFields() as $field) {
                if ($field->getType() !== Field::FIELD_TYPE_SECTION_LABEL) {
                    $field->setType(Field::FIELD_TYPE_LITERAL)->setRequired(false);
                }
            }
        }

        foreach ($this->initialFieldValues as $fieldName => $value) {
            $fieldBearer->getFieldByName($fieldName)->setInitial($value);
        }

        foreach ($this->fieldLabels as $fieldName => $label) {
            $fieldBearer->getFieldByName($fieldName)->setLabel($label);
        }

        foreach ($this->fieldChoices as $fieldName => $choices) {
            $field = $fieldBearer->getFieldByName($fieldName);

            $field->setType(Field::FIELD_TYPE_CHOICE);
            $field->setChoices($choices);
        }

        return $fieldBearer;
    }
}
