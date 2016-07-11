<?php

namespace Athens\Core\Field;

interface FieldConstantsInterface
{
    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_BOOLEAN_RADIOS = 'boolean-radios';
    const TYPE_CHOICE = 'choice';
    const TYPE_MULTIPLE_CHOICE = 'multiple-choice';
    const TYPE_LITERAL = 'literal';
    const TYPE_SECTION_LABEL = 'section-label';
    const TYPE_PRIMARY_KEY = 'primary-key';
    const TYPE_FOREIGN_KEY = 'foreign-key';
    const TYPE_AUTO_TIMESTAMP = 'auto-timestamp';
    const TYPE_HTML = 'html';
    const TYPE_VERSION = 'version';
}
