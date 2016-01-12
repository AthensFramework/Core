<?php

namespace UWDOEM\Framework\FieldBearer;

use Propel\Runtime\ActiveRecord\ActiveRecordInterface;

use UWDOEM\Framework\Etc\ORMUtils;
use UWDOEM\Framework\Field\Field;

/**
 * Class ClassFieldBearer Encapsulates an ActiveRecordInterface object with Framework fields.
 *
 * @package UWDOEM\Framework\FieldBearer
 */
class ClassFieldBearer extends FieldBearer implements FieldBearerInterface
{

    /** @var ActiveRecordInterface  */
    protected $object;

    /**
     * @param ActiveRecordInterface $object
     * @param callable              $saveFunction
     */
    public function __construct(ActiveRecordInterface $object, callable $saveFunction)
    {
        $this->object = $object;

        $fields = ORMUtils::makeFieldsFromObject($object);

        $hiddenFieldNames = [];
        foreach ($fields as $fieldName => $field) {
            $type = $field->getType();
            if ($type === Field::FIELD_TYPE_PRIMARY_KEY
                || $type === Field::FIELD_TYPE_FOREIGN_KEY
                || $type === Field::FIELD_TYPE_VERSION
            ) {
                $hiddenFieldNames[] = $fieldName;
            }
        }

        parent::__construct($fields, [], [], $hiddenFieldNames, $saveFunction);
    }
}
