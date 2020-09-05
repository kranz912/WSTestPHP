<?php
namespace MyApp;


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Socket implements MessageComponentInterface
{
    public function __construct()
    {
      $this->clients = new \SplObjectStorage;
    }

    /**
    * Attaching connectionID to list of clients
    * @param ConnectionInterface
    */
    public function onOpen(ConnectionInterface $conn)
    {
      $this->clients->attach($conn);

      echo "New Connection! ({$conn->resourceID})\n";

    }
    /**
    * Event handler for onMessage
    * @param ConnectionInterface
    * @param string
    */
    public function onMessage(ConnectionInterface $from, $msg)
    {
      foreach ($this->clients as $client) {
        if($from->resourceId == $client->resourceId){
          continue;
        }
        $client->send("Client $from->resourceID said $msg");
      }
    }

    public function onClose(ConnectionInterface $conn)
    {

    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {

    }
}
