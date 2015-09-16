<?php

use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Writer\Writer;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Form\FormBuilder;
use UWDOEM\Framework\Section\SectionBuilder;
use UWDOEM\Framework\Page\PageBuilder;
use UWDOEM\Framework\Page\Page;
use UWDOEM\Framework\Etc\StringUtils;
use UWDOEM\Framework\Etc\Settings;
use UWDOEM\Framework\Etc\SafeString;
use UWDOEM\Framework\Row\RowBuilder;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\Table\TableBuilder;
use UWDOEM\Framework\Field\FieldBuilder;


class SimpleMockWriter extends Writer {
    public function getEnvironment() {
        return parent::getEnvironment();
    }
}

class WriterTest extends PHPUnit_Framework_TestCase
{
    /**
     * Strip quotes marks from a string
     * @param string $string
     * @return string
     */
    protected function stripQuotes($string) {
        return str_replace(['"', "'"], "", $string);
    }
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
        $field = new Field("choice", "A literal field", "first choice", true, ["first choice", "second choice"], 200);

        // Get result and strip quotes, for easier analysis
        $result = $this->stripQuotes($writer->visitField($field));

        // Assert that the field contains our choices
        $this->assertContains("first choice", $result);
        $this->assertContains("second choice", $result);
        $this->assertContains("value=" . StringUtils::slugify("first choice"), $result);
        $this->assertContains("value=" . StringUtils::slugify("second choice"), $result);

        // Assert that the "initial" choice is selected
        $this->assertContains("value=first-choice checked", $result);

        /* A multiple choice field */
        $field = new Field("multiple-choice", "A multiple-choice field", ["second choice"], true, ["first choice", "second choice"], 200);

        // Get result and strip quotes, for easier analysis
        $result = $this->stripQuotes($writer->visitField($field));

        // Assert that the field contains our choices
        $this->assertContains("first choice", $result);
        $this->assertContains("second choice", $result);
        $this->assertContains("value=" . StringUtils::slugify("first choice"), $result);
        $this->assertContains("value=" . StringUtils::slugify("second choice"), $result);

        // Assert that the "initial" choice is selected
        $this->assertContains("value=second-choice checked", $result);

        /* A text field */
        $field = new Field("text", "A text field", "5", true, [], 200);

        // Get result and strip quotes, for easier analysis
        $result = $this->stripQuotes($writer->visitField($field));

        $this->assertContains('value=5', $result);
        $this->assertContains('<input type=text', $result);

        /* A textarea field */
        $field = new Field("textarea", "A textarea field", "initial value", true, [], 1000);

        // Get result and strip quotes, for easier analysis
        $result = $this->stripQuotes($writer->visitField($field));

        // By our current method of calculation, should have size of 100 means 10 rows
        // If change calculation, change this test
        $this->assertContains('rows=10', $result);
        $this->assertContains('<textarea', $result);
        $this->assertContains('initial value', $result);

        /* A textarea field without an initial value*/
        $field = new Field("textarea", "A textarea field", "", true, [], 1000);

        // Get result and strip quotes, for easier analysis
        $result = $this->stripQuotes($writer->visitField($field));

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
        $result = $this->stripQuotes($writer->visitField($field));

        // Assert that the result does not display any errors
        $this->assertNotContains("field-errors", $result);

        /* Field required, but no data provided: field errors */
        $field = new Field("text", "A required field", "5", true, [], 200);

        $field->validate();

        // Confirm that the field has errors
        $this->assertNotEmpty($field->getErrors());

        // Get result and strip quotes, for easier analysis
        $result = $this->stripQuotes($writer->visitField($field));

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
        $result = $this->stripQuotes($writer->visitForm($form));

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
        $result = $this->stripQuotes($writer->visitForm($form));

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
        $result = $this->stripQuotes($writer->visitForm($form));

        // Assert that the result does display errors
        $this->assertContains("form-errors", $result);

        // Assert that form has been given the class has-errors
        $this->assertContains("class=prevent-double-submit has-errors", $result);
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
        $result = $this->stripQuotes($writer->visitSection($section));

