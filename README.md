
<div align='center'>

# QueryLabel
MCPE query library for PHP

</div>

# Introduction

QueryLabel is a library for PocketMine-MP To make a query to an MCPE server using sockets. The library will retrieve the data and transform it into an object, which can then be serialized.

# Instalation

You can use the library in Composer.

Example:

```sh
composer require louixscult/querylabel
```

You can also use it in Poggit plugins.
Example of use in poggit.yml file:

```yaml
---
build-by-default: true
branches:
- yourbranch
projects:
  YourProjectName:
    libs:
      - src: louixscult\querylabel
        version: ^1.0.0
    path: ''
...
```

# Using the library

You can perform a query using the `QueryHandle::query()` method. It works by sending a query, using sockets, thus returning the data from the server, therefore, transforming raw data and returning the object **ServerQuery**

## Example (Using Composer)

```php
require __DIR__ . '/vendor/autoload.php';

use louixscult\querylabel\QueryHandler;

// returns a ServerQuery obj
$queryData = QueryHandler::query(
  'myserver.xyz', // address
  19132, // port
  3 // tries
)->jsonSerialize(); // suport for serialize the obj

var_dump($queryData);
```

The object also has methods related to server data, allowing you to retrieve information from the server more easily.

## Example of a query to retrieve the number of players on the server (Using Composer)

```php
require __DIR__ . '/vendor/autoload.php';

use louixscult\querylabel\QueryHandler;

$query = QueryHandler::query('myserver.xyz', 19132);
$players = $query->getPlayersCount();

echo 'There are ' . $players . ' players in this server';
```
