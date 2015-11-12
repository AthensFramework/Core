<?php

namespace UWDOEM\Framework\FieldBearer;

use UWDOEM\Framework\Etc\ORMUtils;
use UWDOEM\Framework\Field\FieldInterface;
use UWDOEM\Framework\Field\Field;


class FieldBearerBuilder {

    /**
     * @var FieldBearerInterface[]
     */
    protected $_fieldBearers = [];

    /**
     * @var FieldInterface[]
     */
    protected $_fields = [];

    /**
     * @var string[]
     */
    protected $_visibleFieldNames;

    /**
     * @var string[]
     */
    protected $_hiddenFieldNames;

    /**
     * @var callable
     */
    protected $_saveFunction;

    /**
     * @param FieldBearerInterface[] $fieldBearers
     * @return FieldBearerBuilder
     */
    public function addFieldBearers($fieldBearers)
    {
        $this->_fieldBearers = array_merge($this->_fieldBearers, $fieldBearers);
        return $this;
    }

    /**
     * @param FieldInterface[] $fields
     * @return FieldBearerBuilder
     */
    public function addFields($fields) {

        $fieldBearer = new FieldBearer(
            $fields,
            [],
            [],
            [],
            function() {}
        );

        $this->addFieldBearers([$fieldBearer]);
        return $this;
    }

    /**
     * @param \Propel\Runtime\ActiveRecord\ActiveRecordInterface $object
     * @return FieldBearerBuilder
     */
    public function addObject($object) {
        $saveFunction = function(ClassFieldBearer $fieldBearer) use ($object) {

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
    public function addClassTableMapName($classTableMapName) {
        $object = ORMUtils::makeNewObjectFromClassTableMapName($classTableMapName);
        return $this->addObject($object);
    }

    /**
     * @param \string[] $visibleFieldNames
     * @return FieldBearerBuilder
     */
    public function setVisibleFieldNames($visibleFieldNames)
    {
        $this->_visibleFieldNames = $visibleFieldNames;
        return $this;
    }

    /**
     * @param string[] $hiddenFieldNames
     * @return FieldBearerBuilder
     */
    public function setHiddenFieldNames($hiddenFieldNames)
    {
        $this->_hiddenFieldNames = $hiddenFieldNames;
        return $this;
    }

    /**
     * @param callable $saveFunction
     * @return FieldBearerBuilder
     */
    public function setSaveFunction($saveFunction)
    {
        $this->_saveFunction = $saveFunction;
        return $this;
    }


    /**
     * @return FieldBearerBuilder
     */
    public static function begin() {
        return new static();
    }

    /**
     * @return FieldBearerBuilder
     */
    public function clear() {
        $this->_fieldBearers = [];
        $this->_fields = [];
        $this->_visibleFieldNames = null;
        $this->_hiddenFieldNames = null;
        $this->_saveFunction = null;

        return $this;
    }

    /**
     * @return FieldBearer
     * @throws \Exception if neither fields nor fieldBearers has been set
     */
    public function build() {
//        if (!$this->_fields && !$this->_fieldBearers) {
//            throw new \Exception("Must make fields and/or fieldBearers before calling this method.");
//        }

        if (!$this->_saveFunction) {
            $this->_saveFunction = function (FieldBearerInterface $fieldBearer) {
                foreach ($fieldBearer->getFieldBearers() as $childFieldBearer) {
                    $args = array_merge([$fieldBearer], func_get_args());

                    $func = [$childFieldBearer, "save"];
                    call_user_func_array($func, $args);
                }
            };
        }

        return new FieldBearer(
            $this->_fields,
            $this->_fieldBearers,
            $this->_visibleFieldNames,
            $this->_hiddenFieldNames,
            $this->_saveFunction
        );
    }

}