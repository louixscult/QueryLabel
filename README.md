
<div align='center'>
<h1>QueryLabel</h1>
<h3>MCPE query library for PHP</h3>
</div>

# Introduction

QueryLabel is a library for PocketMine-MP To make a query to an MCPE server using sockets. The library will retrieve the data and transform it into an object, which can then be serialized.

# How to use

You can perform a query using the `QueryHandle::query()` method. When used, will be returns a **ServerQuery** object

## Example:

```

use louixscult\querylabel\QueryHandler;

$query = QueryHandler::query('youserver.xyz', 19132, 5) // the timeout argument is a optional
$data = $query->jsonSerialize();

echo(print_f($data));

```
