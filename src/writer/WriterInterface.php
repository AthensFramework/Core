<?php

namespace Athens\Core\Writer;

use Athens\Core\Visitor\VisitorInterface;
use Athens\Core\WritableBearer\WritableBearerInterface;
use Athens\Core\Email\EmailInterface;
use Athens\Core\Field\FieldInterface;
use Athens\Core\Form\FormInterface;
use Athens\Core\Form\FormAction\FormActionInterface;
use Athens\Core\PickA\PickAFormInterface;
use Athens\Core\PickA\PickAInterface;
use Athens\Core\Section\SectionInterface;
use Athens\Core\Page\PageInterface;
use Athens\Core\Row\RowInterface;
use Athens\Core\Table\TableInterface;
use Athens\Core\Link\LinkInterface;
use Athens\Core\Filter\FilterInterface;
use Athens\Core\Table\TableFormInterface;

interface WriterInterface extends VisitorInterface
{

}
