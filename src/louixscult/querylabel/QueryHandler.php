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

use louisxcult\querylabel\exception\QueryException;
use louixscult\querylabel\query\ServerQuery;
use ReflectionClass;

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
        string $port,
        int $timeout = 5
    )
    {
        $socket = @fsockopen('udp://' . $host, $port, $errno, $errstr, $timeout);

		if ($errno !== 0 and !$socket)
        {
			fclose($socket);
			throw new QueryException($errstr, $errno);
		} else if (!$socket)
        {
			throw new QueryException($errstr, $errno);
		}

		stream_set_timeout($socket, $timeout);
		stream_set_blocking($socket, true);

        $OFFLINE_MESSAGE_DATA_ID = pack('c*', ...self::OFFLINE_DATA);
		$command = pack('cQ', 0x01, time());
		$command .= $OFFLINE_MESSAGE_DATA_ID;
		$command .= pack('Q', 2);
		$length = strlen($command);

		if ($length !== fwrite($socket, $command, $length))
        {
			throw new QueryException("Failed to write on socket.", E_WARNING);
		}

		stream_set_blocking($socket, false);
		$read = [$socket];
		$write = $except = [];

		$result = stream_select($read, $write, $except, $timeout);

		if (!$result)
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

		if (substr($data, 17, 16) !== $OFFLINE_MESSAGE_DATA_ID)
        {
			throw new QueryException("Magic bytes do not match.");
		}

		$data = substr($data, 35);
		$data = explode(';', $data);

        $reflection = new ReflectionClass(ServerQuery::class);
        $constructor = $reflection->getConstructor();

        if (count($data) > $constructor->getNumberOfParameters() or count($data) < $constructor->getNumberOfParameters())
        {
            throw new QueryException("The query data is greater or less than the class values.");
        }

        return new ServerQuery(...$data);
    }

}

?>
