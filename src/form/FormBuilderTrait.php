<?php

namespace Athens\Core\Form;

use Athens\Core\ORMWrapper\ObjectWrapperInterface;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;

use Athens\Core\Field\FieldInterface;
use Athens\Core\WritableBearer\WritableBearerBearerBuilderTrait;
use Athens\Core\WritableBearer\WritableBearerInterface;
use Athens\Core\FormAction\FormActionInterface;
use Athens\Core\FormAction\FormActionBuilder;
use Athens\Core\Field\FieldBuilder;
use Athens\Core\Etc\ORMUtils;

trait FormBuilderTrait
{
    /** @var FormActionInterface[] */
    protected $actions = [];

    /** @var string */
    protected $method = "post";

    /** @var string */
    protected $target = "_self";

    /** @var callable[] */
    protected $onValidFunctions = [];

    /** @var callable[] */
    protected $onInvalidFunctions = [];
    
    /** @var callable */
    protected $onValidFunction;
    
    /** @var callable */
    protected $onInvalidFunction;

    /** @var string */
    protected $onSuccessUrl;

    /** @var mixed[] */
    private $initialFieldValues = [];
    
    /** @var string[] */
    private $fieldLabels = [];
    
    /** @var mixed[] */
    private $fieldChoices = [];
    
    /** @var string[] */
    private $fieldTypes = [];

    /** @var string[] */
    protected $fieldHelptexts = [];

    /** @var string[] */
    protected $fieldPlaceholders = [];

    /** @var callable[] */
    protected $validators = [];

    use WritableBearerBearerBuilderTrait;

    /**
     * @param FormActionInterface $action
     * @return $this
     */
    public function addAction(FormActionInterface $action)
    {
        $this->actions[] = $action;
        
        return $this;
    }

    /**
     * @param string $target
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param mixed $object
     * @return $this
     */
    public function addObject($object)
    {
        /** @var ObjectWrapperInterface $object */
        $object = $this->wrapObject($object);

        $fields = $object->getFields();

        foreach ($fields as $name => $field) {
            $this->addWritable($field, $name);
        }

        $this->addOnValidFunc(
            function (FormInterface $form) use ($object, $fields) {
                $object->fillFromFields($fields)->save();
            }
        );

        return $this;
    }

    /**
     * @param callable $onValidFunc
     * @return $this
     */
    public function addOnValidFunc(callable $onValidFunc)
    {
        $this->onValidFunctions[] = $onValidFunc;
        return $this;
    }

    /**
     * @param callable $onInvalidFunc
     * @return $this
     */
    public function addOnInvalidFunc(callable $onInvalidFunc)
    {
        $this->onInvalidFunctions[] = $onInvalidFunc;
        return $this;
    }

    /**
     * @param string $onSuccessRedirect
     * @return $this
     */
    public function setOnSuccessUrl($onSuccessRedirect)
    {
        $this->onSuccessUrl = $onSuccessRedirect;
        return $this;
    }

    /**
     * @param string   $fieldName
     * @param callable $callable
     * @return $this
     */
    public function addValidator($fieldName, callable $callable)
    {
        if (array_key_exists($fieldName, $this->validators) === false) {
            $this->validators[$fieldName] = [];
        }
        $this->validators[$fieldName][] = $callable;

        return $this;
    }

    /**
     * @param string $fieldName
     * @param mixed  $value
     * @return $this
     */
    public function setInitialFieldValue($fieldName, $value)
    {
        $this->initialFieldValues[$fieldName] = $value;
        return $this;
    }
    
    /**
     * @param string $fieldName
     * @param mixed  $label
     * @return $this
     */
    public function setFieldLabel($fieldName, $label)
    {
        $this->fieldLabels[$fieldName] = $label;
        return $this;
    }
    
    /**
     * @param string $fieldName
     * @param array  $choices
     * @return $this
     */
    public function setFieldChoices($fieldName, array $choices)
    {
        $this->fieldChoices[$fieldName] = $choices;
        return $this;
    }
    
    /**
     * @param string $fieldName
     * @param string $type
     * @return $this
     */
    public function setFieldType($fieldName, $type)
    {
        $this->fieldTypes[$fieldName] = $type;
        return $this;
    }
    
