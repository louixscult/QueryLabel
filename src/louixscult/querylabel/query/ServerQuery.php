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

namespace louixscult\querylabel\query;

use JsonSerializable;

/**
 * A server query object
 */
class ServerQuery implements JsonSerializable
{

    /** @var string */
    private $gameName;

    /** @var string */
    private $hostName;

    /** @var string */
    private $protocol;

    /** @var string */
    private $version;

    /** @var integer */
    private $playersCount;

    /** @var integer */
    private $maxPlayersCount;

    /** @var string */
    private $serverId;

    /** @var string */
    private $worldName;

    /** @var string */
    private $gameMode;

    /** @var boolean */
    private $nintendoLimited;

    /** @var integer */
    private $ipV4Port;

    /** @var integer */
    private $ipV6Port;

    /** @var string */
    private $serverExtra;

    public function __construct(
        string $gameName,
        string $hostName,
        string $protocol,
        string $version,
        int $playersCount,
        int $maxPlayersCount,
        string $serverId,
        string $worldName,
        string $gameMode,
        int $nintendoLimited,
        int $ipV4Port,
        int $ipV6Port,
        string $serverExtra
    )
    {
        $this->gameName        =               $gameName;
        $this->hostName        =               $hostName;
        $this->protocol        =               $protocol;
        $this->version         =                $version;
        $this->playersCount    =           $playersCount;
        $this->maxPlayersCount =        $maxPlayersCount;
        $this->serverId        =               $serverId;
        $this->worldName       =              $worldName;
        $this->gameMode        =               $gameMode;
        $this->nintendoLimited = (bool) $nintendoLimited;
        $this->ipV4Port        =               $ipV4Port;
        $this->ipV6Port        =               $ipV6Port;
        $this->serverExtra     =            $serverExtra;
    }

    /**
     * Get server game name
     *
     * @return string
     */
    public function getGameName(): string
    {
        return $this->gameName;
    }

    /**
     * Get server host name
     *
     * @return string
     */
    public function getHostName(): string
    {
        return $this->hostName;
    }

    /**
     * Get server MCPE protocol
     *
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * Get server MCPE version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Get players in server count
     *
     * @return int
     */
    public function getPlayersCount(): int
    {
        return $this->playersCount;
    }

    /**
     * Get server max players count
     *
     * @return int
     */
    public function getMaxPlayerCount(): int
    {
        return $this->maxPlayersCount;
    }

    /**
     * Get server id
     *
     * @return string
     */
    public function getServerId(): string
    {
        return $this->serverId;
    }

    /**
     * Get server world name
     *
     * @return string
     */
    public function getWorldName(): string
    {
        return $this->worldName;
    }

    /**
     * Get server game mode
     *
     * @return string
     */
    public function getGameMode(): string
    {
        return $this->gameMode;
    }

    /**
     * Verify if this server is **Nintendo™** limited
     *
     * @return bool
     */
    public function isNintendoLimited(): bool
    {
        return $this->nintendoLimited;
    }

    /**
     * Get IPV4 protocol server port
     *
     * @return int
     */
    public function getIPV4Port(): int
    {
        return $this->ipV4Port;
    }

    /**
     * Get IPV6 protocol server port
     *
     * @return int
     */
    public function getIPVPort(): int
    {
        return $this->ipV6Port;
    }

    /**
     * Get server extra
     *
     * @return string
     */
    public function getServerExtra(): string
    {
        return $this->serverExtra;
    }

    /**
     * Serializable server query
     *
     * @return array{game_name:string,host_name:string,protocol:string,version:string,players_count:integer,max_players_count:integer,server_id:string,world_name:string,game_mode:string,nintendo_limited:int,ports:array{ipv4:string,ipv6:string},server_extra:string}
     */
    public function jsonSerialize(): mixed
    {
        return [
            'game_name' => $this->gameName,
            'host_name' => $this->hostName,
            'protocol'  => $this->protocol,
            'version'   =>  $this->version,
            'players_count' => $this->playersCount,
            'max_players_count' => $this->maxPlayersCount,
            'server_id'=> $this->serverId,
            'world_name' => $this->worldName,
            'game_mode' => $this->gameMode,
            'nintendo_limited'=> (int) $this->nintendoLimited,
            'ports' => [
                'ipv4' => $this->ipV4Port,
                'ipv6' =>  $this->ipV6Port
            ],
            'server_extra' => $this->serverExtra
        ];
    }

}

?>
