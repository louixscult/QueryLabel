<?php

declare (strict_types=1);

/**
 *
 * '||`                                                  '||`   ||
 *  ||                   ''                               ||    ||
 *  ||  .|''|, '||  ||`  ||  \\  // ('''' .|'', '||  ||`  ||  ''||''
 *  ||  ||  ||  ||  ||   ||    ><    `'') ||     ||  ||   ||    ||
 * .||. `|..|'  `|..'|. .||. //  \\ `...' `|..'  `|..'|. .||.   `|..'
 *
 * This library has cretaed by louixscult
 *
 * Copyright louixscult (Luiz Guilherme), all rights reserved
 *
 * @link linktr.ee/louixscult
 *
 */

namespace louixscult\querylabel;

use louixscult\querylabel\exception\QueryException;
use louixscult\querylabel\query\ServerQuery;
use ReflectionClass;
use function explode;
use function fclose;
use function fread;
use function fsockopen;
use function fwrite;
use function pack;
use function str_starts_with;
use function stream_set_blocking;
use function stream_set_timeout;
use function strlen;
use function substr;
use function time;

/**
 * Manage queries with handler
 */
final class QueryHandler
{

    const OFFLINE_DATA = [0x00, 0xFF, 0xFF, 0x00, 0xFE, 0xFE, 0xFE, 0xFE, 0xFD, 0xFD, 0xFD, 0xFD, 0x12, 0x34, 0x56, 0x78];

    /**
     * Query server infos (function getted in https://github.com/jasonw4331/libpmquery)
     *
     * @param string     $host
     * @param integer    $port
     * @param integer $timeout
     *
     * @return ServerQuery
     *
     * @author jasonw4331 <https://github.com/jasonw4331>
     */
    public static function query(
        string $host,
        int $port,
        int $timeout = 5
    ) {
    	$socket = @fsockopen('udp://' . $host, (int)$port, $errno, $errstr, $timeout);

		if (!$socket)
		{
		    throw new QueryException($errstr, $errno);
		}
		
		stream_set_timeout($socket, $timeout);
		
		$offline = pack('c*', ...self::OFFLINE_DATA);
		$time = (int)(microtime(true) * 1000);
		$guid = random_int(1, PHP_INT_MAX);
		
		$command = pack('cQ', 0x01, $time);
		$command .= $offline;
		$command .= pack('Q', $guid);
		
		fwrite($socket, $command);
		
		$read = [$socket];
		$write = $except = [];
		
		$result = stream_select($read, $write, $except, $timeout, 0);

		var_dump($result);

		if ($result === false)
        {
			throw new QueryException("select() call failed", E_WARNING);
		}

		if ($result === 0)
        {
			throw new QueryException("select() timed out", E_WARNING);
		}

		assert(in_array($socket, $read, true));

		$data = fread($socket, 4096);
		fclose($socket);

		if ($data === false || $data === '')
        {
			throw new QueryException("Server failed to respond", E_WARNING);
		}

		if (!str_starts_with($data, "\x1C"))
        {
			throw new QueryException("First byte is not ID_UNCONNECTED_PONG.", E_WARNING);
		}
		if (substr($data, 17, 16) !== $offline)
        {
			throw new QueryException("Magic bytes do not match.");
		}

		$data = substr($data, 35);
		$data = explode(';', $data);

        $reflection = new ReflectionClass(ServerQuery::class);
        $constructor = $reflection->getConstructor();
        $params = $constructor->getNumberOfParameters();

        if (count($data) !== $params)
        {
            throw new QueryException("The query data is greater or less than the class values.");
        }

        return new ServerQuery(...$data);
    }

}

?>
