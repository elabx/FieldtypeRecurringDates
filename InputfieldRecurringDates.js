document.addEventListener('alpine:init', (e) => {
    Alpine.data('recurringDatesInput', function(){
        return {
            _rrule: null,
            rrule: {
                DTSTART: "",
                FREQ: "DAILY",
                COUNT: 1,
                UNTIL: "",
                BYDAY: [],
                BYMONTH: [],
                BYWEEKNO: []
            },
            filterby: [],
            is_filtering: function(filter){
                if(this.rrule[filter] !== null || this.rrule[filter] !== undefined) {
                    if (this.rrule[filter].length) {
                        return true;
                    }
                }
            },
            limit_mode: "",
            catalogues: {
                byDay: [
                    { text: "By month" , value:'BYMONTH' },
                    { text: "By day" , value:'BYDAY' }
                ],
                daysOfWeek: [
                    {abbreviation: 'Sunday', value: 'SU'},
                    {abbreviation: 'Monday', value: 'MO'},
                    {abbreviation: 'Tuesday', value: 'TU'},
                    {abbreviation: 'Wednesday', value: 'WE'},
                    {abbreviation: 'Thursday', value: 'TH'},
                    {abbreviation: 'Friday', value: 'FR'},
                    {abbreviation: 'Saturday', value: 'FR'},
                ],
            },
            parseRule: function(){
                //console.log('parse rule!');
            },

            init: function () {
                this.$watch('rrule', (prop) => {
                    this.saveString();
                });
                this.$watch('limit_mode', (prop) => {
                    if(prop === "count"){
                        if(this.rrule.COUNT === null){
                            this.rrule.COUNT = 1;
                        }
                    }
                    this.saveString();
                });
                var dtstart_input = this.$refs['dtstart-datetime-input'];
                var rrule =  JSON.parse(this.$refs['main-input'].dataset.jsonRrule);
                if(rrule.COUNT !== null && Number.isInteger(Number.parseInt(rrule.COUNT))){
                    this.limit_mode = "count";
                }
                if(rrule.UNTIL !== null){
                    this.limit_mode = "until";
                }
                this.rrule = rrule;
                // var dayjs_date = dayjs(rrule.DTSTART);
                // this.rrule.DTSTART = dayjs_date.format('YYYY-MM-DDTHH:mm');

                this._rrule = JSON.stringify(this.rrule);
            },
            cloneObject: function(obj) {
                // basic type deep copy
                if (obj === null || obj === undefined || typeof obj !== 'object')  {
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
            saveString: function(){
                var rrule_copy = this.cloneObject(this.rrule);

                if(this.limit_mode === "count"){
                    delete rrule_copy.UNTIL
                }
                if(this.limit_mode === "until"){
                    delete rrule_copy.COUNT
                }
                var json_string = JSON.stringify(rrule_copy);
                if(this.$refs['pre-debug'] !== undefined) {
                    this.$refs['pre-debug'].innerText = JSON.stringify(rrule_copy, null, 2);
                }
                this._rrule = json_string;
            }
        }
    })
})
