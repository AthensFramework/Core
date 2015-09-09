<?php

use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Writer\Writer;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Form\FormBuilder;
use UWDOEM\Framework\Section\SectionBuilder;
use UWDOEM\Framework\Page\PageBuilder;
use UWDOEM\Framework\Page\Page;
use UWDOEM\Framework\Etc\StringUtils;


class WriterTest extends PHPUnit_Framework_TestCase
{
    public function testVisitField() {
        $writer = new Writer();

        /* A literal field */
        $field = new Field("literal", "A literal field", "initial", true, [], 200);
        $this->assertContains("initial", $writer->visitField($field));

        /* A section-label field */
        $field = new Field("section-label", "A section-label field", "initial");
        $this->assertContains("A section-label field", $writer->visitField($field));
        $this->assertNotContains("initial", $writer->visitField($field));

        /* A choice field */
        $field = new Field("choice", "A literal field", "initial", true, ["first choice", "second choice"], 200);

        // Get result and strip quotes, for easier analysis
        $result = str_replace(['"', "'"], "", $writer->visitField($field));

        // Assert that the field contains our choices
        $this->assertContains("first choice", $result);
        $this->assertContains("second choice", $result);
        $this->assertContains("value=" . StringUtils::slugify("first choice"), $result);
        $this->assertContains("value=" . StringUtils::slugify("second choice"), $result);

        /* A multiple choice field */
        $field = new Field("multiple-choice", "A multiple-choice field", "initial", true, ["first choice", "second choice"], 200);

        // Get result and strip quotes, for easier analysis
        $result = str_replace(['"', "'"], "", $writer->visitField($field));

        // Assert that the field contains our choices
        $this->assertContains("first choice", $result);
        $this->assertContains("second choice", $result);
        $this->assertContains("value=" . StringUtils::slugify("first choice"), $result);
        $this->assertContains("value=" . StringUtils::slugify("second choice"), $result);

        /* A text field */
        $field = new Field("text", "A text field", "5", true, [], 200);

        // Get result and strip quotes, for easier analysis
        $result = str_replace(['"', "'"], "", $writer->visitField($field));

        $this->assertContains('value=5', $result);
        $this->assertContains('<input type=text', $result);

        /* A textarea field */
        $field = new Field("textarea", "A textarea field", "initial value", true, [], 1000);

        // Get result and strip quotes, for easier analysis
        $result = str_replace(['"', "'"], "", $writer->visitField($field));

        // By our current method of calculation, should have size of 100 means 10 rows
        // If change calculation, change this test
        $this->assertContains('rows=10', $result);
        $this->assertContains('<textarea', $result);
        $this->assertContains('initial value', $result);

        /* A textarea field without an initial value*/
        $field = new Field("textarea", "A textarea field", "", true, [], 1000);

        // Get result and strip quotes, for easier analysis
        $result = str_replace(['"', "'"], "", $writer->visitField($field));

        // Assert that the text area contains no initial text
        $this->assertContains('></textarea>', $result);
    }

    public function testRenderFieldErrors() {
        $writer = new Writer();

        /* Field not required, no data provided: no field errors */
        $field = new Field("text", "An unrequired field", "5", false, [], 200);

        $field->validate();

        // Confirm that the field has no errors
        $this->assertEmpty($field->getErrors());

        // Get result and strip quotes, for easier analysis
        $result = str_replace(['"', "'"], "", $writer->visitField($field));

        // Assert that the result does not display any errors
        $this->assertNotContains("field-errors", $result);

        /* Field required, but no data provided: field errors */
        $field = new Field("text", "A required field", "5", true, [], 200);

        $field->validate();

        // Confirm that the field has errors
        $this->assertNotEmpty($field->getErrors());

        // Get result and strip quotes, for easier analysis
        $result = str_replace(['"', "'"], "", $writer->visitField($field));

        // Assert that the result does display errors
        $this->assertContains("field-errors", $result);
    }

