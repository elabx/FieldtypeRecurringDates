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
class RecurringDate extends WireData
{

    /**
     * Construct a new Event
     *s
     */
    public function __construct()
    {
        // define the fields that represent our event (and their default/blank values)
        $this->set('occurrences', new OccurrenceArray());
        $this->set('settings', new RecurringDateSettings());
        $this->set('rrule', null);
        $this->set('pagination', []);
        parent::__construct();
    }

    /**
     * Set a value to the event: date, location or notes
     *
     * @param string $key
     * @param string $value
     * @return WireData|self
     *
     */
    public function set($key, $value)
    {
        if ($key == "settings" && is_array($value)) {
            foreach($value as $key){
                return $this->settings->set($key,  $value);
            }
        } else {
            return parent::set($key, $value);

        }
        return $this;
    }

    /**
     * Return a string representing this event
     *
     * @return string
     *
     */
    public function __toString()
    {
        return (string) $this->occurrences;
    }
}
