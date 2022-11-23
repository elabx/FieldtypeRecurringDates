<?php namespace ProcessWire;

/**
 * FieldtypeEvents: RecurringDateArray
 *
 * Contains multiple occurrences of an RRule definition
 *
 */
class OccurrenceArray extends PaginatedArray {

    /**
     * Is given item valid to store in this EventArray?
     *
     * @param Event $item
     * @return bool
     *
     */
    public function makeBlankItem()
    {
        return $this->wire(new Occurrence());
    }

    public function isValidItem($item) {
        return $item instanceof Occurrence;
    }

    /**
     * Make a string value to represent these events that can be used for comparison purposes
     *
     * @return string
     *
     */
    public function __toString() {
        $a = [];
        foreach($this as $item) $a[] = (string) $item;
        return implode("\n", $a);
    }
}
