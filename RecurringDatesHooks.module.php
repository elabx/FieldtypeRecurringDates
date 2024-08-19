<?php namespace ProcessWire;

class RecurringDatesHooks extends WireData implements Module
{

    public function ready()
    {
        $this->addHookBefore('Pages::deleted', $this, 'hookAfterPageDelete');
    }

    /**
     * Deletes the settings row for the database
     *
     * @param HookEvent $event
     * @return void
     *
     */
    public function hookAfterPageDelete($event)
    {
        $page = $event->arguments(0);
        $recurring_fields = $page->getFields()->find("type={$this->name}");
        foreach ($recurring_fields as $f) {
            $this->modules->FieldtypeRecurringDate::deleteSettings($page, $f);
        }
    }
}