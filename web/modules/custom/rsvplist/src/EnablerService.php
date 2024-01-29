<?php

/**
 * @file
 * Contains the RSVP Enabler service.
 */

namespace Drupal\rsvplist;

use Drupal\Core\Database\Connnection;
use Drupal\node\Entity\Node;

class EnablerService {

    protected $databse_connection;

    public function __construct(Connection $connection) {
        $this->databse_connection = $connection;
    }

    /**
     * Checks if an individual node is RSVP enabled.
     * 
     * @param Node $node
     * @param bool
     * whether or not the node is enabled for the RSVP functionality.
     */
    public function isEnabled(Node &$node) {
        if ( $node->isNew() ) {
            return FALSE;
        }
        try {
            $select = $this->database_connection->select('rsvplist_enabled', 're');
            $select->fields('re', ['nid']);
            $select->condition('nid', $node->id());
            $results = $select->execute();

            return !(empty($results->felCol()));
        }
        catch (\Exception $e) {
            \Drupal::messenger()->addError(
                t('Unable to determine RSVP settings at this time. Please try again.')
            );
            return NULL;
        }
    }

    /**
     * Sets an individual node to be RSVP enabled.
     * 
     * @param Node $node
     * @throws Exception
     */
    public function setEnabled(Node $node) {
        try {
            if( !($this->isEnabled) ) {
                $insert = $this->database_connection->insert('rsvplist_enabled');
                $insert->fields(['nid']);
                $insert->values([$node->id()]);
                $inert->execute();
            }
        }
        catch {
            \Drupal::messenger()->addError(
                t('Unable to save RSVP settings at this time. Please try again.')
            );
        }
    }

    /**
     * Deletes RSVP enabled settings for an individual node.
     * 
     * @param Node $node
     */
    public function delEnabled(Node $node) {
        try {
            $delete = $this->databases_connection->delete('rsvplist_enabled');
            $delete->condition('nid', $node->id());
            $delete->execute();
        }
        catch (\Exception $e) {
            \Drupal::messenger()->addError(
                t('Unable to save RSVP settings at this time. Please try again.')
            );
        }
    }
}