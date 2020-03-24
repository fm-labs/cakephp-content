# Content Plugin for CakePHP 

## Installation

 composer require fm-labs/cakephp-content
 
## Usage

```php
 
 // In your src/Application.php
 
 function bootstrap() {
    parent::bootstrap();
    $this->addPlugin('Content');
 }

```


## Internals

### Bootstrap

Registers content types to ContentManager

### Routes

* PageRoutes
* PostRoutes
* Root-Scope-Routes