    public function testVisitForm() {
        $writer = new Writer();

        $actions = [
            new FormAction("JS Action", "JS", "console.log('here');"),
            new FormAction("POST Action", "POST", "post-target")
        ];
        $onValidFunc = function() { return "valid"; };
        $onInvalidFunc = function() { return "invalid"; };

        $form = FormBuilder::begin()
            ->setActions($actions)
            ->addFields([
                "literalField" => new Field('literal', 'A literal field', 'Literal field content', true, []),
                "textField" => new Field('text', 'A text field', "5", false, [])
            ])
            ->setOnInvalidFunc($onInvalidFunc)
            ->setOnValidFunc($onValidFunc)
            ->build();

        $_SERVER["REQUEST_URI"] = "http://example.com";

        // Get result and strip quotes, for easier analysis
        $result = str_replace(['"', "'"], "", $writer->visitForm($form));

        $this->assertContains("<form", $result);
        $this->assertContains("data-request-uri=http://example.com", $result);
        $this->assertContains("data-for=a-literal-field", $result);
        $this->assertContains("A literal field*:", $result);
        $this->assertContains("Literal field content", $result);
        $this->assertContains("data-for=a-text-field", $result);
        $this->assertContains("A text field:", $result);
        $this->assertContains("value=5", $result);
        $this->assertContains("name=a-text-field", $result);
        $this->assertContains('<input type=text', $result);
        $this->assertContains('onclick=console.log(here);', $result);
        $this->assertContains('JS Action</button>', $result);
        $this->assertContains('<input class=form-action type=submit', $result);
        $this->assertContains('value=POST Action', $result);
        $this->assertContains('</form>', $result);
    }

    public function testRenderFormErrors() {
        $writer = new Writer();

        $_SERVER["REQUEST_URI"] = "";

        /* Field not required, no data provided: no field errors */
        $field = new Field("text", "An unrequired field", "5", false, [], 200);
        $form = FormBuilder::begin()
            ->addFields([$field])
            ->build();

        // Confirm that the form is valid and has no errors
        $this->assertTrue($form->isValid());
        $this->assertEmpty($form->getErrors());

        // Get result and strip quotes, for easier analysis
        $result = str_replace(['"', "'"], "", $writer->visitForm($form));

        // Assert that the result does not display any errors
        $this->assertNotContains("form-errors", $result);

        /* Field required, but no data provided: field errors */
        $field = new Field("text", "A required field", "5", true, [], 200);
        $form = FormBuilder::begin()
            ->addFields([$field])
            ->build();

        // Confirm that the form is not valid and does have errors
        $this->assertFalse($form->isValid());
        $this->assertNotEmpty($form->getErrors());

        // Get result and strip quotes, for easier analysis
        $result = str_replace(['"', "'"], "", $writer->visitForm($form));

        // Assert that the result does display errors
        $this->assertContains("form-errors", $result);
    }

    public function testVisitSection() {
        $writer = new Writer();

        $subSection = SectionBuilder::begin()
            ->setContent("Some sub-content.")
            ->build();

        $section = SectionBuilder::begin()
            ->setLabel("Label")
            ->setContent("Some content.")
            ->addWritable($subSection)
            ->build();

        // Get result and strip quotes, for easier analysis
        $result = str_replace(['"', "'"], "", $writer->visitSection($section));

        $this->assertContains("<div class=section-label>Label</div>", $result);
        $this->assertContains("<div class=section-writables>", $result);
        $this->assertContains("Some sub-content.", $result);
    }

    public function testVisitPage() {
        $writer = new Writer();

        $section = SectionBuilder::begin()
            ->setLabel("Label")
            ->setContent("Some content.")
            ->build();

        $page = PageBuilder::begin()
            ->setWritable($section)
            ->setHeader("Page Header")
            ->setSubHeader("Page subheader")
            ->setReturnTo(["Another name" => "http://another.link"])
            ->setType(Page::PAGE_TYPE_FULL_HEADER)
            ->setTitle("Page Title")
            ->setBaseHref(".")
            ->setBreadCrumbs(["Key" => "http://example.com", "Another name"])
            ->build();

        // Get result and strip quotes, for easier analysis
        $result = str_replace(['"', "'"], "", $writer->visitPage($page));

        $this->assertContains("<html>", $result);
        $this->assertContains("<head>", $result);
        $this->assertContains("<title>Page Title</title>", $result);
        $this->assertContains("<base href=.", $result);
        $this->assertContains("</head>", $result);
        $this->assertContains("<body>", $result);
        $this->assertContains("<li><a target=_self href=http://example.com>Key</a></li>", $result);
        $this->assertContains("<h1 class=header>Page Header</h1>", $result);
        $this->assertContains("<h2 class=subheader>Page subheader</h2>", $result);
        $this->assertContains("<div class=section-label>Label</div>", $result);
    }
}