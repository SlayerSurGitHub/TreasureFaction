<?php

declare(strict_types=1);

namespace Treasure\Faction\command\commando\libs\muqsit\simplepackethandler;

use InvalidArgumentException;
use Treasure\Faction\command\commando\libs\muqsit\simplepackethandler\interceptor\IPacketInterceptor;
use Treasure\Faction\command\commando\libs\muqsit\simplepackethandler\interceptor\PacketInterceptor;
use Treasure\Faction\command\commando\libs\muqsit\simplepackethandler\monitor\IPacketMonitor;
use Treasure\Faction\command\commando\libs\muqsit\simplepackethandler\monitor\PacketMonitor;
use pocketmine\event\EventPriority;
use pocketmine\plugin\Plugin;

final class SimplePacketHandler{

	public static function createInterceptor(Plugin $registerer, int $priority = EventPriority::NORMAL, bool $handle_cancelled = false) : IPacketInterceptor{
		if($priority === EventPriority::MONITOR){
			throw new InvalidArgumentException("Cannot intercept packets at MONITOR priority");
		}
		return new PacketInterceptor($registerer, $priority, $handle_cancelled);
	}

	public static function createMonitor(Plugin $registerer, bool $handle_cancelled = false) : IPacketMonitor{
		return new PacketMonitor($registerer, $handle_cancelled);
	}
}