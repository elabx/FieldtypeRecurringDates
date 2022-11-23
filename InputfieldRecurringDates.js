function initInputfieldRecurringDates(root) {
    if (root === undefined) {
        root = document;
    }
    let components = root.querySelectorAll("[defer-x-data]");
    components.forEach(function (component) {
        // https://github.com/alpinejs/alpine/issues/359#issuecomment-973688464
        let alpineComponent = component.getAttribute('defer-x-data');
        Alpine.mutateDom(function () {
            component.setAttribute('x-data', alpineComponent);
        })
        Alpine.initTree(component);
        component.removeAttribute('defer-x-data');
    });
}

jQuery(document).ready(function () {
    initInputfieldRecurringDates();
});

jQuery(document).on('reloaded', '.InputfieldRepeaterItem', function (event) {
    var inputfield = event.currentTarget;
    initInputfieldRecurringDates(inputfield);
});

document.addEventListener('alpine:init', (e) => {
    Alpine.data('recurringDatesInput', function () {
        return {
            inputfield: '',
            _rrule: null,
            rrule: {
                DTSTART: "",
                FREQ: "DAILY",
                INTERVAL: 1,
                COUNT: 1,
                UNTIL: "",
                BYDAY: [],
                BYMONTH: [],
                BYMONTHDAY: []
            },
            _settings: null,
            settings: null,
            is_filtering: function (filter) {
                if (this.rrule[filter] !== null || this.rrule[filter] !== undefined) {
                    if (this.rrule[filter].length) {
                        return true;
                    }
                }
            },
            show_table: false,
            catalogues: {
                filters: [
                    {label: "Months", value: 'BYMONTH'},
                    {label: "Days of the week", value: 'BYDAY'},
                    {label: "Days of the month", value: 'BYMONTHDAY'},
                ],
                daysOfWeek: [
                    {name: 'Sunday', value: 'SU'},
                    {name: 'Monday', value: 'MO'},
                    {name: 'Tuesday', value: 'TU'},
                    {name: 'Wednesday', value: 'WE'},
                    {name: 'Thursday', value: 'TH'},
                    {name: 'Friday', value: 'FR'},
                    {name: 'Saturday', value: 'SAT'},
                ],
            },

            init: function () {
                this.inputfield = this.$el.dataset.inputfieldName;
                this.$watch('rrule', (prop) => {
                    this.saveString();
                });

                this.$watch('settings', (prop, oldValue) => {
                    this._settings = JSON.stringify(this.settings);
                    var self = this;
                    self.catalogues.filters.forEach(function (filter) {

                        var found = self.settings.filters.find(filter_setting => filter_setting === filter.value);
                        if (found === undefined) {
                            if (self.rrule[filter.value] !== undefined) {
                                self.rrule[filter.value] = [];
                            }
                        }
                    });

                    this.saveString();
                });

                var json_rrule = this.$refs['main-input'].dataset.rrule;
                var widget_settings = this.$refs['main-input'].dataset.settings;

                if (widget_settings) {
                    this.settings = JSON.parse(widget_settings);
                }
                if (json_rrule) {
                    this.rrule = JSON.parse(json_rrule);
                    this._rrule = JSON.stringify(this.rrule);
                } else {
                    //console.log(this.rrule);
                    /*var now = new Date();
                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                    this.rrule.DTSTART = now.toISOString().slice(0, 16);*/
                    this.settings.limit_mode = "count";
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
                var rrule_copy = this.cloneObject(this.rrule);

                if (this.limit_mode === "count") {
                    delete rrule_copy.UNTIL
                }
                if (this.limit_mode === "until") {
                    delete rrule_copy.COUNT
                }
                var json_string = JSON.stringify(rrule_copy);
                if (this.$refs['pre-debug'] !== undefined) {
                    this.$refs['pre-debug'].innerText = JSON.stringify(rrule_copy, null, 2);
                }
                this._rrule = json_string;
            }
        }
    })
});

