<?php

namespace Athens\Core\Field;

use Athens\Core\Etc\StringUtils;
use Athens\Core\Visitor\VisitableTrait;

use DateTime;
use Athens\Core\Writer\WritableTrait;

/**
 * Class Field provides a small, typed data container for display and
 * user submission.
 *
 * @package Athens\Core\Field
 */
class Field implements FieldInterface
{

    const FIELD_TYPE_TEXT = "text";
    const FIELD_TYPE_TEXTAREA = "textarea";
    const FIELD_TYPE_BOOLEAN = "boolean";
    const FIELD_TYPE_CHECKBOX = "checkbox";
    const FIELD_TYPE_BOOLEAN_RADIOS = "boolean-radios";
    const FIELD_TYPE_CHOICE = "choice";
    const FIELD_TYPE_MULTIPLE_CHOICE = "multiple-choice";
    const FIELD_TYPE_LITERAL = "literal";
    const FIELD_TYPE_SECTION_LABEL = "section-label";
    const FIELD_TYPE_PRIMARY_KEY = "primary-key";
    const FIELD_TYPE_FOREIGN_KEY = "foreign-key";
    const FIELD_TYPE_AUTO_TIMESTAMP = "auto-timestamp";
    const FIELD_TYPE_VERSION = "version";

    use WritableTrait;

    /** @var bool  */
    protected $required;

    /** @var int  */
    protected $fieldSize;

    /** @var string */
    protected $type;

    /** @var string */
    protected $label;

    /** @var string|string[]  */
    protected $initial;

    /** @var string[] */
    protected $fieldErrors = [];

    /** @var string[] */
    protected $prefixes = [];

    /** @var string[] */
    protected $suffixes = [];

    /** @var string */
    protected $validatedData;

    /** @var boolean */
    protected $hasValidatedData = false;

    /** @var bool */
    protected $isValid;

    /** @var string[] */
    protected $choices;

    /** @var string */
    protected $helptext;

    /** @var string */
    protected $placeholder;

    use VisitableTrait;

    /**
     * Provides the unique identifier for this field.
     *
     * @return string
     */
    public function getId()
    {
        return md5($this->getSlug());
    }

    /**
     * @param string[]    $classes
     * @param string      $type
     * @param string      $label
     * @param string|null $initial
     * @param boolean     $required
     * @param string[]    $choices
     * @param integer     $fieldSize
     * @param string      $helptext
     * @param string      $placeholder
     */
    public function __construct(
        array $classes,
        $type,
        $label = "",
        $initial = "",
        $required = false,
        array $choices = [],
        $fieldSize = 255,
        $helptext = "",
        $placeholder = ""
    ) {
        $this->type = $type;
        $this->label = $label;

        $this->setInitial($initial);
        
        $this->required = $required;
        $this->choices = $choices;
        $this->fieldSize = $fieldSize;
        $this->helptext = $helptext;
        $this->placeholder = $placeholder;
        $this->classes = $classes;
    }

    /**
     * Provides the data that was submitted to this field, if applicable.
     *
     * @return string
     */
    public function getSubmitted()
    {
        $fieldType = $this->getType();

        if ($fieldType === "checkbox") {
            $data = (string)array_key_exists($this->getSlug(), $_POST);
        } else {
            $data = array_key_exists($this->getSlug(), $_POST) ? $_POST[$this->getSlug()]: "";
        }

        if (in_array($fieldType, [static::FIELD_TYPE_CHOICE, static::FIELD_TYPE_MULTIPLE_CHOICE]) === true) {
            $data = $this->parseChoiceSlugs($data);
        }

        return $data;
    }

    /**
     * Predicate which reports whether the field received a submission.
     *
     * @return boolean
     */
    public function wasSubmitted()
    {
        return array_key_exists($this->getSlug(), $_POST) && $_POST[$this->getSlug()] !== "";
    }

    /**
     * Provides the text label assigned to this field.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets the text label to be displayed with this field.
     *
     * @param string $label
     * @return FieldInterface
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Provides the available choices for submission to this field.
     *
     * @return string[]
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * Provides the slugs which shall be used to identify valid submissions to this field.
     *
     * @return string[]
     */
    public function getChoiceSlugs()
    {
        return array_map(
            function ($choice) {
                return StringUtils::slugify($choice);
            },
            $this->choices
        );
    }

    /**
     * Sets the choices which shall be made available for submission to this field.
     *
     * @param array $choices
     * @return FieldInterface
     */
    public function setChoices(array $choices)
    {
        $this->choices = $choices;
        return $this;
    }

    /**
     * Provides the maximum size of a submission to this field.
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->fieldSize;
    }

    /**
     * Sets the maximum size of a submission to this field.
     *
     * @param integer $size
     * @return FieldInterface
     */
    public function setSize($size)
    {
        $this->fieldSize = $size;
        return $this;
    }

    /**
     * Provides the "type" of the field.
     *
     * Most likely one of the Field::FIELD_TYPE_ constants. This type determines which
     * template shall be used to render the field, and also some field validation behavior.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the "type" of the field.
     *
     * See the extended comments on ::getType for more information.
     *
     * @param string $type
     * @return FieldInterface
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Adds a suffix, which shall be applied to this field's slug.
     *
     * Framework will add suffixes to fields to avoid naming collisions.
     *
     * @param string $suffix
     * @return FieldInterface
     */
    public function addSuffix($suffix)
    {
        $this->suffixes[] = $suffix;
        return $this;
    }

