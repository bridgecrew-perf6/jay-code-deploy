<?php
 namespace Mgt\Varnish\Model\Observer; use Magento\Framework\Event\ObserverInterface; class InvalidateObserver implements ObserverInterface { protected $config; protected $purgeCache; public function __construct(\Magento\PageCache\Model\Config $config, \Magento\CacheInvalidate\Model\PurgeCache $purgeCache) { $this->config = $config; $this->purgeCache = $purgeCache; } public function execute(\Magento\Framework\Event\Observer $observer) { goto e1755; e5df2: cdd06: goto Af5c4; def95: if (!count($tags)) { goto cdd06; } goto d4693; a5f02: if (!($cacheType == \Magento\PageCache\Model\Config::VARNISH && true === $isFpcEnabled)) { goto efde0; } goto cbd7e; Bc995: $isFpcEnabled = $this->config->isEnabled(); goto a5f02; aee2b: $tags = $object->getIdentities(); goto def95; E4160: if (!$object instanceof \Magento\Framework\DataObject\IdentityInterface) { goto a50c1; } goto aee2b; cbd7e: $object = $observer->getEvent()->getObject(); goto E4160; e1755: $cacheType = $this->config->getType(); goto Bc995; Af5c4: a50c1: goto C3599; d4693: $this->purgeCache->sendPurgeRequest($tags); goto e5df2; C3599: efde0: goto ca141; ca141: } }
