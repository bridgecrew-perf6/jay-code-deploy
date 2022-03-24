<?php
 namespace Mgt\Varnish\Model\Observer; use Magento\Framework\Event\ObserverInterface; class ProductSaveAfterObserver implements ObserverInterface { protected $config; protected $productUrlRewriteGenerator; protected $catalogProductTypeConfigurable; protected $productFactory; protected $varnishConfig; protected $urlQueue; protected static $isQueued = false; public function __construct(\Magento\PageCache\Model\Config $config, \Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator $productUrlRewriteGenerator, \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable $catalogProductTypeConfigurable, \Magento\Catalog\Model\ProductFactory $productFactory, \Mgt\Varnish\Model\UrlQueue $urlQueue, \Mgt\Varnish\Model\Cache\Config $varnishConfig) { goto D5e17; B83d2: $this->productFactory = $productFactory; goto be83b; Cb574: $this->catalogProductTypeConfigurable = $catalogProductTypeConfigurable; goto B83d2; d79d3: $this->productUrlRewriteGenerator = $productUrlRewriteGenerator; goto Cb574; be83b: $this->urlQueue = $urlQueue; goto ae7ba; D5e17: $this->config = $config; goto d79d3; ae7ba: $this->varnishConfig = $varnishConfig; goto d1a12; d1a12: } public function execute(\Magento\Framework\Event\Observer $observer) { goto D09f3; Af725: $urls = []; goto Fb0c4; dc88b: if (!count($parentProductIds)) { goto Aa5e4; } goto baade; Fb0c4: if (false === empty($productUrls)) { goto e082f; } goto Db1b5; d493a: goto F93bb; goto Ae1fb; caec2: C4d29: goto b1a23; efbac: $parentProductIds = $this->catalogProductTypeConfigurable->getParentIdsByChild($productId); goto dc88b; b1a23: c1462: goto e4140; baade: foreach ($parentProductIds as $parentProductId) { goto F174d; F174d: $product = $this->productFactory->create(); goto b41fa; ebbeb: efb05: goto A0579; b699f: A95fa: goto ebbeb; Aa7e6: $productUrls = $this->productUrlRewriteGenerator->generate($product); goto a2ca8; b41fa: $product->load($parentProductId); goto Aa7e6; a2ca8: foreach ($productUrls as $url) { $urls[] = ["\163\x74\x6f\162\145\x5f\151\144" => $url->getStoreId(), "\160\x61\x74\150" => $url->getRequestPath(), "\160\x72\151\x6f\x72\151\164\171" => \Mgt\Varnish\Model\UrlQueue::PRIORITY_HIGH]; a84b0: } goto b699f; A0579: } goto D2b6a; Fe202: if (!count($urls)) { goto C4d29; } goto a595f; ff9b9: fac07: goto d1586; D2b6a: ec9b0: goto B03c6; d1586: F93bb: goto Fe202; D09f3: $product = $observer->getEvent()->getProduct(); goto F3a7a; Db1b5: $productId = $product->getId(); goto efbac; Ae1fb: e082f: goto d7289; fb443: $productUrls = $this->productUrlRewriteGenerator->generate($product); goto Af725; d7289: foreach ($productUrls as $url) { $urls[] = ["\x73\164\x6f\162\x65\137\x69\x64" => $url->getStoreId(), "\x70\141\164\150" => $url->getRequestPath(), "\x70\x72\151\157\x72\x69\x74\171" => \Mgt\Varnish\Model\UrlQueue::PRIORITY_HIGH]; cd573: } goto ff9b9; a595f: try { $this->urlQueue->addToQueue($urls); } catch (\Exception $e) { } goto caec2; B03c6: Aa5e4: goto d493a; D3876: if (!(true === $isCacheWarmerEnabled && isset($product) && $product instanceof \Magento\Catalog\Model\Product)) { goto c1462; } goto fb443; F3a7a: $isCacheWarmerEnabled = $this->varnishConfig->isCacheWarmerEnabled(); goto D3876; e4140: } }