    /**
     * Provides an array of the slug suffixes that have been added to this field.
     *
     * @return string[]
     */
    public function getSuffixes()
    {
        return $this->suffixes;
    }

    /**
     * Adds a prefix, which shall be applied to this field's slug.
     *
     * Framework uses field slug prefixes to distinguish between sibling fields in TableForm rows.
     *
     * @param string $prefix
     * @return FieldInterface
     */
    public function addPrefix($prefix)
    {
        $this->prefixes[] = $prefix;
        return $this;
    }

    /**
     * Provides an array of the slug prefixes that have been added to this field.
     *
     * @return string[]
     */
    public function getPrefixes()
    {
        return $this->prefixes;
    }

    /**
     * Provides a slug representation of the field's textual label.
     *
     * @return string
     */
    public function getLabelSlug()
    {
        return StringUtils::slugify($this->label);
    }

    /**
     * Gets the slug representation of the field.
     *
     * Generally this is a combination of the field's label slug, and any added prefixes
     * or suffixes.
     *
     * @return string
     */
    public function getSlug()
    {
        return implode("-", array_merge($this->getPrefixes(), [$this->getLabelSlug()], $this->getSuffixes()));
    }

    /**
     * Sets the initial value to be displayed by the field.
     *
     * @param string $value
     * @return FieldInterface
     */
    public function setInitial($value)
    {
        if ($value instanceof DateTime) {
            $value = new DateTimeWrapper($value->format('Y-m-d'));
        }

        $this->initial = $value;
        return $this;
    }

    /**
     * Gets the initial value which is displayed by the field.
     *
     * @return string
     */
    public function getInitial()
    {
        return $this->initial;
    }

    /**
     * Adds an error to the field.
     *
     * Errors are usually added during field/form validation.
     *
     * @param string $error
     * @return FieldInterface
     */
    public function addError($error)
    {
        $this->fieldErrors[] = $error;
        return $this;
    }

    /**
     * Gets the errors which have been added to the field.
     *
     * @return string[]
     */
    public function getErrors()
    {
        return $this->fieldErrors;
    }

    /**
     * Clears errors from the field.
     *
     * @return FieldInterface
     */
    public function removeErrors()
    {
        $this->fieldErrors = [];
        return $this;
    }

    /**
     * Perform basic validation on the field, add any apparent errors, and
     * mark valid data.
     *
     * @return void
     */
    public function validate()
    {
        $data = $this->wasSubmitted() ? $this->getSubmitted() : null;

        // Invalid selection on choice/multiple choice field
        if ($data === []) {
            $this->addError("Unrecognized choice.");
        }

        if ($this->isRequired() === true && $data === null) {
            $this->addError("This field is required.");
        }

        if ($this->getErrors() === []) {
            $this->setValidatedData($data);
        }
    }

    /**
     * Predicate which reports whether the field includes choices.
     *
     * @return boolean
     */
    protected function hasChoices()
    {
        return (bool)$this->getChoices();
    }

    /**
     * Determines which choice(s) were chosen by form submission, given the selected
     * slug(s).
     *
     * @param mixed $slugs
     * @return array
     */
    protected function parseChoiceSlugs($slugs)
    {
        $choices = array_combine($this->getChoiceSlugs(), $this->getChoices());

        if ($this->getType() === static::FIELD_TYPE_CHOICE) {
            $slugs = [$slugs];
        }

        $result = [];
        foreach ($slugs as $choiceSlug) {
            if (array_key_exists($choiceSlug, $choices) === true) {
                $result[] = $choices[$choiceSlug];
            }
        }

        if ($this->getType() === static::FIELD_TYPE_CHOICE && $result !== []) {
            $result = $result[0];
        }

        return $result;

    }

    /**
     * Predicate which reports whether the field must have a submission.
     *
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required && $this->getType() != "hidden";
    }

    /**
     * Sets whether the field must be submitted to during form submission.
     *
     * @param boolean $required
     * @return FieldInterface
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    /**
     * Predicate which reports whether or not the field has errors.
     *
     * @return boolean
     */
    public function isValid()
    {
        return empty($this->fieldErrors);
    }

    /**
     * Identifies the given data as validated for the field.
     *
     * @param string $data
     * @return FieldInterface
     */
    public function setValidatedData($data)
    {
        $this->hasValidatedData = true;
        $this->validatedData = $data;
        return $this;
    }

    /**
     * Predicate which reports whether or not validated data has been set for
     * this field.
     *
     * Because null or the empty string might be valid validated data, this function can be
     * used to determine whether or not the ::setValidatedData method was invoked to set
     * validated data for this field.
     *
     * @return boolean
     */
    public function hasValidatedData()
    {
        return $this->hasValidatedData;
    }

    /**
     * Gets data which has been marked as validated for the field.
     *
     * @return string
     */
    public function getValidatedData()
    {
        return $this->validatedData;
    }

    /**
     * @return string
     */
    public function getHelptext()
    {
        return $this->helptext;
    }

    /**
     * @param string $helptext
     * @return FieldInterface
     */
    public function setHelptext($helptext)
    {
        $this->helptext = $helptext;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param string $placeholder
     * @return FieldInterface
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }
}
