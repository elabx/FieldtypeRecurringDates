<div x-data="recurringDatesInput">
    <div class="">
        <div class="uk-space-between uk-grid" uk-grid>
            <div>
                <label class="uk-form-label">Initial date</label>
                <input type="date" value="">
            </div>
        </div>

        <div class="uk-flex-center uk-grid-small uk-grid" uk-grid>
            <div>
                <div class="">
                    <label class="uk-form-label">Every</label>
                    <input class="uk-input" value="">
                </div>
            </div>
            <div>
                <div class="">
                    <label class="uk-form-label">Initial date</label>
                    <select x-model="freq" class="InputfieldMaxWidth uk-select">
                        <option value="DAILY" class="days">Day(s)</option>
                        <option value="WEEKLY" class="weeks">Week(s)</option>
                        <option value="MONTHLY" class="months">Month(s)</option>
                        <option value="YEARLY" class="years">Year(s)</option>
                    </select>
                </div>
            </div>
            <div class="uk-width-1-1"  x-id="['day-input']">
                <div class="uk-grid uk-grid-small uk-flex-center" uk-grid>
                    <template x-for="day in daysOfWeek" >
                        <div>
                            <label :for="$id('day-input', day.abbreviation)" x-text="day.abbreviation"></label>
                            <input :id="$id('day-input', day.abbreviation)"
                                   x-model="byday"
                                   :value="day.value"
                                   class="uk-checkbox" type="checkbox">
                        </div>
                    </template>
                </div>
            </div>
            <div class="">
                <div class="uk-flex-center uk-grid">
                    <div class="">
                        <label>After</label>
                        <input class="uk-input" type="number">
                    </div>
                    <div class="">
                        <label>On</label>
                        <input type="date">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
