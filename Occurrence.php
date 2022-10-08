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
     * Construct a new Event
     *
     */
    public function __construct() {
        // define the fields that represent our event (and their default/blank values)
        $this->set('date', '');
        $this->set('excluded', false);
        $this->set('formatted', false);
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
    public function set($key, $value) {
        /*if($key === 'date') {
            $value = $value ? wireDate('Y-m-d', $value) : '';
        } else if($key === 'title') {
            $value = $this->sanitizer->text($value);
        }*/
        if($key === 'excluded') {
            $value = false;
        }
        if($key === 'date') {
            if($value instanceof \DateTime){
                $value = $value->format('Y-m-d H:i:s');
            }
        }
        return parent::set($key, $value);
    }

    /**
     * Return a string representing this event
     *
     * @return string
     *
     */
    public function __toString() {
        return "$this->date: $this->title";
    }
}
