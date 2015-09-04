<?php

namespace UWDOEM\Framework\FieldBearer;

use UWDOEM\Framework\Etc\ORMUtils;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;


class ClassFieldBearer extends FieldBearer implements FieldBearerInterface {

    /** @var ActiveRecordInterface  */
    protected $_object;

    /**
     * @param ActiveRecordInterface $object
     * @param callable $saveFunction
     */
    public function __construct(ActiveRecordInterface $object, callable $saveFunction) {
        $this->_object = $object;

        $fields = ORMUtils::makeFieldsFromObject($object);

        parent::__construct($fields, [], [], [], $saveFunction);
    }
}