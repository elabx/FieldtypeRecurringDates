<?php namespace ProcessWire;

class RecurringDatesSettings extends WireData
{
    public $limit_mode = "count";
    public $rrule = "";
    public $filters = [];
    public function __construct()
    {
        parent::__construct();
    }

    public function set($key, $value)
    {
        return parent::set($key, $value);
    }

    public function __toString()
    {
        $value = [
          'limit_mode' => $this->limit_mode,
          'filters' => $this->filters,
          'rrule' => $this->rrule
        ];
        $value = json_encode($value);
        return $value;
    }
}
