# M2M to SMS

## Introduction

**M2M to SMS** is a website platform written in [PHP][php] that facilitates the transit of [Machine-to-Machine][m2m] device messages, formatted as [Short Message Service][sms] messages, over the [Simple Object Access Protocol][soap] via the [EE M2M Connect Service][m2mconnect].

Messages sent over the network are designed to encapsulate data regarding a typical [telematics][telematics] board, including:

* Switch states
* Fan state
* Keypad state
* Device temperature

The platform has been developed using the [Model–view–controller][mvc] pattern.

## Configuration

The [config.php][config] file is used to configure the system. Required information includes:

* EE M2M Connect Service configuration details
* Database configuration details and credentials
* WSDL file location

The database structure can be created with the use of the [circuitboard_db.sql][sql] file.

## Dependencies

The following third-party libraries are used by the platform:

* [Smarty: PHP Template Engine][smarty]
* [SimpleTest - Unit Testing for PHP][simpletest]
* [Google Charts][charts]

## Credits

### Contributors

* [Michael Bull][mikebull94]
* [Graham Edgecombe][grahamedgecombe] - Provided [site theme][css], redistribution/modification of which is prohibited.
* [Michael Buckley][michaelbuckley] - Author of the [Pastel SVG Icon set][pastelsvg], used in the navigation bar ([LICENSE][pastelsvglicense]).

## Screenshots

![Home][home]

![View Statuses][view_statuses]

[home]: /img/home.png
[view_statuses]: /img/view_statuses.png

[php]: http://php.net/
[m2m]: http://en.wikipedia.org/wiki/Machine_to_machine
[sms]: http://en.wikipedia.org/wiki/Short_Message_Service
[soap]: http://en.wikipedia.org/wiki/SOAP
[m2mconnect]: https://m2mconnect.ee.co.uk/
[telematics]: http://en.wikipedia.org/wiki/Telematics
[mvc]: http://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller
[smarty]: http://www.smarty.net/
[simpletest]: http://www.simpletest.org/
[charts]: https://developers.google.com/chart/
[mikebull94]: https://github.com/MikeBull94
[grahamedgecombe]: https://github.com/GrahamEdgecombe
[michaelbuckley]: https://codefisher.org/about/
[pastelsvg]: https://codefisher.org/pastel-svg/
[pastelsvglicense]: http://creativecommons.org/licenses/by-nc-sa/4.0/
[css]: /public_php/css/stylesheet.css
[config]: /includes/application/config.php
[sql]: /includes/application/circuitboard_db.sql
