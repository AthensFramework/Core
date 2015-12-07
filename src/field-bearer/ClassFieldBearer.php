<?php

namespace UWDOEM\Framework\FieldBearer;

use Propel\Runtime\ActiveRecord\ActiveRecordInterface;

use UWDOEM\Framework\Etc\ORMUtils;
use UWDOEM\Framework\Field\Field;

class ClassFieldBearer extends FieldBearer implements FieldBearerInterface
{

    /** @var ActiveRecordInterface  */
    protected $_object;

    /**
     * @param ActiveRecordInterface $object
     * @param callable $saveFunction
     */
    public function __construct(ActiveRecordInterface $object, callable $saveFunction)
    {
        $this->_object = $object;

        $fields = ORMUtils::makeFieldsFromObject($object);

        $hiddenFieldNames = [];
        foreach ($fields as $fieldName => $field) {
            $type = $field->getType();
            if ($type === Field::FIELD_TYPE_PRIMARY_KEY
                || $type === Field::FIELD_TYPE_FOREIGN_KEY ) {
                $hiddenFieldNames[] = $fieldName;
            }
        }

        parent::__construct($fields, [], [], $hiddenFieldNames, $saveFunction);
    }
}
