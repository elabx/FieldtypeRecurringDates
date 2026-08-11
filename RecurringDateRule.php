<?php namespace ProcessWire;

use DateTime;
use RRule\RRule;

/**
 * RecurringDate
 * @property RRule $rrule RRule in JSON format;
 *
 */

class RecurringDateRule extends WireData
{
    /** @var $rrule RRule\RRule|null */
    protected $rrule = null;
    public function __construct(){
        // define the fields that represent our event (and their default/blank values)
        $this->set('settings', new RecurringDateRuleSettings());
        $this->set('rrule', null);
        parent::__construct();
    }

    public function getRule(){
        return $this->rrule;
    }

    public function __toString(){
        $value = [
            'settings' => $this->settings,
            'rrule' => $this->getRule()
        ];
        //bd(string($value));
        return json_encode($value);
    }
}
