
document.addEventListener('alpine:init', (e) => {
    Alpine.data('recurringDatesRuleInput', function () {
        return {
            inputfield: '',
            _rrule: null,
            rrule: {
                DTSTART: "",
                FREQ: "DAILY",
                INTERVAL: 1,
                COUNT: 0,
                UNTIL: "",
                BYDAY: [],
                BYMONTH: [],
                BYMONTHDAY: []
            },
            _settings: null,
            settings: null,
            hard_limit: null,
            catalogues: {
                filters: [
                    {label: "Months", value: 'BYMONTH'},
                    {label: "Days of the week", value: 'BYDAY'},
                    {label: "Days of the month", value: 'BYMONTHDAY'},
                ],
                daysOfWeek: [
                    {name: 'Monday', value: 'MO'},
                    {name: 'Tuesday', value: 'TU'},
                    {name: 'Wednesday', value: 'WE'},
                    {name: 'Thursday', value: 'TH'},
                    {name: 'Friday', value: 'FR'},
                    {name: 'Saturday', value: 'SA'},
                    {name: 'Sunday', value: 'SU'},
                ],
            },

            init: function () {
                this.inputfield = this.$el.dataset.inputfieldName;
                this.pageId = parseInt(this.$el.dataset.pageId);
                this.fieldId = parseInt(this.$el.dataset.fieldId)
                this.hard_limit = parseInt(this.$el.dataset.hardLimit)
                this.setWeekStart(this.$el.dataset.weekStart);

                this.$watch('rrule', (prop) => {
                    this.saveString();
                });

                this.$watch('settings', (prop, oldValue) => {
                    if (!this.settings) return; // Don't process if settings is null
                    this._settings = JSON.stringify(this.settings);
                    //console.log(this.settings);
                    var self = this;
                    if (self.settings.filters) {
                        self.catalogues.filters.forEach(function (filter) {
                            var found = self.settings.filters.find(filter_setting => filter_setting === filter.value);
                            if (found === undefined) {
                                if (self.rrule[filter.value] !== undefined) {
                                    self.rrule[filter.value] = [];
                                }
                            }
                        });
                    }

                    this.saveString();
                });

                var mainInput = this.$el.querySelector("[data-main-input]");
                var json_rrule = mainInput ? mainInput.dataset.rrule : null;
                var widget_settings = mainInput ? mainInput.dataset.settings : null;
                // Always initialize settings - use parsed value if provided, otherwise use defaults
                if (widget_settings) {
                    this.settings = JSON.parse(widget_settings);
                } else {
                    // Initialize with default settings when empty - needed for form input
                    this.settings = {
                        limit_mode: "",
                        rrule: "",
                        filters: []
                    };
                }
                
                if (json_rrule) {
                    this.rrule = JSON.parse(json_rrule);
                }
            },


            // Rotate the days of the week list so it begins on the configured day
            setWeekStart: function (weekStart) {
                var days = this.catalogues.daysOfWeek;
                var startIndex = days.findIndex(day => day.value === weekStart);
                if (startIndex > 0) {
                    this.catalogues.daysOfWeek = days.slice(startIndex).concat(days.slice(0, startIndex));
                }
            },

            is_filtering: function (filter) {
                if (this.rrule[filter] !== null || this.rrule[filter] !== undefined) {
                    if (this.rrule[filter].length) {
                        return true;
                    }
                }
            },

            cloneObject: function (obj) {
                // basic type deep copy
                if (obj === null || obj === undefined || typeof obj !== 'object') {
                    return obj
                }
                // array deep copy
                if (obj instanceof Array) {
                    var cloneA = [];
                    for (var i = 0; i < obj.length; ++i) {
                        cloneA[i] = this.cloneObject(obj[i]);
                    }
                    return cloneA;
                }
                // object deep copy
                var cloneO = {};
                for (var i in obj) {
                    cloneO[i] = this.cloneObject(obj[i]);
                }
                return cloneO;
            },

            saveString: function () {
                // Don't save if settings is not initialized
                if (!this.settings) {
                    this._rrule = "";
                    return;
                }

                // Check if we have a valid DTSTART - if not, send empty value
                if (!this.rrule || !this.rrule.DTSTART || this.rrule.DTSTART === "") {
                    this._rrule = "";
                    return;
                }

                var rrule_copy = this.cloneObject(this.rrule);
                if (this.settings.limit_mode === "count") {
                    delete rrule_copy.UNTIL
                }
                if (this.settings.limit_mode === "until") {
                    delete rrule_copy.COUNT
                }
                if (this.settings.limit_mode === "never") {
                    delete rrule_copy.UNTIL
                    delete rrule_copy.COUNT
                    //rrule_copy.COUNT = this.hard_limit;
                }
                //console.log(rrule_copy);
                this.save_value = {
                    rrule: rrule_copy,
                    settings: this.settings
                }
                var json_string = JSON.stringify(this.save_value);
                /* if (this.$refs['pre-debug'] !== undefined) {
                    this.$refs['pre-debug'].innerText = JSON.stringify(rrule_copy, null, 2);
                } */
                this._rrule = json_string;
            }
        }
    })
});

