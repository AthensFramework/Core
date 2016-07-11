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

    /**
     * Render $writableBearer into a string.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param WritableBearerInterface $writableBearer
     * @return string
     */
    public function visitWritableBearer(WritableBearerInterface $writableBearer);

    /**
     * Render $section into a string.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param SectionInterface $section
     * @return string
     */
    public function visitSection(SectionInterface $section);

    /**
     * Render $link into a string.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param LinkInterface $link
     * @return string
     */
    public function visitLink(LinkInterface $link);

    /**
     * Render $page into a string.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param PageInterface $page
     * @return string
     */
    public function visitPage(PageInterface $page);

    /**
     * Render $field into a string.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param FieldInterface $field
     * @return string
     */
    public function visitField(FieldInterface $field);

    /**
     * Render $row into a string.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param RowInterface $row
     * @return string
     */
    public function visitRow(RowInterface $row);

    /**
     * Render $table into a string.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param TableInterface $table
     * @return string
     */
    public function visitTable(TableInterface $table);

    /**
     * Render FormInterface into a string.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param FormInterface $form
     * @return string
     */
    public function visitForm(FormInterface $form);

    /**
     * Render FormActionInterface into a string.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param FormActionInterface $formAction
     * @return string
     */
    public function visitFormAction(FormActionInterface $formAction);

    /**
     * Render PickAInterface into a string.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param PickAInterface $pickA
     * @return string
     */
    public function visitPickA(PickAInterface $pickA);

    /**
     * Render PickAFormInterface into a string.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param PickAFormInterface $pickAForm
     * @return string
     */
    public function visitPickAForm(PickAFormInterface $pickAForm);

    /**
     * Render TableFormInterface into a string.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param TableFormInterface $tableForm
     * @return string
     */
    public function visitTableForm(TableFormInterface $tableForm);

    /**
     * Render a FilterInterface into a string.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param FilterInterface $filter
     * @return string
     */
    public function visitFilter(FilterInterface $filter);

    /**
     * Render an email message into an email body, given its template.
     *
     * @param EmailInterface $email
     * @return string
     */
    public function visitEmail(EmailInterface $email);
}
