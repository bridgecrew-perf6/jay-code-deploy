<?php
 namespace Mgt\Varnish\Controller\Api; class PurgeUrl extends \Magento\Framework\App\Action\Action { protected $cachePurger; protected $config; public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\CacheInvalidate\Model\PurgeCache $cachePurger, \Mgt\Varnish\Model\Cache\Config $config) { goto e00fb; e00fb: $this->cachePurger = $cachePurger; goto A61ab; aa5d1: parent::__construct($context); goto e759a; A61ab: $this->config = $config; goto aa5d1; e759a: } public function execute() { goto C9005; F3c55: $response->setHeader("\103\x6f\156\164\x65\x6e\164\55\x54\171\160\x65", "\141\160\x70\154\151\143\141\164\x69\x6f\x6e\57\x6a\163\x6f\156"); goto E03c8; a1581: $secretKey = $request->getParam("\x73\145\x63\x72\145\x74\x4b\145\171"); goto c8ef6; C9005: $request = $this->getRequest(); goto d75c9; c8ef6: $url = $request->getParam("\165\x72\154"); goto a80fb; d75c9: $response = $this->getResponse(); goto D22a4; bf247: $response->sendResponse(); goto f4123; D429f: E7bdd: goto A9a0e; A9a0e: $body = json_encode($body); goto F3c55; a80fb: if (!($secretKey && $url)) { goto E7bdd; } goto Ba340; E03c8: $response->setBody($body); goto bf247; Ba340: try { goto c2532; f079e: Ca6b3: goto a585f; a585f: $this->cachePurger->purgeUrlRequest($url); goto a5518; e77e1: if (!($secretKey != $apiSecretKey)) { goto Ca6b3; } goto b0d68; b0d68: throw new \Exception("\123\x65\x63\162\x65\164\40\141\x70\x69\40\153\145\x79\40\151\x73\x20\156\x6f\x74\x20\143\x6f\x72\162\145\x63\x74"); goto f079e; a5518: $body = ["\x73\165\x63\x63\145\x73\163" => 1, "\155\x65\163\163\x61\147\x65" => sprintf("\124\150\145\x20\x55\x52\114\40\42\45\163\42\x20\150\141\163\40\x62\x65\145\156\40\160\x75\162\x67\145\x64\x2e", $url)]; goto f1dc3; c2532: $apiSecretKey = $this->config->getApiSecretKey(); goto e77e1; f1dc3: } catch (\Exception $e) { $errorMessage = $e->getMessage(); $body = ["\163\x75\143\143\145\x73\x73" => 0, "\155\x65\163\163\141\147\145" => $errorMessage]; } goto D429f; D22a4: $body = []; goto a1581; f4123: exit; goto fb2d5; fb2d5: } }
