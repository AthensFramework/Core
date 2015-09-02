<?php

use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Writer\Writer;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\Form\FormBuilder;
use UWDOEM\Framework\Section\SectionBuilder;
use UWDOEM\Framework\Page\PageBuilder;
use UWDOEM\Framework\Page\Page;


class WriterTest extends PHPUnit_Framework_TestCase
{
    public function testVisitField() {
        $writer = new Writer();

        /* A literal field */
        $field = new Field("literal", "A literal field", "initial", true, 200);
        $this->assertContains("initial", $writer->visitField($field));

        /* A text field */
        $field = new Field("text", "A text field", "5", true, 200);

        // Get result and strip quotes, for easier analysis
        $result = str_replace(['"', "'"], "", $writer->visitField($field));

        $this->assertContains('value=5', $result);
        $this->assertContains('<input type=text', $result);
    }

    public function testVisitForm() {
        $writer = new Writer();

        $actions = [
            new FormAction("JS Action", "JS", "console.log('here');"),
            new FormAction("POST Action", "POST", "post-target")
        ];
        $onValidFunc = function() { return "valid"; };
        $onInvalidFunc = function() { return "invalid"; };

        $fieldBearer = FieldBearerBuilder::begin()
            ->addFields([
                "literalField" => new Field('literal', 'A literal field', 'Literal field content', true),
                "textField" => new Field('text', 'A text field', "5", false)
            ])
            ->build();

        $form = FormBuilder::begin()
            ->setActions($actions)
            ->setFieldBearer($fieldBearer)
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