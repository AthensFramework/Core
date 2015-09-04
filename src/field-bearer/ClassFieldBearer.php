<?php

namespace UWDOEM\Framework\FieldBearer;

use UWDOEM\Framework\Etc\ORMUtils;


class ClassFieldBearer extends FieldBearer implements FieldBearerInterface {

    protected $_object;

    public function __construct($object, $saveFunction) {
        if (!$object) {
            throw new \RuntimeException(get_called_class() . " provided with null object. The object provided to " . get_called_class() . " does not exist in the database.");
        }

        $this->_object = $object;

        $fields = ORMUtils::makeFieldsFromObject($object);

        parent::__construct($fields, [], [], [], $saveFunction);
    }

    protected function getObject() {
        return $this->_object;
    }

}