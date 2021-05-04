<?php

declare(strict_types=1);

namespace app\listener\websocket;

use Swoole\Server;
use app\table\Fd as FdTable;
use app\table\Throttle as ThrottleTable;
use app\table\User as UserTable;
use think\swoole\Websocket;

/**
 * Socket事件处理程序
 */
abstract class SocketEventHandler
{
    /** Server */
    protected $server;
    /** WebSocket */
    protected $websocket;
    /** 当前用户的FD */
    protected $fd;

    protected $userTable;
    protected $fdTable;
    protected $throttleTable;

    public function __construct(
        Websocket $websocket,
        Server $server,
        UserTable $userTable,
        FdTable $fdTable,
        ThrottleTable $throttleTable
    ) {
        $this->server        = $server;
        $this->websocket     = $websocket;
        $this->fd            = $websocket->getSender();
        $this->userTable     = $userTable;
        $this->fdTable       = $fdTable;
        $this->throttleTable = $throttleTable;
    }

    /**
     * 获取当前user
     *
     * @return array|false
     */
    public function getUser()
    {
        return $this->userTable->get($this->fd);
    }
}
