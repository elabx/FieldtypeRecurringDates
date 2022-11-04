<?php namespace ProcessWire;

use DateTime;

/**
 * FieldtypeRecurringEvents: Occurrence
 *
 * An individual event item to be part of an OccurrenceArray for a Page
 *
 * @property OccurrenceArray $occurences
 * @property string $rrule RRule in JSON format;
 * @property bool $formatted
 *
 */
class RecurringDate extends WireData
{

    /**
     * Construct a new Event
     *
     */
    public function __construct()
    {
        // define the fields that represent our event (and their default/blank values)
        $this->set('occurrences', new OccurrenceArray());
        $this->set('settings', new RecurringDatesSettings());
        $this->set('rrule', '');
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
    }

    public function serializeSettings()
    {
        return json_encode([
          'settings' => json_encode($settings),
          'rrule'    => $this->rrule
        ]);
    }

    /**
     * Return a string representing this event
     *
     * @return string
     *
     */
    public function __toString()
    {
        return $this->ocurrences;
    }
}
