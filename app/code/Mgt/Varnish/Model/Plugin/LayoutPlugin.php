<?php
 namespace Mgt\Varnish\Model\Plugin; class LayoutPlugin { const ADMIN_AREA_CODE = "\141\x64\x6d\151\156\150\164\x6d\154"; protected $request; protected $storeConfig; protected $varnishConfig; protected $response; protected $license; protected $logger; protected $cacheLifetime; protected $state; public function __construct() { goto Dbb6c; Eb22f: $this->request = $objectManager->get("\134\115\141\x67\x65\156\x74\157\x5c\106\162\141\x6d\145\167\x6f\162\153\134\x41\160\x70\134\x52\x65\161\x75\145\163\x74\x5c\110\x74\x74\x70"); goto ffd1f; F5a02: $this->logger = $objectManager->get("\134\120\163\x72\x5c\x4c\157\147\134\114\157\x67\x67\x65\x72\x49\156\x74\x65\162\x66\x61\x63\x65"); goto c5f95; d2ae0: $this->varnishConfig = $objectManager->get("\134\x4d\x67\x74\x5c\126\x61\162\156\151\x73\x68\x5c\115\157\144\x65\154\x5c\x43\x61\x63\150\145\134\103\x6f\x6e\x66\x69\147"); goto a8c82; ffd1f: $this->response = $objectManager->get("\x5c\x4d\141\147\145\x6e\164\x6f\x5c\x46\162\x61\x6d\145\x77\x6f\x72\x6b\134\x41\x70\160\134\x52\x65\163\160\157\x6e\163\145\111\156\164\145\162\146\x61\x63\x65"); goto Ba33c; a8c82: $this->license = $objectManager->get("\x5c\115\x67\164\134\x56\x61\x72\x6e\x69\x73\x68\x5c\x4d\x6f\x64\145\x6c\134\114\x69\143\x65\x6e\x73\x65"); goto Fdcb1; Fdcb1: $this->state = $objectManager->get("\x5c\115\141\147\145\156\164\x6f\134\106\162\x61\x6d\145\167\157\162\153\x5c\x41\x70\160\134\123\164\x61\164\x65"); goto F5a02; Ba33c: $this->storeConfig = $objectManager->get("\x5c\x4d\x61\x67\145\156\164\157\134\x50\141\147\x65\x43\x61\x63\150\x65\x5c\x4d\x6f\144\145\x6c\134\103\x6f\156\x66\151\147"); goto d2ae0; Dbb6c: $objectManager = $this->getObjectManager(); goto Eb22f; c5f95: } public function afterGetOutput(\Magento\Framework\View\Layout $subject, $result) { goto D7b07; C162d: $this->response->setNoCacheHeaders(); goto De85d; f8640: $this->saveUrlInformation($tags); goto B8146; be66d: if (true === $isCacheable) { goto b2320; } goto C162d; D036c: b2320: goto e112d; a202a: b72f2: goto aa4d3; dc35a: foreach ($subject->getAllBlocks() as $block) { goto B1470; c5896: Af7b4: goto d7d91; B1470: if (!$block instanceof \Magento\Framework\DataObject\IdentityInterface) { goto fff32; } goto Fd1bd; F38a5: fff32: goto B8b17; A5183: $isVarnish = $this->storeConfig->getType() == \Magento\PageCache\Model\Config::VARNISH; goto F84b9; F84b9: if (!($isVarnish && $isEsiBlock)) { goto Af7b4; } goto E52a3; d7d91: $tags = array_merge($tags, $block->getIdentities()); goto F38a5; Fd1bd: $isEsiBlock = $block->getTtl() > 0; goto A5183; E52a3: goto cc09a; goto c5896; B8b17: cc09a: goto B7389; B7389: } goto a202a; aa4d3: $tags = array_unique($tags); goto De946; De946: $this->setResponseHeaders($tags); goto f8640; e37db: return $result; goto b1e8e; De85d: $this->response->setHeader("\130\x2d\103\141\x63\x68\x65\x2d\x4c\151\146\145\x74\151\x6d\x65", 0); goto e9013; B8146: D4cf1: goto e37db; e9013: goto D4cf1; goto D036c; e112d: $tags = []; goto dc35a; D7b07: $isCacheable = $this->isCacheable($subject); goto be66d; b1e8e: } protected function isCacheable(\Magento\Framework\View\Layout $subject) { goto e914f; e5df6: d2290: goto bddbc; c1b24: $isAdminStore = $this->isAdminStore(); goto D95c3; B4861: fe64f: goto Ea95d; c5919: $excludedRoutes = $this->varnishConfig->getExcludedRoutes(); goto da2c6; bddbc: $isMgt = isset($_SERVER["\x4d\107\124"]) && $_SERVER["\115\x47\124"] == "\61" ? true : false; goto B0c3c; a563a: $excludedUrls = $this->varnishConfig->getExcludedUrls(); goto de136; D2a09: return false; goto f8357; da2c6: foreach ($excludedRoutes as $route) { goto e1a43; f1aa3: if (!(!empty($route) && strpos($fullActionName, $route) === 0)) { goto d8f3c; } goto c1453; c1453: return false; goto b1666; e1a43: $route = trim($route); goto f1aa3; e5a1c: D36f5: goto A48d1; b1666: d8f3c: goto e5a1c; A48d1: } goto B4861; e326e: ec170: goto E5a3e; de136: foreach ($excludedUrls as $excludedUrl) { goto C2db3; Dc392: fd99f: goto C6b73; bea6e: b2c94: goto Dc392; C2db3: $excludedUrl = trim($excludedUrl); goto a7841; a7841: if (!($excludedUrl && true === in_array($excludedUrl, [$requestStringWithoutSlash, $requestStringWithSlash]))) { goto b2c94; } goto d4037; d4037: return false; goto bea6e; C6b73: } goto e326e; Da31f: if (!(false === $isFullPageCacheEnabled || false === $isVarnishEnabled)) { goto Fa3bf; } goto C2c55; f7f73: $isVarnishEnabled = $this->varnishConfig->isEnabled(); goto Da31f; f8357: F6e52: goto D5b55; D5b55: $currentHost = isset($_SERVER["\110\x54\124\120\137\x48\117\x53\x54"]) ? $_SERVER["\110\124\x54\x50\137\110\117\123\x54"] : ''; goto Cb1c1; Ea95d: return true; goto f6aa0; B0c3c: if (!(false === $isMgt)) { goto F6e52; } goto D2a09; E5a3e: $fullActionName = $this->request->getFullActionName(); goto c5919; Cb1c1: $hasLicense = $this->license->hasLicense($currentHost); goto C9f75; e914f: $isFullPageCacheEnabled = $this->storeConfig->isEnabled(); goto f7f73; C9f75: if (!(false === $hasLicense)) { goto c1b9a; } goto Fc093; C2c55: return false; goto E21cc; C9951: return false; goto e5df6; fe8d8: foreach ($excludedParams as $param) { goto B337f; d3412: return false; goto a6881; B337f: if (!$this->request->getParam(trim($param))) { goto f024e; } goto d3412; a6881: f024e: goto ce247; ce247: B35bf: goto Aa7cd; Aa7cd: } goto Ba000; Ba000: Ebcfc: goto D742a; c8282: $excludedParams = $this->varnishConfig->getExcludedParams(); goto fe8d8; D95c3: if (!(true === $isAdminStore)) { goto d2290; } goto C9951; C38c6: $requestStringWithSlash = sprintf("\x25\x73\57", $requestStringWithoutSlash); goto a563a; D742a: $requestString = ltrim($this->request->getRequestString(), "\x2f"); goto B7c7e; Fc093: return false; goto f503e; B7c7e: $requestStringWithoutSlash = rtrim($requestString, "\x2f"); goto C38c6; E21cc: Fa3bf: goto c1b24; f503e: c1b9a: goto c8282; f6aa0: } public function setResponseHeaders(array $tags) { goto A5a6c; ff629: F515d: goto a9cb6; a9cb6: if (!(true === $isDebugModeEnabled)) { goto f84e1; } goto ef03a; B6077: $this->response->setHeader("\130\x2d\x4d\141\147\x65\156\164\x6f\55\x54\141\x67\163", implode("\54", $tags)); goto e9918; Cc693: f84e1: goto B6077; df648: $routesCacheLifetime = $this->varnishConfig->getRoutesCacheLifetime(); goto Dcd1b; e9918: $this->response->setPublicHeaders($this->cacheLifetime); goto f8271; A1c40: $fullActionName = $this->request->getFullActionName(); goto df648; d2832: $isDebugModeEnabled = $this->varnishConfig->isDebugModeEnabled(); goto A1c40; A5a6c: $this->cacheLifetime = $this->varnishConfig->getDefaultCacheLifetime(); goto d2832; dfb66: foreach ($routesCacheLifetime as $routeConfig) { goto F60cd; b99d1: goto F7876; goto Ec759; D9e00: b0466: goto a8cfa; E59d6: $routeCacheLifetime = isset($routeConfig["\x66\151\145\154\144\x32"]) ? $routeConfig["\x66\151\145\x6c\144\x32"] : ''; goto cc2f4; cc2f4: if (!($route && $fullActionName == $route)) { goto F38f5; } goto E586a; E586a: $this->cacheLifetime = $routeCacheLifetime; goto b99d1; F60cd: $route = isset($routeConfig["\x66\151\x65\154\x64\61"]) ? trim($routeConfig["\146\x69\145\154\x64\61"]) : ''; goto E59d6; Ec759: F38f5: goto D9e00; a8cfa: } goto c6ee0; ef03a: $this->response->setHeader("\x58\55\103\x61\143\150\145\55\104\x65\x62\165\147", 1); goto d647d; d647d: $this->response->setHeader("\130\55\115\141\147\145\156\x74\x6f\x2d\122\157\x75\164\145", $fullActionName); goto Cc693; c6ee0: F7876: goto ff629; f8271: $this->response->setHeader("\130\x2d\x43\141\x63\x68\145\55\x4c\151\146\145\x74\151\x6d\145", $this->cacheLifetime); goto dac29; Dcd1b: if (!($routesCacheLifetime && count($routesCacheLifetime))) { goto F515d; } goto dfb66; dac29: } protected function saveUrlInformation(array $tags) { goto f4707; f4707: $canSaveUrlInformation = $this->canSaveUrlInformation(); goto Cd6c8; Cd6c8: if (!(true === $canSaveUrlInformation)) { goto bd9c5; } goto cb9fd; cb9fd: try { goto a998a; ce10b: $url->save(); goto cf094; e5046: $cacheExpiredAt->add(new \DateInterval(sprintf("\120\124\x25\163\x53", $this->cacheLifetime))); goto b4366; fc0b2: $storeId = $store->getStoreId(); goto E8967; E8967: $storeBaseUri = new \Zend\Uri\Uri($store->getBaseUrl()); goto Dee54; f73d2: $path = "\x2f" . substr($path, strlen($storeBaseUri->getPath())); goto Febb2; ea43e: $url->setCacheExpiredAt($cacheExpiredAt); goto ce10b; Bd0f9: if (!($storeBaseUri->getPath() != "\x2f")) { goto a973d; } goto f73d2; Dc0ae: $store = $storeManager->getStore(); goto fc0b2; accda: F7f20: goto D0ad8; a998a: $objectManager = $this->getObjectManager(); goto Aeeec; da35b: $url->setStoreId($storeId); goto E1a11; f699f: $url->setCacheLifetime($this->cacheLifetime); goto ea43e; Dee54: $path = $this->request->getRequestUri(); goto Bd0f9; Febb2: a973d: goto d26dd; bd97a: $url->delete(); goto F47e4; E0af3: $url->loadByStoreIdAndPath($storeId, $path); goto Cb33b; F47e4: $url = $objectManager->create("\x4d\x67\x74\134\126\141\162\156\x69\x73\150\134\115\x6f\144\145\154\134\x55\162\x6c"); goto accda; d26dd: $url = $objectManager->create("\x4d\147\x74\134\126\x61\x72\x6e\x69\x73\150\x5c\x4d\157\144\x65\x6c\x5c\125\162\x6c"); goto E0af3; Aeeec: $storeManager = $objectManager->get("\134\x4d\141\x67\x65\x6e\164\x6f\134\x53\164\157\162\x65\134\x4d\157\x64\x65\154\134\123\164\157\162\145\x4d\141\x6e\x61\147\x65\162\111\156\x74\145\162\146\141\143\145"); goto Dc0ae; b4366: $cacheExpiredAt = $cacheExpiredAt->format("\131\x2d\155\55\x64\40\110\72\151\x3a\163"); goto da35b; Cb33b: if (!$url->getId()) { goto F7f20; } goto bd97a; E124b: $url->setTags($tags); goto f699f; E1a11: $url->setPath($path); goto E124b; D0ad8: $cacheExpiredAt = new \DateTime("\x6e\x6f\x77", new \DateTimeZone("\125\124\x43")); goto e5046; cf094: } catch (\Exception $e) { $this->logger->critical($e); } goto da79c; da79c: bd9c5: goto db41d; db41d: } protected function canSaveUrlInformation() { goto F8fd2; C013c: return false; goto Db6b7; d1688: $cacheWarmerRoutes = $this->varnishConfig->getCacheWarmerRoutes(); goto Ceb12; b2acd: return false; goto F70bb; Bbb53: $cacheWarmerRouteFound = false; goto d3cf6; e7d92: a0321: goto f060b; f060b: if (!(false === $cacheWarmerRouteFound)) { goto a360a; } goto C013c; d5816: $requestParams = (array) $this->request->getQuery(); goto C78fc; Ceb12: foreach ($cacheWarmerRoutes as $cacheWarmerRoute) { goto dd80f; Db814: $cacheWarmerRouteFound = true; goto A4c2b; edc8e: b453b: goto Df623; dd80f: if (!($cacheWarmerRoute == $fullActionName)) { goto F67f9; } goto Db814; A4c2b: goto a0321; goto Ad470; Ad470: F67f9: goto edc8e; Df623: } goto e7d92; F8fd2: $isAdminStore = $this->isAdminStore(); goto c7b6c; Baba4: Db8a4: goto d5816; aad32: return false; goto Baba4; A3f0e: if (!(false === $isCacheWarmerEnabled)) { goto Db8a4; } goto aad32; b0fb8: Ca877: goto D1536; D1536: $isCacheWarmerEnabled = $this->varnishConfig->isCacheWarmerEnabled(); goto A3f0e; Db6b7: a360a: goto fc910; c7b6c: if (!(true === $isAdminStore)) { goto Ca877; } goto B2c9b; B2c9b: return false; goto b0fb8; C78fc: if (!count($requestParams)) { goto fc005; } goto b2acd; fc910: return true; goto a962f; d3cf6: $fullActionName = $this->request->getFullActionName(); goto d1688; F70bb: fc005: goto Bbb53; a962f: } protected function isAdminStore() { $isAdminStore = $this->state->getAreaCode() == self::ADMIN_AREA_CODE; return $isAdminStore; } protected function getObjectManager() { $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); return $objectManager; } }