<?php
 namespace Mgt\Varnish\Model\ResourceModel\UrlRewrite; class UrlRewriteCollection extends \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollection { public function addStoreFilter($store, $withAdmin = true) { goto ea83b; d179a: if (!$withAdmin) { goto A40fd; } goto e7759; b6719: return $this; goto f1833; e7759: $store[] = 0; goto ca11b; b2153: $this->addFieldToFilter("\x6d\x61\x69\156\137\164\x61\x62\x6c\x65\x2e\163\x74\x6f\x72\x65\137\151\144", ["\151\156" => $store]); goto b6719; ea83b: if (is_array($store)) { goto b215e; } goto D32a8; Bbfb6: b215e: goto d179a; ca11b: A40fd: goto b2153; D32a8: $store = [$this->storeManager->getStore($store)->getId()]; goto Bbfb6; f1833: } public function addEntityTypeFilter($entityType) { $this->addFieldToFilter("\x6d\x61\151\x6e\137\164\141\142\x6c\x65\x2e\x65\x6e\x74\151\x74\171\x5f\164\x79\x70\145", $entityType); return $this; } public function addEntityIdFilter(array $entities) { $this->addFieldToFilter("\x6d\141\151\x6e\x5f\164\141\x62\x6c\x65\56\x65\x6e\164\x69\164\171\137\151\x64", ["\x69\x6e" => $entities]); return $this; } }