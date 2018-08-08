# Indico Events API

## CHANGELOG

### 0.0.0.0 - 10.07.2018

- Initial commit

### 0.0.0.1 - 16.07.2018

- Fixed the bug with the DateTime creation in the EventArgumentAdapter not working due to a false format string

### 0.0.0.2 - 08.08.2018

- Fixed a bug with the 'modificationDate' key sometimes not existing in the raw data returned from indico.
In such a case the creation time is used as the modification time as well.