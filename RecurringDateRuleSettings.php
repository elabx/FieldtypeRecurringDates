<?php namespace ProcessWire;

class RecurringDateRuleSettings extends WireData
{
    public $limit_mode = "";
    public $rrule = "";
    public $filters = [];
    public function __construct($data = null)
    {
        //parent::__construct();

        if (is_array($data)) {
            if (array_key_exists('limit_mode', $data)) {
                $this->limit_mode = $data['limit_mode'];
            }
            if (array_key_exists('rrule', $data)) {
                $this->rrule = $data['rrule'];
            }
            if (array_key_exists('filters', $data)) {
                $this->filters = $data['filters'];
            }
        }
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
