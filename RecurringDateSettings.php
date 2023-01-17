<?php namespace ProcessWire;

class RecurringDateSettings extends WireData
{
    public $limit_mode;
    public $rrule;
    public $filters;
    public function __construct()
    {
        $this->limit_mode = "count";
        $this->rrule = "";
        $this->filters = [];
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
        return json_encode($value);
    }
}
