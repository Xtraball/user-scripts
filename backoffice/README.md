# Backoffice scripts

## Batch delete for Applications

*./batch-delete-apps.php*

### requirements

- PHP CLI 5.6+
- CURL

#### Example

```bash
prompt $ ./batch-delete-apps.php 
Backoffice user e-mail: demo-backoffice@demo.com
Backoffice user password: demopassword
App ids (coma separated): 1,3,6,8
You are about to definitively delete all the Applications listed below, are you sure? (Y/n): Y
The Application 1 / Awesome has been deleted!
The Application 3 / Facebook Import has been deleted!
The Application 6 / Super app has been deleted!
This Application 8 doesn't exists, aborting!
```
