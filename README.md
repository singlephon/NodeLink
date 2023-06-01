# CommonSource: NodeLink

[![Latest Version on Packagist](https://img.shields.io/packagist/v/singlephon/nodelink.svg?style=flat-square)](https://packagist.org/packages/singlephon/nodelink)
[![Total Downloads](https://img.shields.io/packagist/dt/singlephon/nodelink.svg?style=flat-square)](https://packagist.org/packages/singlephon/nodelink)
![GitHub Actions](https://github.com/singlephon/nodelink/actions/workflows/main.yml/badge.svg)

This project is a Laravel-based microservices architecture designed to allow easy communication between multiple applications through a centralized parent application. The parent application acts as a hub for communication between the child applications, allowing for efficient and streamlined data sharing across multiple services.

This architecture allows for easy scaling and maintenance of individual services without affecting the entire system. With the use of Serviceable and Syncable classes, this system can synchronize data across different applications, ensuring that all services remain up to date with the latest information.

Developers can easily extend this architecture by adding new services, implementing Serviceable and Syncable classes, and defining routes to handle data synchronization. Overall, this project provides an efficient and scalable solution for building microservices-based applications.

## Installation

1. Install **NodeLink** to Laravel project

```php
composer require singlephon/nodelink
```

2. Add configuration parameters to **.env**

```php
CORELINK_SERVICE_URL=

NODELINK_SERVICE_APP_NAME=
NODELINK_SERVICE_APP_KEY=
NODELINK_SERVICE_APP_VERSION=1.1
NODELINK_SERVICE_APP_TEST_VERSION=1.2
```

3. [Register this application to **CoreLink** service](https://github.com/bcorpj/CoreLink/blob/master/README.md)

...coming soon


### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


### Security

If you discover any security related issues, please email singlephon@gmail.com instead of using the issue tracker.

## Credits

-   [Rakhat Bakytzhanov](https://github.com/singlephon)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

