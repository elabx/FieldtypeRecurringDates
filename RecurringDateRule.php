<?php namespace ProcessWire;

use DateTime;
use RRule\RRule;

/**
 * RecurringDate
 *
 * Contains the ocurrances, rrule data as json.
 *
 * @property OccurrenceArray $occurences
 * @property RRule $rrule RRule in JSON format;
 * @property bool $formatted
 *
 */
class RecurringDateRule extends WireData
{
    /** @var $rrule RRule\RRule|null */
    protected $rrule = null;
    public function __construct(){
        // define the fields that represent our event (and their default/blank values)
        $this->set('rrule', null);
        parent::__construct();
    }

    public function __toString(){
        return (string) $this->rrule->humanReadable();
    }
}
