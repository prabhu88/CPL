# CPL
Custom PHP Logger: Logging Your App's Activity for Better Performance and Error Tracking


## Usage
Example.
```php
<?php
require_once 'src/Logger.php';

....
use Cpl\Logger;
if (class_exists('Cpl\Logger')) {
    $cpl = new Logger();
    
    // Want to use custom path to store log files
    $cpl = new Logger($path);
}


....
$cpl->log('Title',"Description","info");
$cpl->log('Title',"Description","warning");

```
