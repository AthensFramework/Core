<?php

namespace Athens\Core\Choice;

use Athens\Core\Etc\StringUtils;
use Athens\Core\Visitor\VisitableTrait;

use DateTime;
use Athens\Core\Writer\WritableTrait;

/**
 * Class Choice provides a small, typed data container for display and
 * user submission.
 *
 * @package Athens\Core\Choice
 */
class Choice implements ChoiceInterface
{

    use WritableTrait;

    /** @var string */
    protected $key;

    /** @var string */
    protected $value;
    
    use VisitableTrait;

    /**
     * Provides the unique identifier for this choice.
     *
     * @return string
     */
    public function getId()
    {
        return md5($this->getKey() . $this->getValue());
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string[] $classes
     * @param string[] $data
     * @param string   $key
     * @param string   $value
     */
    public function __construct(
        array $classes,
        array $data,
        $key,
        $value
    ) {
        $this->key = $key;
        $this->value = $value;

        $this->classes = $classes;
        $this->data = $data;
    }

    /**
     * Provides the data that was submitted to this choice, if applicable.
     *
     * @return string
     */
    public function getSubmitted()
    {
        $choiceType = $this->getType();

        if ($choiceType === "checkbox") {
            $data = (string)array_key_exists($this->getSlug(), $_POST);
        } else {
            $data = array_key_exists($this->getSlug(), $_POST) ? $_POST[$this->getSlug()]: "";
        }

        if (in_array($choiceType, [static::CHOICE_TYPE_CHOICE, static::CHOICE_TYPE_MULTIPLE_CHOICE]) === true) {
            $data = $this->parseChoiceSlugs($data);
        }

        return $data;
    }

    /**
     * Predicate which reports whether the choice received a submission.
     *
     * @return boolean
     */
    public function wasSubmitted()
    {
        return array_key_exists($this->getSlug(), $_POST) && $_POST[$this->getSlug()] !== "";
    }

    /**
     * Provides the text label assigned to this choice.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets the text label to be displayed with this choice.
     *
     * @param string $label
     * @return ChoiceInterface
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Provides the available choices for submission to this choice.
     *
     * @return string[]
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * Provides the slugs which shall be used to identify valid submissions to this choice.
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
     * Sets the choices which shall be made available for submission to this choice.
     *
     * @param array $choices
     * @return ChoiceInterface
     */
    public function setChoices(array $choices)
    {
        $this->choices = $choices;
        return $this;
    }

    /**
     * Provides the maximum size of a submission to this choice.
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->choiceSize;
    }

    /**
     * Sets the maximum size of a submission to this choice.
     *
     * @param integer $size
     * @return ChoiceInterface
     */
    public function setSize($size)
    {
        $this->choiceSize = $size;
        return $this;
    }

    /**
     * Provides the "type" of the choice.
     *
     * Most likely one of the Choice::CHOICE_TYPE_ constants. This type determines which
     * template shall be used to render the choice, and also some choice validation behavior.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the "type" of the choice.
     *
     * See the extended comments on ::getType for more information.
     *
     * @param string $type
     * @return ChoiceInterface
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Adds a suffix, which shall be applied to this choice's slug.
     *
     * Framework will add suffixes to choices to avoid naming collisions.
     *
     * @param string $suffix
     * @return ChoiceInterface
     */
    public function addSuffix($suffix)
    {
        $this->suffixes[] = $suffix;
        return $this;
    }

    /**
     * Provides an array of the slug suffixes that have been added to this choice.
     *
     * @return string[]
     */
    public function getSuffixes()
    {
        return $this->suffixes;
    }

    /**
     * Adds a prefix, which shall be applied to this choice's slug.
     *
     * Framework uses choice slug prefixes to distinguish between sibling choices in TableForm rows.
     *
     * @param string $prefix
     * @return ChoiceInterface
     */
    public function addPrefix($prefix)
    {
        $this->prefixes[] = $prefix;
        return $this;
    }

    /**
     * Provides an array of the slug prefixes that have been added to this choice.
     *
     * @return string[]
     */
    public function getPrefixes()
    {
        return $this->prefixes;
    }

    /**
     * Provides a slug representation of the choice's textual label.
     *
     * @return string
     */
    public function getLabelSlug()
    {
        return StringUtils::slugify($this->label);
    }

    /**
     * Gets the slug representation of the choice.
     *
     * Generally this is a combination of the choice's label slug, and any added prefixes
     * or suffixes.
     *
     * @return string
     */
    public function getSlug()
    {
        return implode("-", array_merge($this->getPrefixes(), [$this->getLabelSlug()], $this->getSuffixes()));
    }

    /**
     * Sets the initial value to be displayed by the choice.
     *
     * @param string $value
     * @return ChoiceInterface
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
     * Gets the initial value which is displayed by the choice.
     *
     * @return string
     */
    public function getInitial()
    {
        return $this->initial;
    }

    /**
     * Adds an error to the choice.
     *
     * Errors are usually added during choice/form validation.
     *
     * @param string $error
     * @return ChoiceInterface
     */
    public function addError($error)
    {
        $this->choiceErrors[] = $error;
        return $this;
    }

    /**
     * Gets the errors which have been added to the choice.
     *
     * @return string[]
     */
    public function getErrors()
    {
        return $this->choiceErrors;
    }

    /**
     * Clears errors from the choice.
     *
     * @return ChoiceInterface
     */
    public function removeErrors()
    {
        $this->choiceErrors = [];
        return $this;
    }

    /**
     * Perform basic validation on the choice, add any apparent errors, and
     * mark valid data.
     *
     * @return void
     */
    public function validate()
    {
        $data = $this->wasSubmitted() ? $this->getSubmitted() : null;

        // Invalid selection on choice/multiple choice choice
        if ($data === []) {
            $this->addError("Unrecognized choice.");
        }

        if ($this->isRequired() === true && $data === null) {
            $this->addError("This choice is required.");
        }

        if ($this->getErrors() === []) {
            $this->setValidatedData($data);
        }
    }

    /**
     * Predicate which reports whether the choice includes choices.
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

        if ($this->getType() === static::CHOICE_TYPE_CHOICE) {
            $slugs = [$slugs];
        }

        $result = [];
        foreach ($slugs as $choiceSlug) {
            if (array_key_exists($choiceSlug, $choices) === true) {
                $result[] = $choices[$choiceSlug];
            }
        }

        if ($this->getType() === static::CHOICE_TYPE_CHOICE && $result !== []) {
            $result = $result[0];
        }

        return $result;

    }

    /**
     * Predicate which reports whether the choice must have a submission.
     *
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required && $this->getType() != "hidden";
    }

    /**
     * Sets whether the choice must be submitted to during form submission.
     *
     * @param boolean $required
     * @return ChoiceInterface
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    /**
     * Predicate which reports whether or not the choice has errors.
     *
     * @return boolean
     */
    public function isValid()
    {
        return empty($this->choiceErrors);
    }

    /**
     * Identifies the given data as validated for the choice.
     *
     * @param string $data
     * @return ChoiceInterface
     */
    public function setValidatedData($data)
    {
        $this->hasValidatedData = true;
        $this->validatedData = $data;
        return $this;
    }

    /**
     * Predicate which reports whether or not validated data has been set for
     * this choice.
     *
     * Because null or the empty string might be valid validated data, this function can be
     * used to determine whether or not the ::setValidatedData method was invoked to set
     * validated data for this choice.
     *
     * @return boolean
     */
    public function hasValidatedData()
    {
        return $this->hasValidatedData;
    }

    /**
     * Gets data which has been marked as validated for the choice.
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
     * @return ChoiceInterface
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
     * @return ChoiceInterface
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }
}
