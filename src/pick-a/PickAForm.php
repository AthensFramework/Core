<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\FieldBearer\FieldBearer;
use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Etc\StringUtils;

class PickAForm implements PickAFormInterface
{

    /** @var string */
    protected $id;

    /** @var string */
    protected $type;

    /** @var \UWDOEM\Framework\PickA\PickA */
    protected $pickA;

    /** @var \UWDOEM\Framework\Form\FormAction\FormAction[] */
    protected $actions;

    /** @var \UWDOEM\Framework\FieldBearer\FieldBearerInterface */
    protected $fieldBearer;

    protected $errors = [];

    use VisitableTrait;

    public function getType()
    {
        return $this->type;
    }

    public function getSelectedSlug()
    {
        $hash = $this->getId();

        if (array_key_exists($hash, $_POST)) {
            $slug = $_POST[$hash];
        } else {
            $slug = null;
        }

        return $slug;
    }

    /**
     * @return \UWDOEM\Framework\Form\FormInterface
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

    public function isValid()
    {
        $selectedForm = $this->getSelectedForm();

        if (is_null($selectedForm)) {
            $isValid = false;
            $this->addError("You must select an option at left.");
        } else {
            $isValid = $selectedForm->isValid();
        }

        return $isValid;
    }

    public function propagateOnValid()
    {
        $selectedForm = $this->getSelectedForm();

        $func = [$selectedForm, "onValid"];
        $args = array_merge([$selectedForm], func_get_args());

        call_user_func_array($func, $args);
    }

    public function onValid()
    {
        $func = [$this, "propagateOnValid"];
        call_user_func_array($func, func_get_args());
    }

    public function onInvalid()
    {
        $selectedForm  = $this->getSelectedForm();

        if ($selectedForm) {
            $selectedForm->onInvalid();
        }
    }

    public function getId()
    {
        return $this->pickA->getId();
    }

    public function getFieldBearer()
    {
        return $this->fieldBearer;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getManifest()
    {
        return $this->pickA->getManifest();
    }

    public function getLabels()
    {
        return $this->pickA->getLabels();
    }

    public function getWritables()
    {
        return $this->pickA->getWritables();
    }

    public function getSubForms()
    {
        return $this->getWritables();
    }

    public function getSubFormByName($name)
    {
        return $this->getSubForms()[$name];
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * @param $id
     * @param $type
     * @param array $manifest
     * @param array|null $actions
     */
    public function __construct($id, $type, $manifest, $actions = [])
    {
        $this->id = $id;
        $this->type = $type;

        $this->actions = $actions;
        $this->pickA = new PickA("$id", $manifest);

        $this->fieldBearer = new FieldBearer(
            [],
            [],
            [],
            [],
            function () {
            }
        );
    }

    public function __call($name, $arguments)
    {
        $selectedForm = $this->getSelectedForm();

        if (!$selectedForm) {
            throw new \Exception("No form selected");
        }
        call_user_func_array([$selectedForm, $name], $arguments);
    }
}
