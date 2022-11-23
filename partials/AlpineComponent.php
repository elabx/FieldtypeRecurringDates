<?php namespace ProcessWire; ?>
<?php
/** @var $inputfield InputfieldRecurringDates */
/** @var $fieldtype FieldtypeRecurringDates */
/** @var $sanitizer Sanitizer */
?>
<div data-inputfield-name="<?= $inputfield->name ?>" defer-x-data="recurringDatesInput">
    <input <?= $inputfield->getAttributesString() ?>>
    <input x-model="_settings" type="hidden" name="<?= $inputfield->name ?>_settings">
  <?php
  $pre_text = htmlspecialchars($inputfield->getAttribute('data-json-rrule'), ENT_QUOTES, "UTF-8")
  ?>
    <!--<pre x-ref="pre-debug" style="white-space: normal;overflow-wrap: break-word;">
        <?php /*echo $pre_text; */ ?>
    </pre>-->

    <div class="uk-grid-divider uk-grid uk-child-width-1-2" uk-grid>

        <div>
            <div uk-grid>
                <div class="uk-grid" uk-grid>

                    <div>
                        <div class="uk-grid" uk-grid>
                            <div>
                                <label class="uk-form-label">Starts on:</label>
                                <input x-ref="dtstart-datetime-input"
                                       type="date"
                                       x-model="rrule.DTSTART"
                                       class="uk-input" value="">
                            </div>

                        </div>
                    </div>

                    <div class="">

                        <div class="">
                            <div class="uk-form-controls">
                                <div class="uk-form-label">Ends:</div>

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
            <div class="uk-margin-top">

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
    <div class="uk-margin">
        <div class="uk-box-shadow-small ">
            <div class="uk-grid" uk-grid>
                <div class="uk-width-1-1 ">
                    <div x-on:click="show_table = !show_table"
                         class="uk-flex uk-padding-small uk-flex-middle uk-flex-between">
                        <div>
                            <i class="uk-margin-small-right" uk-icon="list">
                              <?php /** @var $occurrences RecurringDate */ ?>
                            </i>
                          <?= $inputfieldValue->rrule ? $inputfieldValue->rrule->humanReadable() : "" ?>
                        </div>
                        <div>
                            <button class="ui-button" type="button">
                                Show
                            </button>
                        </div>
                    </div>
                </div>

                <div x-cloak x-show="show_table" class="uk-width-1-1">
                    <hr class="uk-margin uk-margin-top">

                    <table class="uk-table uk-table-small uk-table-divider" id="<?= $inputfield->name ?>_ocurrences"
                           class="uk-table-small uk-table uk-table-striped">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Exclude</th>
                        </tr>
                        </thead>
                      <?php foreach ($occurrences as $i => $d): ?>
                          <tr>
                              <td><?= $d ?></td>
                              <td>
                                  <input id="input-<?= $i ?>" type="checkbox">
                              </td>
                          </tr>
                      <?php endforeach ?>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
