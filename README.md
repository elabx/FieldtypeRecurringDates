This is a pre-release please do not use in production.

# FieldtypeRecurringDates

Fieldtype and Inputfield for definining recurring dates according to [RFC-RFC 5545](https://www.rfc-editor.org/rfc/rfc5545#section-3.3.10) and the awesome library
[php-rrule](https://github.com/rlanvin/php-rrule)

This module will save the RRules occurrences in the database to be queried later. 

# Find pages with fields

Use date values valid for date selectors. 

````
$pages->find('recurring_meetings=>today')
````

# Finding occurrences

You can use the module included in this same package to find the rules occurrences:


```
$finder = $modules->get('ReccurringDatesFinder')
$output = $finder->find(
    $selector, [
        'fields' => [
            // Will find event occurrences in fields specified in this array 
            'recurring_meetings',
            'recurring_events'
        ]
    ]
```

This method will return the SQL UNION result of specified fields.  

You can also hook into getRecurringFieldQueries() to add queries that will get added to the final UNION query.  

# TODO

- [ ] Add support for BYSETPOS
- [ ] Add support for 'Never' option.

# Wishlist

- [ ] Support for plain text RRule. 
- [ ] Add support for BYWEEKNO, BYYEARDAY, BYMONTHDAY, BYMINUTE, BYHOUR, BYMINUTE, BYSECOND .
- [ ] Add support to modify RRule before saving? Maybe skips
- [ ] Use RSet instead of RRule?

