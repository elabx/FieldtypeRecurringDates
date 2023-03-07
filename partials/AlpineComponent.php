<?php namespace ProcessWire; ?>
<?php
/** @var $inputfield InputfieldRecurringDates */
/** @var $fieldtype FieldtypeRecurringDates */
/** @var $sanitizer Sanitizer */
?>
<div data-page-id="<?= $inputfield->hasPage->id ?>"
     data-field-id="<?= $inputfield->hasField->id ?>"
     data-inputfield-name="<?= $inputfield->name ?>"
     data-hard-limit="<?= $inputfield->hardLimit ?>"
     data-inputfield-limit="<?= $inputfield->pageSize ?>"
     defer-x-data="recurringDatesInput">
    <input <?= $inputfield->getAttributesString() ?>>
    <input x-model="_settings" type="hidden" name="<?= $inputfield->name ?>_settings">
    <?php
    $pre_text = htmlspecialchars($inputfield->getAttribute('data-json-rrule'), ENT_QUOTES, "UTF-8")
    ?>
    <!--<pre x-ref="pre-debug" style="white-space: normal;overflow-wrap: break-word;">
        <?php /*echo $pre_text; */ ?>
    </pre>-->

    <div class="uk-grid-divider uk-grid uk-child-width-1-2@m" uk-grid>

        <div>
            <div uk-grid>
                <div class="uk-grid" uk-grid>

                    <div>
                        <div class="uk-grid" uk-grid>
                            <div>
                                <label class="uk-form-label">Starts on:</label>
                                <input x-ref="dtstart-datetime-input"
                                       type="<?= $inputfield->getDateStartInputType() ?>"
                                       x-model="rrule.DTSTART"
                                       class="uk-input" value="">
                            </div>
                        </div>
                    </div>

                    <div class="">

                        <div class="">
                            <div class="uk-form-controls">

                                <div class="uk-form-label uk-margin-small">Ends:</div>

                                <div class="uk-grid uk-child-width-1-1 uk-grid-small" uk-grid>
                                    <div>
                                        <label class="">

                                            <input class="uk-radio uk-flex-none"
                                                   type="radio"
                                                   x-model="settings.limit_mode"
                                                   value="never"
                                                   :name="`limit-rule-options-${inputfield}`">
                                            Never
                                        </label>
                                        <div class="uk-inline"
                                             uk-tooltip="Hard limits events to a count of <?= $inputfield->hardLimit ?>">
                                            <span uk-icon="ratio: 0.8; icon:question"></span>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="">
                                            <input class="uk-radio uk-flex-none"
                                                   type="radio"
                                                   x-model="settings.limit_mode"
                                                   value="until"
                                                   :name="`limit-rule-options-${inputfield}`">
                                            On
                                            <span class="uk-margin-small-left">
                                                    <input value=""
                                                           :disabled="settings.limit_mode !== 'until'"
                                                           class="uk-input uk-width-auto"
                                                           x-model="rrule.UNTIL"
                                                           type="date">
                                                </span>
                                        </label>
                                    </div>


                                    <div><label class="uk-flex uk-flex-middle">
                                            <input class="uk-radio uk-flex-none"
                                                   type="radio"
                                                   x-model="settings.limit_mode"
                                                   value="count"
                                                   :name="`limit-rule-options-${inputfield}`">
                                            <span class="uk-margin-small-left uk-flex uk-flex-middle uk-flex-nowrap">
                                        <span>After: </span>
                                        <input x-model.number="rrule.COUNT"
                                               min="1"
                                               :disabled="settings.limit_mode !== 'count'"
                                               class="uk-input uk-margin-small-left"
                                               type="number">
                                            <span class="uk-text-small uk-margin-small-left">occurrences</span>
                                    </span>
                                        </label>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-flex-center uk-grid-small uk-grid" uk-grid>
                <div class="uk-width-1-1">
                    <div class="">
                        <label class="uk-form-label">Every</label>
                        <div class="uk-grid-small uk-child-width-1-2" uk-grid>
                            <div>
                                <input class="uk-input uk-width-1-1" x-model.number="rrule.INTERVAL" value="">
                            </div>
                            <div>
                                <select x-model="rrule.FREQ" class="InputfieldMaxWidth uk-select">
                                    <option value="DAILY" class="days">Day(s)</option>
                                    <option value="WEEKLY" class="weeks">Week(s)</option>
                                    <option value="MONTHLY" class="months">Month(s)</option>
                                    <option value="YEARLY" class="years">Year(s)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>

            <span class="uk-form-label">Only on:</span>
            <div class="uk-margin-small-top">

                <ul class="uk-list-divider uk-list">
                    <template x-for="filter in catalogues.filters">
                        <li x-id="['filter-input']" class="uk-form-controls uk-form-controls-text">
                            <input :id="$id('filter-input', filter.value)"
                                   x-model="settings.filters"
                                   :value="filter.value"
                                   class="uk-checkbox"
                                   type="checkbox">

                            <label :for="$id('filter-input', filter.value)"
                                   x-text="filter.label"></label>
                            <div :id="`filter-${filter.value}-${inputfield}`"></div>

                        </li>
                    </template>
                </ul>
            </div>


            <template x-teleport="#filter-BYDAY-<?= $inputfield->name ?>">
                <div class="uk-margin-top"
                     x-cloak
                     x-show="settings.filters.includes('BYDAY')">

                    <div class="" x-id="['day-input']">
                        <div class="uk-grid uk-grid-small" uk-grid>
                            <template x-for="day in catalogues.daysOfWeek">
                                <div>
                                    <label :for="$id('day-input', day.name)"
                                           x-text="day.name"></label>
                                    <input :id="$id('day-input', day.name)"
                                           x-model.number="rrule.BYDAY"
                                           :value="day.value"
                                           class="uk-checkbox"
                                           type="checkbox">
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>


            <template x-teleport="#filter-BYMONTH-<?= $inputfield->name ?>">
                <div>
                    <div class="uk-margin-top"
                         x-cloak
                         x-show="settings.filters.includes('BYMONTH')">
                        <div class="">
                            <div class="uk-grid uk-child-width-1-4@m uk-grid-small" uk-grid>
                                <?php foreach ($fieldtype->getMonths() as $i => $f): ?>
                                    <div class="">
                                        <input id="bymonth-<?= $sanitizer->name($f) ?>"
                                               x-model.number="rrule.BYMONTH"
                                               :value="<?= $i + 1 ?>"
                                               class="uk-checkbox"
                                               type="checkbox">
                                        <label class="uk-form-label" for="bymonth-<?= $sanitizer->name($f) ?>">
                                            <?= $f ?>
                                        </label>

                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </template>


            <template x-teleport="#filter-BYMONTHDAY-<?= $inputfield->name ?>">
                <div class="uk-margin-top"
                     x-cloak
                     x-show="settings.filters.includes('BYMONTHDAY')">
                    <div class="bymonthday-filter-wrapper">
                        <div class="uk-grid uk-grid-collapse" uk-grid>
                            <?php for ($i = 1; $i <= 31; $i++): ?>
                                <div class="bymonthday-grid-item">
                                    <div class="bymonthday-wrapper">

                                        <input id="bymonthday-<?= $i ?>" x-model.number="rrule.BYMONTHDAY"
                                               value="<?= $i ?>"
                                               type="checkbox">
                                        <div class="bymonth-checkbox-background">
                                            <label for="bymonthday-<?= $i ?>"><?= $i ?></label>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor ?>
                        </div>
                    </div>
                </div>
            </template>


        </div>
    </div>
    <div class="uk-width-1-1@m uk-margin-auto uk-margin">
        <div class="uk-box-shadow-small ">
            <div class="uk-width-1-1 uk-padding-small">
                <div class="uk-grid uk-flex-between" uk-grid>
                    <div class="uk-width-1-1 uk-width-expand@m" x-on:click="show_table = !show_table">
                        <i class="uk-margin-small-right" uk-icon="list">
                            <?php /** @var $occurrences RecurringDate */ ?>
                        </i>
                        <?= $inputfieldValue->rrule ? $inputfieldValue->rrule->humanReadable() : "" ?>
                    </div>

                    <div class="uk-width-1-1 uk-width-auto@m">
                        <div class="uk-grid-small uk-flex-right uk-grid" uk-grid>
                            <div>
                                <button x-on:click="show_table = !show_table" type="button" class="uk-button uk-button-link" x-html="getToggleText()"></button>
                            </div>
                            <div>
                                <select @change="updateEventList()" x-model.number="data.pagination.limit">

                                    <optgroup label="Default limit:">
                                        <option selected value="<?= $inputfield->pageSize ?>">
                                            <?= $inputfield->pageSize ?>
                                        </option>
                                    </optgroup>

                                    <optgroup label="Limits:">
                                        <option value="10">5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </optgroup>
                                </select>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div x-cloak x-show="show_table" class=" uk-width-1-1">
                <hr class="uk-margin uk-margin-top">

                <div class=" uk-padding-small">
                    <table class="uk-table uk-table-small uk-table-divider" id="<?= $inputfield->name ?>_ocurrences"
                           class="uk-table-small uk-table uk-table-striped">
                        <thead>
                        <tr>
                            <th>Month</th>
                            <th>Day</th>
                            <th>Year</th>
                        </tr>
                        </thead>
                        <template x-for="date in data.dates">
                            <tr>
                                <td x-text="date.month"></td>
                                <td x-text="date.day"></td>
                                <td x-text="date.year"></td>
                            </tr>
                        </template>
                    </table>
                    <div class="uk-flex uk-flex-middle uk-flex-right">
                        <div x-text="data.pagination.pagination_string"></div>
                        <ul class="uk-margin-small-left uk-margin-small uk-pagination" role="navigation"
                            aria-label="Pagination links">
                            <li aria-label="" class="" aria-current="true">
                                <button @click="previousPage" type="button">
                                    <span uk-icon="chevron-left"></span>
                                </button>
                            </li>
                            <li aria-label="" class="">
                                <button @click="nextPage" type="button">
                                    <span uk-icon="chevron-right"></span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
