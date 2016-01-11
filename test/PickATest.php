<?php

namespace UWDOEM\Framework\Test;

use PHPUnit_Framework_TestCase;

use UWDOEM\Framework\PickA\PickABuilder;
use UWDOEM\Framework\Section\SectionBuilder;

class PickATest extends PHPUnit_Framework_TestCase
{

    public function testBuilder()
    {

        $labels = [(string)rand(), (string)rand()];

        $id = "p" . (string)rand();
        $classes = [(string)rand(), (string)rand()];

        $sections = [];
        for ($i = 1; $i <= 3; $i++) {
            $sections["l" . (string)$i] = SectionBuilder::begin()
                ->setId("s" . (string)rand())
                ->addContent((string)rand())
                ->build();
        }

        $pickA = PickABuilder::begin()
            ->setId($id)
            ->addClass($classes[0])
            ->addClass($classes[1])
            ->addLabel($labels[0])
            ->addWritables([
                "l1" => $sections["l1"],
                "l2" => $sections["l2"]
            ])
            ->addLabel($labels[0])
            ->addWritables([
                "l3" => $sections["l3"],
            ])
            ->build();

        $manifest = $pickA->getManifest();

        $this->assertEquals($id, $pickA->getId());
        $this->assertEquals($classes, $pickA->getClasses());
    }

    public function testGetManifest()
    {
        $label1 = "l" . (string)rand();
        $label2 = "l" . (string)rand();

        $sections = [];
        for ($i = 1; $i <= 3; $i++) {
            $sections["l" . (string)$i] = SectionBuilder::begin()
                ->setId("s" . (string)rand())
                ->addContent((string)rand())
                ->build();
        }

        $pickA = PickABuilder::begin()
            ->setId("p" . (string)rand())
            ->addLabel($label1)
            ->addWritables([
                "l1" => $sections["l1"],
                "l2" => $sections["l2"]
            ])
            ->addLabel($label2)
            ->addWritables([
                "l3" => $sections["l3"],
            ])
            ->build();

        $manifest = $pickA->getManifest();

        $this->assertContains($label1, array_keys($manifest));
        $this->assertContains($label2, array_keys($manifest));

        $this->assertContains("l1", array_keys($manifest));
        $this->assertContains("l2", array_keys($manifest));
        $this->assertContains("l3", array_keys($manifest));

        $this->assertContains($sections["l1"], array_values($manifest));
        $this->assertContains($sections["l2"], array_values($manifest));
        $this->assertContains($sections["l3"], array_values($manifest));
    }

    public function testGetLabels()
    {
        $label1 = "l" . (string)rand();
        $label2 = "l" . (string)rand();

        $sections = [];
        for ($i = 1; $i <= 3; $i++) {
            $sections["l" . (string)$i] = SectionBuilder::begin()
                ->setId("s" . (string)rand())
                ->addContent((string)rand())
                ->build();
        }

        $pickA = PickABuilder::begin()
            ->setId("p" . (string)rand())
            ->addLabel($label1)
            ->addWritables([
                "l1" => $sections["l1"],
                "l2" => $sections["l2"]
            ])
            ->addLabel($label2)
            ->addWritables([
                "l3" => $sections["l3"],
            ])
            ->build();

        $labels = $pickA->getLabels();

        $this->assertContains($label1, $labels);
        $this->assertContains($label2, $labels);
    }

    public function testGetWritables()
    {
        $label1 = "l" . (string)rand();
        $label2 = "l" . (string)rand();

        $sections = [];
        for ($i = 1; $i <= 3; $i++) {
            $sections["l" . (string)$i] = SectionBuilder::begin()
                ->setId("s" . (string)rand())
                ->addContent((string)rand())
                ->build();
        }

        $pickA = PickABuilder::begin()
            ->setId("p" . (string)rand())
            ->addLabel($label1)
            ->addWritables([
                "l1" => $sections["l1"],
                "l2" => $sections["l2"]
            ])
            ->addLabel($label2)
            ->addWritables([
                "l3" => $sections["l3"],
            ])
            ->build();

        $writables = $pickA->getWritables();

        $this->assertContains($sections["l1"], $writables);
        $this->assertContains($sections["l2"], $writables);
        $this->assertContains($sections["l3"], $writables);

    }
}
