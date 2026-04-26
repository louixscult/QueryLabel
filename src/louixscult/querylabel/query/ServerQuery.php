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

	private string $gameName;
    private string $hostName;
    private int $protocol;
    private string $version;
    private int $playersCount;
    private int $maxPlayersCount;
    private int $serverId;
    private string $worldName;
    private string $gameMode;
    private bool $nintendoLimited;
    private int $ipV4Port;
    private int $ipV6Port;
    private bool $isHardcore;
    private string $serverExtra;

    public function __construct(
        string $gameName,
        string $hostName,
        string $protocol,
        string $version,
        string $playersCount,
        string $maxPlayersCount,
        string $serverId,
        string $worldName,
        string $gameMode,
        string $nintendoLimited,
        string $ipV4Port,
        string $ipV6Port,
        string $isHardcore,
        string $serverExtra
    )
    {
        $this->gameName        =                       $gameName;
        $this->hostName        =                       $hostName;
        $this->protocol        = (int)                 $protocol;
        $this->version         =                        $version;
        $this->playersCount    = (int)             $playersCount;
        $this->maxPlayersCount = (int)          $maxPlayersCount;
        $this->serverId        = (int)                 $serverId;
        $this->worldName       =                      $worldName;
        $this->gameMode        =                       $gameMode;
        $this->nintendoLimited = (bool) ((int) $nintendoLimited);
        $this->ipV4Port        = (int)                 $ipV4Port;
        $this->ipV6Port        = (int)                 $ipV6Port;
        $this->isHardcore      = (bool)      ((int) $isHardcore);
        $this->serverExtra     =                    $serverExtra;
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
     * @return integer
     */
    public function getProtocol(): int
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
     * @return int
     */
    public function getServerId(): int
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
    public function getIPV6Port(): int
    {
        return $this->ipV6Port;
    }

    /**
     * Verify if is hardcore
     *
     * @return bool
     */
    public function isHardcore(): bool
    {
    	return $this->isHardcore;
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
     * @return array{game_name:string,host_name:string,protocol:string,version:string,players_count:integer,max_players_count:integer,server_id:string,world_name:string,game_mode:string,nintendo_limited:int,ports:array{ipv4:string,ipv6:string},isHardcore:bool,server_extra:string}
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
            'nintendo_limited'=> $this->nintendoLimited,
            'ports' => [
                'ipv4' => $this->ipV4Port,
                'ipv6' =>  $this->ipV6Port
            ],
            'isHardcore' => $this->isHardcore,
            'server_extra' => $this->serverExtra
        ];
    }

}

?>
