<?php
 namespace Mgt\Varnish\Model\ResourceModel; class UrlQueue extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb { protected function _construct() { $this->_init("\155\x67\x74\137\x76\141\162\156\x69\163\x68\x5f\x75\x72\154\x5f\161\165\145\165\x65", "\x75\x72\154\137\151\144"); } public function addToQueue(array $urls) { goto Bbf20; Bbf20: $table = $this->getTable("\155\147\164\137\166\x61\x72\x6e\x69\x73\x68\137\x75\162\x6c\137\161\165\x65\165\145"); goto A8dcb; d178f: $connection->insertOnDuplicate($table, $urls, $fields); goto B99b5; B752b: $connection = $this->getConnection(); goto d178f; A8dcb: $fields = ["\163\x74\x6f\x72\x65\137\x69\x64", "\x70\141\164\x68", "\160\162\x69\x6f\162\151\x74\171"]; goto B752b; B99b5: } public function deleteFromQueue(array $urlIds) { goto C2460; bd95c: $connection = $this->getConnection(); goto c6b70; C2460: $table = $this->getTable("\155\x67\x74\137\x76\141\x72\156\x69\163\x68\137\x75\x72\x6c\137\x71\165\x65\x75\x65"); goto bd95c; c6b70: $connection->delete($table, ["\x75\x72\x6c\137\151\144\x20\x49\116\50\77\51" => $urlIds]); goto E0aea; E0aea: } public function flushAll() { goto Eed02; Eed02: $table = $this->getTable("\x6d\147\164\x5f\x76\141\x72\156\151\163\150\137\x75\162\154\137\161\x75\145\165\145"); goto e8908; Bfeeb: $connection->delete($table, []); goto f5d73; e8908: $connection = $this->getConnection(); goto Bfeeb; f5d73: } }