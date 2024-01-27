<?php

/**
 * @file
 * A form to collect an email address for RSVP details.
 */

 namespace Durpal\rsvplist\Form;

 use Drupal\Core\FormBase;
 use Drupal\Core\Form\FormBaseInterface;

 class RSVPForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'rsvplist_email_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        // Attempt to get the fully loaded node object of the viewed page.
        $node = \Drupal::routeMatch()->getParameter('node');

        // Some pages may not be nodes though and $node will be NULL on those pages.
        // If a node was loaded, get the node id.
        if ( !(is_null($node)) ) {
            $nid = $node->id();
        }
        else{
            // If a node could not be loaded, default to 0;
            $nid = 0;
        }

        $nid = $node->id();
        // Establish the $form render array. It has an email text field,
        // a submit button, and a hidden field containing the node ID
        $form['email'] = [
            '#type' => 'textfield',
            '#title' => t('Email address'),
            '#size' => 25,
            '#description' => t('We will send updates to the email address you
            provide.'),
            '#required' => TRUE,
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => t('RSVP'),
        ];
        $form['nid'] = [
            '#type' => 'hidden',
            '#value' => $nid,
        ];
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $submitted_email = $form_state->getValue('email');
        $this->messenger()->addMessage(t("The form is working! You enter @entry.",
        ['@entry' => $submitted_email]));
    }
 }