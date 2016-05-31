<?php

namespace Athens\Core\PickA;

use Athens\Core\FieldBearer\FieldBearer;
use Athens\Core\Visitor\VisitableTrait;
use Athens\Core\Etc\StringUtils;
use Athens\Core\FieldBearer\FieldBearerInterface;
use Athens\Core\Writer\WritableInterface;
use Athens\Core\Form\FormInterface;
use Athens\Core\Form\FormAction\FormActionInterface;
use Athens\Core\Writer\WritableTrait;

/**
 * Class PickAForm
 *
 * @package Athens\Core\PickA
 */
class PickAForm implements PickAFormInterface
{

    /** @var string */
    protected $type;

    /** @var string */
    protected $method;

    /** @var string */
    protected $target;

    /** @var \Athens\Core\PickA\PickA */
    protected $pickA;

    /** @var \Athens\Core\Form\FormAction\FormAction[] */
    protected $actions;

    /** @var \Athens\Core\FieldBearer\FieldBearerInterface */
    protected $fieldBearer;

    /** @var string[] */
    protected $errors = [];

    use VisitableTrait;
    use WritableTrait;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return null|string
     */
    public function getSelectedSlug()
    {
        $hash = $this->getId();

        if (array_key_exists($hash, $_POST) === true) {
            $slug = $_POST[$hash];
        } else {
            $slug = null;
        }

        return $slug;
    }

    /**
     * @return \Athens\Core\Form\FormInterface
     */
    public function getSelectedForm()
    {
        $forms = $this->getSubForms();
        $selectedSlug = $this->getSelectedSlug();

        $selectedForm = null;
        foreach ($forms as $key => $form) {
            if ($selectedSlug === StringUtils::slugify($key)) {
                $selectedForm = $form;
                break;
            }
        }

        return $selectedForm;
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        $selectedForm = $this->getSelectedForm();

        if ($selectedForm === null) {
            $isValid = false;
            $this->addError("You must select an option at left.");
        } else {
            $isValid = $selectedForm->isValid();
        }

        return $isValid;
    }

    /**
     * @return void
     */
    public function propagateOnValid()
    {
        $selectedForm = $this->getSelectedForm();

        $func = [$selectedForm, "onValid"];
        $args = array_merge([$selectedForm], func_get_args());

        call_user_func_array($func, $args);
    }

    /**
     * @return void
     */
    public function onValid()
    {
        $func = [$this, "propagateOnValid"];
        call_user_func_array($func, func_get_args());
    }

    /**
     * @return void
     */
    public function onInvalid()
    {
        $selectedForm  = $this->getSelectedForm();

        if ($selectedForm !== null) {
            $selectedForm->onInvalid();
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->pickA->getId();
    }

    /**
     * @return FieldBearerInterface
     */
    public function getFieldBearer()
    {
        return $this->fieldBearer;
    }

    /**
     * @return string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getManifest()
    {
        return $this->pickA->getManifest();
    }

    /**
     * @return string[]
     */
    public function getLabels()
    {
        return $this->pickA->getLabels();
    }

    /**
     * @return WritableInterface[]
     */
    public function getWritables()
    {
        return $this->pickA->getWritables();
    }

    /**
     * @return FormInterface[]
     */
    public function getSubForms()
    {
        return $this->getWritables();
    }

    /**
     * @param string $name
     * @return FormInterface
     */
    public function getSubFormByName($name)
    {
        return $this->getSubForms()[$name];
    }

    /**
     * @return FormActionInterface[]
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param string $error
     * @return void
     */
    public function addError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * @param string     $id
     * @param string[]   $classes
     * @param string[]   $data
     * @param string     $type
     * @param string     $method
     * @param string     $target
     * @param array      $manifest
     * @param array|null $actions
     */
    public function __construct(
        $id,
        array $classes,
        array $data,
        $type,
        $method,
        $target,
        array $manifest,
        $actions = []
    ) {
        $this->id = $id;
        $this->classes = $classes;
        $this->type = $type;

        $this->actions = $actions;
        $this->pickA = new PickA($id, $classes, $data, $manifest);

        $this->method = $method;
        $this->target = $target;

        $this->data = $data;

        $this->fieldBearer = new FieldBearer(
            [],
            [],
            [],
            [],
            function () {
            }
        );
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @return void
     * @throws \Exception If no form has been selected.
     */
    public function __call($name, array $arguments)
    {
        $selectedForm = $this->getSelectedForm();

        if ($selectedForm === null) {
            throw new \Exception("No form selected");
        }
        call_user_func_array([$selectedForm, $name], $arguments);
    }
}
