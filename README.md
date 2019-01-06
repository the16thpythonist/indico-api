# Indico Events API

## CHANGELOG

### 0.0.0.0 - 10.07.2018

- Initial commit

### 0.0.0.1 - 16.07.2018

- Fixed the bug with the DateTime creation in the EventArgumentAdapter not working due to a false format string

### 0.0.0.2 - 08.08.2018

- Fixed a bug with the 'modificationDate' key sometimes not existing in the raw data returned from indico.
In such a case the creation time is used as the modification time as well.
- Fixed a bug with the time formats returned by indico **sometimes** containing the milliseconds as well, which 
would lead to the DateTime creation not working.
- Wrote a test to ensure that the modification time is created correctly

### 0.0.0.3 - 06.01.2019

- Fixed a bug, that would cause an issue, when the server would response with a value explicitly set to NULL even though 
the methods have to return strings. All NULL values are now converted to empty strings by the adapter.