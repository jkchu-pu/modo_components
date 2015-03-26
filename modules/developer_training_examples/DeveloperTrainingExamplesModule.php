<?php

/*
 * Copyright © 2010 - 2014 Modo Labs Inc. All rights reserved.
 *
 * The license governing the contents of this file is located in the LICENSE
 * file located at the root directory of this distribution. If the LICENSE file
 * is missing, please contact sales@modolabs.com.
 *
 */

class DeveloperTrainingExamplesModule extends KGOModule {

    protected $exampleFormData = array();

    protected function initializeForPageConfigObjects_index(KGOUIPage $page, $objects) {}

    /* Examples - External Data Retrieval */
    protected function initializeForPageConfigObjects_externaldataretrieval_example1(KGOUIPage $page, $objects) {}
    protected function initializeForPageConfigObjects_externaldataretrieval_example2(KGOUIPage $page, $objects) {}

    /* Examples - Controllers and Object Definitions */
    protected function initializeForPageConfigObjects_controllersobjdefs_example1(KGOUIPage $page, $objects) {}
    protected function initializeForPageConfigObjects_controllersobjdefs_example2(KGOUIPage $page, $objects) {}
    protected function initializeForPageConfigObjects_controllersobjdefs_example3(KGOUIPage $page, $objects) {}
    protected function initializeForPageConfigObjects_controllersobjdefs_example4(KGOUIPage $page, $objects) {}

    /* Example - Form Controller */
    protected function initializeForPage_formcontroller_example(KGOUIPage $page, $objects) {
        $page->appendToRegionContents('content', $this->getForm('formcontroller_example'));
    }

    protected function initializeForm_formcontroller_example() {
        // Load the form from configuration
        $objDef = $this->getConfig('page-formcontroller-example');

        // Instantiate the configuration as a KGOFormController
        $controller = KGOFormController::factory($objDef);

        // Return the intiialized form
        return $controller;
    }

    protected function processForm_formcontroller_example($form) {
        // If the form is valid
        if($form->isValid()) {
            // Save the form data as an instance variable
            $this->exampleFormData = $form->getSubmittedValues();
        }
    }

    protected function initializeForPageConfigObjects_formcontroller_example_submission(KGOUIPage $page, $objects) {}

    protected function initializeForPage_modules_example1(KGOUIPage $page) {

        // Create a List
        $list = KGOUIObject::factory(array(
            'class' => 'KGOUIList',
            'options' => array(
                'grouped' => true,
                'inset' => true
            )
        ));

        // Create an array of list items
        $listItems = array(
            KGOUIObject::factory(array(
                'class' => 'KGOUIListItem',
                'fields' => array(
                    'title' => "One"
                )
            )),
            KGOUIObject::factory(array(
                'class' => 'KGOUIListItem',
                'fields' => array(
                    'title' => "Two"
                )
            )),
            KGOUIObject::factory(array(
                'class' => 'KGOUIListItem',
                'fields' => array(
                    'title' => "Three"
                )
            )),
        );

        // Set the list's 'items' region to be our array of list items
        $list->setRegionContents('items', $listItems);

        // Append the list to the page
        $page->appendToRegionContents('content', $list);
    }

    public function getSubmittedFirstName() {
        return kgo_array_val($this->exampleFormData, 'firstname', null);
    }

    public function getSubmittedLastName() {
        return kgo_array_val($this->exampleFormData, 'lastname', null);
    }

    public function getSubmittedSecret() {
        return kgo_array_val($this->exampleFormData, 'secret', null);
    }

    public function getSubmittedLanguage() {
        return kgo_array_val($this->exampleFormData, 'language', null);
    }

    public function getSubmittedColor() {
        return kgo_array_val($this->exampleFormData, 'color', null);
    }

    /* Misc Examples */
    public function getExampleHTML() {
        return "<p><b>Hello</b>, World!</p>";
    }
}