    /**
     * @param string $fieldName
     * @param string $helptext
     * @return $this
     */
    public function setFieldHelptext($fieldName, $helptext)
    {
        $this->fieldHelptexts[$fieldName] = $helptext;
        return $this;
    }
    
    /**
     * @param string $fieldName
     * @param string $placeholder
     * @return $this
     */
    public function setFieldPlaceholder($fieldName, $placeholder)
    {
        $this->fieldPlaceholders[$fieldName] = $placeholder;
        return $this;
    }

    /**
     * @return void
     */
    protected function validateOnInvalidFunc()
    {
        $this->onInvalidFunctions[] = function (FormInterface $thisForm) {
            foreach ($thisForm->getWritableBearer()->getWritables() as $writable) {
                if ($writable instanceof FieldInterface) {
                    if ($writable->getType() !== FieldBuilder::TYPE_LITERAL) {
                        $writable->setInitial($writable->getSubmitted());
                    }
                }
            }
        };

        $onInvalidFunctions = $this->onInvalidFunctions;

        $this->onInvalidFunction = function (FormInterface $form) use ($onInvalidFunctions) {
            $args = array_merge([$this], func_get_args());

            foreach ($form->getWritableBearer()->getWritables() as $writable) {
                if ($writable instanceof FormInterface) {
                    $func = [$writable, "onInvalid"];
                    call_user_func_array($func, $args);
                }
            }

            foreach ($onInvalidFunctions as $function) {
                $args = func_get_args();
                call_user_func_array($function, $args);
            }
        };
    }

    /**
     * @param WritableBearerInterface $writableBearer
     * @return void
     */
    protected function modifyFields(WritableBearerInterface $writableBearer)
    {
        foreach ($this->initialFieldValues as $fieldName => $value) {
            $writableBearer->getWritableByHandle($fieldName)->setInitial($value);
        }
        foreach ($this->fieldLabels as $fieldName => $label) {
            $writableBearer->getWritableByHandle($fieldName)->setLabel($label);
        }
        foreach ($this->fieldChoices as $fieldName => $choices) {
            $field = $writableBearer->getWritableByHandle($fieldName);
            $field->setType(FieldBuilder::TYPE_CHOICE);
            $field->setChoices($choices);
        }
        foreach ($this->fieldTypes as $fieldName => $type) {
            $field = $writableBearer->getWritableByHandle($fieldName);
            $field->setType($type);
        }
        foreach ($this->fieldHelptexts as $fieldName => $helptext) {
            $field = $writableBearer->getWritableByHandle($fieldName);
            $field->setHelptext($helptext);
        }
        foreach ($this->fieldPlaceholders as $fieldName => $placeholder) {
            $field = $writableBearer->getWritableByHandle($fieldName);
            $field->setPlaceholder($placeholder);
        }
    }

    /**
     * @return void
     */
    protected function validateOnValidFunc()
    {
        if ($this->onSuccessUrl !== null) {
            $url = $this->onSuccessUrl;

            $redirectFunction = function (FormInterface $form) use ($url) {
                if (headers_sent() === true) {
                    throw new \Exception("Form success redirection cannot proceed, output has already begun.");
                } else {
                    header("Location: $url");
                }
            };

            $this->onValidFunctions = array_merge([$redirectFunction], $this->onValidFunctions);
        }

        $onValidFunctions = $this->onValidFunctions;

        $this->onValidFunction = function (FormInterface $form) use ($onValidFunctions) {
            $args = array_merge([$this], func_get_args());

            foreach ($form->getWritableBearer()->getWritables() as $writable) {
                if ($writable instanceof FormInterface) {
                    $func = [$writable, "onValid"];
                    call_user_func_array($func, $args);
                }
            }
            
            foreach ($onValidFunctions as $function) {
                $args = func_get_args();
                call_user_func_array($function, $args);
            }
        };
    }

    /**
     * @return void
     */
    protected function validateActions()
    {
        if ($this->actions === []) {
            $this->actions = [
                FormActionBuilder::begin()
                    ->setType(FormActionBuilder::TYPE_SUBMIT)
                    ->setLabel('Submit')
                    ->build()
            ];
        }
    }
}
