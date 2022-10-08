<?php namespace ProcessWire;?>
<div x-data="recurringDatesInput">
    <input <?= $inputfield->getAttributesString() ?>>
    <?php
    $pre_text =  htmlspecialchars($inputfield->getAttribute('data-json-rrule'), ENT_QUOTES, "UTF-8")

    ?>
    <!--<pre x-ref="pre-debug" style="white-space: normal;overflow-wrap: break-word;">
        <?php /*echo $pre_text; */?>
    </pre>-->

    <div class="uk-margin-medium-top uk-grid-divider uk-grid uk-child-width-1-2" uk-grid>
        <div>
            <div class="uk-space-between uk-flex-left uk-grid" uk-grid>
                <div>
                    <label class="uk-form-label">Initial date</label>
                    <input x-ref="dtstart-datetime-input"
                           type="datetime-local"
                           x-model="rrule.DTSTART"
                           class="uk-input" value="">
                </div>
            </div>

            <div class="uk-flex-center uk-grid-small uk-grid" uk-grid>
                <div class="uk-width-1-1">
                    <div class="uk-flex uk-child-width-1-2 uk-grid uk-flex-center" uk-grid>
                        <div class="">
                            <div class="">
                                <label class="uk-form-label">Every</label>
                                <input class="uk-input uk-width-1-1" x-model="rrule.INTERVAL" value="">
                            </div>
                        </div>
                        <div>
                            <div class="">
                                <label class="uk-form-label">Frequency</label>
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

                <div class="uk-margin-top uk-width-1-1">
                    <div class="uk-child-width-1-2 uk-grid" uk-grid>
                        <div class="uk-width-1-1">
                            <div class="uk-form-controls">
                                <label><input class="uk-radio"
                                              type="radio"
                                              x-model="limit_mode"
                                              value="count"
                                              name="limit-rule-options">
                                    Count
                                </label><br>
                                <label>
                                    <input class="uk-radio"
                                              type="radio"
                                              x-model="limit_mode"
                                               value="until"
                                              name="limit-rule-options">
                                    Until specific date
                                </label>
                            </div>
                        </div>
                        <div x-show="limit_mode == 'count'" class="limit-rule-options-wrapper">
                            <label for="<?=$this->name?>-count">After</label>
                            <input x-model="rrule.COUNT"
                                   min="1"
                                   value="1"
                                   class="uk-input"
                                   type="number"> Times(s)
                        </div>
                        <div x-show="limit_mode == 'until'" class="">
                            <label for="<?=$this->name?>-until"
                                   class="uk-form-label">On date</label>
                            <input value=""
                                   class="uk-input"
                                    x-model="rrule.UNTIL"
                                   type="datetime-local">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <span class="">Filter by:</span>
            <div class="uk-margin-small-top" x-id="['filter-input']">
                <div class="uk-grid uk-grid-small uk-child-width-auto" uk-grid>
                    <template x-for="filter in catalogues.byDay">
                        <div class="uk-form-controls uk-form-controls-text">
                            <label :for="$id('filter-input', filter.value)"
                                   x-text="filter.text"></label>
                            <input :id="$id('filter-input', filter.value)"
                                   x-model="is_filtering(filter.value)"
                                   :value="filter.value"
                                   class="uk-checkbox"
                                   type="checkbox">
                        </div>
                    </template>
                </div>
            </div>


            <hr>
            <div class="" x-id="['day-input']">
                <div class="uk-grid uk-grid-small" uk-grid>
                    <template x-for="day in catalogues.daysOfWeek">
                        <div>
                            <label :for="$id('day-input', day.abbreviation)"
                                   x-text="day.abbreviation"></label>
                            <input :id="$id('day-input', day.abbreviation)"
                                   x-model="rrule.BYDAY"
                                   :value="day.value"
                                   class="uk-checkbox"
                                   type="checkbox">
                        </div>
                    </template>
                </div>
            </div>


            <hr>
            <div class="" x-id="['day-input']">
                <div class="uk-grid uk-child-width-1-4@m uk-grid-small" uk-grid>
                    <?php foreach ($fieldtype->getMonths() as $i => $f): ?>
                        <div class="">
                            <input id="bymonth-<?= $sanitizer->name($f) ?>"
                                   x-model="rrule.BYMONTH"
                                   :value="<?= $i + 1?>"
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
    <div class="uk-margin-large">
        <table class="uk-table-small uk-table uk-table-striped">
            <thead>
            <tr>

                <th>Date RFC</th>
                <th>Date</th>
                <th>Exclude</th>
            </tr>
            </thead>
            <?php /** @var $occurrences OccurrenceArray */?>
            <?php foreach ($occurrences as $i => $d): ?>
                <tr>
                    <td><?= date("r", strtotime($d->date)) ?></td>
                    <td><?= $d ?></td>
                    <td>
                        <input id="input-<?= $i ?>" type="checkbox">
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
