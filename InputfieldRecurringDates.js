document.addEventListener('alpine:init', (e) => {
    Alpine.data('recurringDatesInput', () => ({
        open: false,
        freq: 'DAILY',
        byday: [],
        daysOfWeek: [
            {abbreviation: 'SU', value: 'SU'},
            {abbreviation: 'MO', value: 'MO'},
            {abbreviation: 'TU', value: 'TU'},
            {abbreviation: 'WE', value: 'WE'},
            {abbreviation: 'TH', value: 'TH'},
            {abbreviation: 'FR', value: 'FR'},
        ],
        init: function () {
            console.log(this.$el);
        }
    }))
})