        $this->assertContains("<div class=section-label>Label</div>", $result);
        $this->assertContains("<div class=section-writables>", $result);
        $this->assertContains("Some sub-content.", $result);
    }

    public function testVisitRow() {
        $writer = new Writer();

        $initialText = (string)rand();
        $initialLiteral = SafeString::fromString('<a href="http://example.com">A link</a>');
        $initialHidden = (string)rand();
        $onClick = "console.log('Click!');";

        $textField = FieldBuilder::begin()
            ->setType("text")
            ->setLabel("Text Field")
            ->setInitial($initialText)
            ->build();

        $literalField = FieldBuilder::begin()
            ->setType("literal")
            ->setLabel("Literal Field")
            ->setInitial($initialLiteral)
            ->build();

        $hiddenField = FieldBuilder::begin()
            ->setType("text")
            ->setLabel("Hidden Field")
            ->setInitial($initialHidden)
            ->build();

        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields([
                "TextField" => $textField,
                "LiteralField" => $literalField,
                "HiddenField" => $hiddenField
            ])
            ->setVisibleFieldNames(["TextField", "LiteralField"])
            ->setHiddenFieldNames(["HiddenField"])
            ->build();

        $row = RowBuilder::begin()
            ->setFieldBearer($fieldBearer)
            ->setOnClick($onClick)
            ->setHighlightable(true)
            ->build();

        // Get result and strip quotes, for easier analysis
        $result = $this->stripQuotes($writer->visitRow($row));

        $this->assertContains("<tr", $result);
        $this->assertContains("</tr>", $result);
        $this->assertContains("<td class=" . $textField->getSlug(), $result);
        $this->assertContains("<td class=" . $literalField->getSlug(), $result);
        $this->assertContains("highlightable", $result);
        $this->assertContains("class=clickable", $result);
        $this->assertContains($this->stripQuotes("onClick=" . $onClick), $result);
        $this->assertContains($this->stripQuotes($initialLiteral), $result);
        $this->assertContains("style=display:none>$initialHidden</td>", $result);
    }

    public function testVisitTable() {
        $writer = new Writer();

        $field1 = new Field("text", "Text Field Label", (string)rand());
        $row1 = RowBuilder::begin()
            ->setFieldBearer(
                FieldBearerBuilder::begin()
                ->addFields(["TextField" => $field1])
                ->build()
            )
            ->build();

        $field2 = new Field("text", "Text Field Label", (string)rand());
        $row2 = RowBuilder::begin()
            ->setFieldBearer(
                FieldBearerBuilder::begin()
                    ->addFields(["TextField" => $field2])
                    ->build()
            )
            ->build();

        $table = TableBuilder::begin()
            ->setRows([$row1, $row2])
            ->build();

        // Get result and strip quotes, for easier analysis
        $result = $this->stripQuotes($writer->visitTable($table));

        $row1Written = $this->stripQuotes($writer->visitRow($row1));
        $row2Written = $this->stripQuotes($writer->visitRow($row2));

        $this->assertContains("<table>", $result);
        $this->assertContains("</table>", $result);

        $this->assertContains("<th data-for={$field1->getLabelSlug()}>{$field1->getLabel()}</th>", $result);

        $this->assertContains($row1Written, $result);
        $this->assertContains($row2Written, $result);
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

        // Add project CSS and JS
        $cssFile1 = "/path/to/file/1.css";
        $cssFile2= "/path/to/file/2.css";
        $jsFile1 = "/path/to/file/1.js";
        $jsFile2= "/path/to/file/2.js";

        Settings::addProjectCSS($cssFile1);
        Settings::addProjectCSS($cssFile2);

        Settings::addProjectJS($jsFile1);
        Settings::addProjectJS($jsFile2);

        // Get result and strip quotes, for easier analysis
        $result = $this->stripQuotes($writer->visitPage($page));

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

        $this->assertContains($cssFile1, $result);
        $this->assertContains($cssFile2, $result);
        $this->assertContains($jsFile1, $result);
        $this->assertContains($jsFile2, $result);
    }

    public function testSaferawFilter() {
        $writer = new SimpleMockWriter();
        $env = $writer->getEnvironment();

        $template = "{{ var|saferaw|raw }}";

        $unsafeVar = '<a href="http://example.com">a link</a>';
        $safeVar = SafeString::fromString($unsafeVar);

        // Render the unsafe string
        $result = $env->createTemplate($template)->render(["var" => $unsafeVar]);
        $this->assertEquals(htmlentities($unsafeVar), $result);

        // Render the safe string
        $result = $env->createTemplate($template)->render(["var" => $safeVar]);
        $this->assertEquals((string)$safeVar, $result);
    }

    public function testSlugifyFilter() {
        $writer = new SimpleMockWriter();
        $env = $writer->getEnvironment();

        $template = "{{ var|slugify }}";

        $var = "^a#%5m4ll3r^^7357!@ 57r1n6";

        // Render the unsafe string
        $result = $env->createTemplate($template)->render(["var" => $var]);
        $this->assertEquals(StringUtils::slugify($var), $result);
    }

    public function testMD5Filter() {
        $writer = new SimpleMockWriter();
        $env = $writer->getEnvironment();

        $template = "{{ var|md5 }}";

        $var = "^a#%5m4ll3r^^7357!@ 57r1n6";

        // Render the unsafe string
        $result = $env->createTemplate($template)->render(["var" => $var]);
        $this->assertEquals(md5($var), $result);
    }

    public function testRequestURIGlobal() {
        $requestURI = (string)rand();
        $_SERVER["REQUEST_URI"] = $requestURI;

        $writer = new SimpleMockWriter();
        $env = $writer->getEnvironment();

        $template = "{{ requestURI }}";

        // Render the unsafe string
        $result = $env->createTemplate($template)->render([]);
        $this->assertEquals($requestURI, $result);
    }
}