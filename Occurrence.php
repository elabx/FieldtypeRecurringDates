<?php namespace ProcessWire;

use DateTime;

/**
 * FieldtypeRecurringEvents: Occurrence
 *
 * An individual event item to be part of an OccurrenceArray for a Page
 *
 * @property DateTime $date  Date string in Y-m-d format
 * @property string $title Title of the event
 * @property bool $formatted
 *
 */
class Occurrence extends WireData {

    /**
     * Construct a new occurrence
     *
     */
    public function __construct() {
        // define the fields that represent our event (and their default/blank values)
        $this->set('date', '');
        // $this->set('excluded', false);
        $this->set('formatted', false);
        $this->set('format', 'Y-m-d');
        parent::__construct();
    }

    /**
     * Set a value to the event: date, location or notes
     *
     * @param string $key
     * @param DateTime $value
     * @return WireData|self
     *
     */
    public function set($key, $value) {
        /*if($key === 'excluded') {
            $value = false;
        }*/
        return parent::set($key, $value);
    }

    public function format($format = "U"){
        return $this->date->format($format);
    }

    /**
     * Return a string representing this event
     *
     * @return string
     *
     */
    public function __toString() {
        return $this->date->format($this->format);
    }
}
