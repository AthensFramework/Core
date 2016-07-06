<?php

namespace Athens\Core\FieldBearer;

use Propel\Runtime\ActiveRecord\ActiveRecordInterface;

use Athens\Core\Etc\ORMUtils;
use Athens\Core\Field\FieldBuilder;

/**
 * Class ClassFieldBearer Encapsulates an ActiveRecordInterface object with Framework fields.
 *
 * @package Athens\Core\FieldBearer
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
            if ($type === FieldBuilder::TYPE_PRIMARY_KEY
                || $type === FieldBuilder::TYPE_VERSION
            ) {
                $hiddenFieldNames[] = $fieldName;
            }
        }

        parent::__construct($fields, [], [], $hiddenFieldNames, $saveFunction);
    }
}
