<?php
 namespace Mgt\Waf\Model\Plugin; use Magento\Backend\Setup\ConfigOptionsList as BackendConfigOptionsList; use Mgt\Waf\Model\Aws\Waf as AwsWaf; use Mgt\Waf\Model\Util\Retry; class Waf { const MGT_WAF_CONFIG_DATA = "\x6d\147\x74\x57\141\146\103\x6f\156\146\x69\147\x44\x61\x74\x61"; const MGT_WAF_CONFIG_DATA_SECTION = "\155\x67\164\x5f\167\x61\146"; const MAGENTO_BACKEND_RESTRICTION_ENABLED = 1; const MAGENTO_BACKEND_RESTRICTION_DISABLED = 0; const MAGENTO_BACKEND_RESTRICTION_ACTION_ALLOW = "\x41\x6c\154\x6f\x77"; const MAGENTO_BACKEND_RESTRICTION_ACTION_BLOCK = "\102\154\x6f\143\x6b"; protected $awsWaf; protected $configData = []; protected $awsAccessKey; protected $awsSecretAccessKey; protected $awsRegion; protected $blockedIps = []; protected $blockedCountryCodes = []; protected $blockedIpsIpv4 = []; protected $blockedIpsIpv6 = []; protected $blockedBots = []; protected $webAcl; protected $webAclName; protected $rateLimit; protected $rateLimitWhitelistedIps = []; protected $rateLimitWhitelistedIpsIpv4 = []; protected $rateLimitWhitelistedIpsIpv6 = []; protected $isMagentoBackendRestricted = false; protected $magentoBackendWhitelistedIps = []; protected $magentoBackendWhitelistedIpIpv4 = []; protected $magentoBackendWhitelistedIpIpv6 = []; protected $projectName; protected $deploymentConfig; protected $remoteAddress; protected $session; public function __construct(\Magento\Backend\Model\Session $session, \Magento\Framework\App\DeploymentConfig $deploymentConfig, \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress) { goto Abcdd; B2432: $this->deploymentConfig = $deploymentConfig; goto b38e5; b38e5: $this->remoteAddress = $remoteAddress; goto F06f2; Abcdd: $this->session = $session; goto B2432; F06f2: } public function beforeSave(\Magento\Config\Model\Config $subject) { try { goto Cad59; f4839: $this->session->unsetData(self::MGT_WAF_CONFIG_DATA); goto c4607; fbbc3: if (!(true === isset($this->configData["\x73\145\143\164\151\157\156"]) && $this->configData["\163\x65\x63\x74\x69\157\x6e"] == self::MGT_WAF_CONFIG_DATA_SECTION)) { goto C2f15; } goto e473d; Da23c: C2f15: goto Fc21f; D1a99: f1f3b: goto f4839; C1034: if (!(false === $isMgt)) { goto f1f3b; } goto b77be; Cad59: $this->configData = $subject->getData(); goto fbbc3; c4607: $this->validate(); goto b45ad; e473d: $isMgt = true === isset($_SERVER["\115\x47\x54"]) && $_SERVER["\x4d\x47\x54"] == "\x31" ? true : false; goto C1034; b77be: return; goto D1a99; b45ad: $this->updateWaf(); goto Da23c; Fc21f: } catch (\Exception $e) { $this->session->setData(self::MGT_WAF_CONFIG_DATA, $this->configData); throw $e; } } protected function validate() { goto c4bbe; Ff181: $this->validateRateLimitWhitelistIps(); goto E0b5e; d0732: $this->validateBlockedIps(); goto F60d0; a3fc5: $this->validateWebAcl(); goto d0732; E0b5e: $this->validateMagentoBackendWhitelistedIps(); goto a97e9; c4bbe: $this->validateAccessKeys(); goto a3fc5; F60d0: $this->validateRateLimit(); goto Ff181; a97e9: } protected function updateWaf() { try { goto A7c78; d506d: $webAcl = $this->getWebAcl(); goto fa5a6; c53c5: $this->updateBlockedCountryCodes(); goto F37de; ad015: $this->updateMagentoBackend(); goto d506d; fa5a6: $awsWaf = $this->getAwsWaf(); goto bebd8; Ea3bb: $this->updateBlockedBots(); goto C8992; A7c78: $webAclName = $this->getWebAclName(); goto c53c5; Ba6ec: $this->updateRateLimitWhitelistedIpSets(); goto ad015; F37de: $this->updateBlockedIpsIpSets(); goto Ea3bb; C8992: $this->updateRateLimitValue(); goto Ba6ec; bebd8: $awsWaf->updateWebAcl($webAcl); goto Bdcad; Bdcad: } catch (\Exception $e) { $errorMessage = sprintf("\125\x6e\x61\x62\x6c\x65\40\x74\x6f\x20\165\x70\x64\141\164\145\x20\127\145\x62\x20\101\x43\114\40\42\x25\x73\x22\54\40\x65\x72\x72\x6f\162\x20\155\x65\x73\x73\141\x67\145\72\x20\x22\45\163\x22\x2e", $webAclName, $e->getMessage()); throw new \Exception($errorMessage); } } protected function validateAccessKeys() { try { goto e7d7e; d78b8: $wafClient = $awsWaf->getWafClient(); goto d5d6a; d5d6a: $this->retry(function () use($wafClient) { $wafClient->listIPSets(["\123\x63\157\x70\145" => AwsWaf::SCOPE_REGIONAL]); }); goto c1693; e7d7e: $awsWaf = $this->getAwsWaf(); goto d78b8; c1693: } catch (\Exception $e) { $errorMessage = sprintf("\101\127\123\x20\x43\x72\x65\x64\x65\156\164\x69\x61\x6c\163\x20\141\162\145\x20\x6e\x6f\x74\x20\166\141\154\151\144\56"); throw new \Exception($errorMessage); } } protected function validateWebAcl() { goto C44fe; ecccc: $awsRegion = $this->getAwsRegion(); goto d05ae; c5146: $webAcls = $awsWaf->getWebAcls(); goto Ce7c5; Ce7c5: if (!(false === empty($webAcls))) { goto a491d; } goto B1e24; F8512: $webAclName = $this->getWebAclName(); goto b4602; F45b1: a491d: goto Fd4b3; Becf6: C1dcf: goto F45b1; d05ae: $errorMessage = sprintf("\127\x65\x62\40\x41\143\x6c\40\x22\x25\163\42\x20\144\157\145\163\x20\156\157\x74\40\x65\x78\151\x73\x74\x20\151\156\x20\101\x57\123\40\122\x65\x67\x69\157\156\x20\42\x25\x73\x22\x2e", $webAclName, $awsRegion); goto Af1bb; c97ec: c7c89: goto C5fe8; b4602: $awsWaf = $this->getAwsWaf(); goto c5146; B1e24: foreach ($webAcls as $webAcl) { goto Edc18; A9c30: e2f37: goto fc18f; D0919: acca8: goto A9c30; cc6ea: $webAclFound = true; goto B7276; B7276: goto C1dcf; goto D0919; Edc18: if (!(true === isset($webAcl["\116\141\x6d\x65"]) && $webAclName == $webAcl["\116\x61\x6d\145"])) { goto acca8; } goto cc6ea; fc18f: } goto Becf6; Af1bb: throw new \Exception($errorMessage); goto c97ec; C44fe: $webAclFound = false; goto F8512; Fd4b3: if (!(false === $webAclFound)) { goto c7c89; } goto ecccc; C5fe8: } protected function validateBlockedIps() { goto d0379; Fdc5f: c2e59: goto F2bab; F2bab: Fb581: goto B2df2; d0379: $blockedIps = $this->getBlockedIps(); goto c49a8; c49a8: if (!(false === empty($blockedIps))) { goto Fb581; } goto deb82; deb82: foreach ($blockedIps as $ip) { goto Fc904; ffe39: ecde1: goto B2d2b; Fac74: goto ecde1; goto Fa282; E9dce: if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) { goto E8b8f; } goto D1f2f; B2d2b: goto d9b71; goto f1adf; Fa282: E8b8f: goto E693b; f1adf: Da22b: goto C9225; C9225: $this->blockedIpsIpv6[] = $ip; goto a0c1a; a1f66: ccfc1: goto B0309; Fc904: if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) { goto Da22b; } goto E9dce; a0c1a: d9b71: goto a1f66; D1f2f: throw new \Exception(sprintf("\102\x6c\x6f\x63\153\145\144\x20\111\120\40\42\x25\163\42\x20\x69\163\40\x6e\157\x74\40\x76\141\154\x69\144\56", $ip)); goto Fac74; E693b: $this->blockedIpsIpv4[] = $ip; goto ffe39; B0309: } goto Fdc5f; B2df2: } protected function validateRateLimitWhitelistIps() { goto f7941; bb7d6: B63cc: goto B8c74; f7941: $rateLimitWhitelistedIps = $this->getRateLimitWhitelistedIps(); goto a05c6; a05c6: if (!(false === empty($rateLimitWhitelistedIps))) { goto Ce852; } goto Dadcd; Dadcd: foreach ($rateLimitWhitelistedIps as $ip) { goto cb642; fd0a0: E873d: goto C7ddd; B8192: e2b9d: goto Df118; Df118: goto be17e; goto aec65; Cc919: $this->rateLimitWhitelistedIpsIpv4[] = $ip; goto B8192; Aa442: if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) { goto E7fe8; } goto F256d; F256d: throw new \Exception(sprintf("\x52\x61\x74\145\x20\114\151\155\x69\164\40\127\150\x69\164\x65\x6c\x69\163\x74\x65\144\x20\x49\x50\x20\42\45\x73\x22\x20\x69\163\40\156\157\164\x20\x76\141\154\x69\x64\x2e", $ip)); goto adc51; A3f30: E7fe8: goto Cc919; adc51: goto e2b9d; goto A3f30; cb642: if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) { goto eed4e; } goto Aa442; E8cd4: be17e: goto fd0a0; D7baa: $this->rateLimitWhitelistedIpsIpv6[] = $ip; goto E8cd4; aec65: eed4e: goto D7baa; C7ddd: } goto bb7d6; B8c74: Ce852: goto da212; da212: } protected function validateMagentoBackendWhitelistedIps() { goto E137a; A2608: D52e5: goto a16db; B2b51: F2d82: goto A2608; Df8da: if (!(false === empty($magentoBackendWhitelistedIps))) { goto D52e5; } goto C4b2d; E137a: $magentoBackendWhitelistedIps = $this->getMagentoBackendWhitelistedIps(); goto Df8da; C4b2d: foreach ($magentoBackendWhitelistedIps as $ip) { goto F6968; f22a2: if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) { goto D2cb5; } goto F3eff; F6968: if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) { goto d2898; } goto f22a2; abb6c: A8467: goto ac351; a1f1c: $this->magentoBackendWhitelistedIpIpv6[] = $ip; goto abb6c; b7bc7: D2cb5: goto Db3cd; C3048: goto A8467; goto F724a; ac351: Bae3e: goto A557f; F3eff: throw new \Exception(sprintf("\115\x61\147\x65\x6e\x74\x6f\x20\102\x61\x63\x6b\x65\x6e\144\x20\x57\150\x69\164\x65\154\151\163\x74\x65\x64\x20\111\120\40\x22\x25\163\42\40\151\163\x20\156\157\164\x20\166\141\x6c\x69\144\x2e", $ip)); goto bbd25; bbd25: goto E6dea; goto b7bc7; a02ab: E6dea: goto C3048; Db3cd: $this->magentoBackendWhitelistedIpIpv4[] = $ip; goto a02ab; F724a: d2898: goto a1f1c; A557f: } goto B2b51; a16db: } protected function validateRateLimit() { goto F4e37; bc1a1: c4b95: goto e702c; B029c: throw new \Exception(sprintf("\122\141\164\145\40\114\x69\155\x69\164\x20\x22\45\163\42\x20\156\157\164\x20\166\141\x6c\x69\x64\54\40\x6d\165\163\x74\x20\142\145\40\142\145\164\167\x65\x65\x6e\x20\x31\60\x30\x20\x61\156\144\40\x31\65\60\60\x30\x2e", $rateLimit)); goto bc1a1; ec407: if (!($rateLimit < 100 || $rateLimit > 15000)) { goto c4b95; } goto B029c; F4e37: $rateLimit = $this->getRateLimit(); goto ec407; e702c: } protected function updateMagentoBackend() { goto e20d8; B7642: unset($this->webAcl["\x52\165\x6c\145\163"][$webAclRuleArrayIndex]["\101\143\x74\151\157\156"]); goto Ee441; d49ed: $backendFrontName = $this->getBackendFrontName(); goto c82e5; fd984: $webAclRuleArrayIndex = $this->getWebAclRuleArrayIndex($webAclRuleName); goto b78d7; f9ed4: $this->webAcl["\122\x75\x6c\x65\x73"][$webAclRuleArrayIndex]["\x53\x74\x61\164\x65\x6d\x65\x6e\164"]["\101\x6e\x64\x53\164\x61\164\x65\155\145\156\x74"]["\x53\164\x61\164\145\155\145\x6e\164\163"][0]["\x42\171\x74\145\115\141\x74\x63\150\x53\164\141\164\145\155\145\x6e\164"]["\123\145\x61\162\143\x68\123\164\x72\151\x6e\147"] = $backendFrontName; goto b8de2; d64dc: $webAclRuleArrayIndex = $this->getWebAclRuleArrayIndex($webAclRuleName); goto e9dfc; C7029: $webAclRuleArrayIndex = $this->getWebAclRuleArrayIndex($webAclRuleName); goto D554d; Fe206: fe9f9: goto E1a27; b78d7: if (!(true === isset($this->webAcl["\x52\165\154\x65\163"][$webAclRuleArrayIndex]))) { goto fe9f9; } goto ea711; be61b: Ef625: goto Bc759; C979d: $this->webAcl["\122\165\x6c\x65\x73"][$webAclRuleArrayIndex]["\101\x63\164\x69\x6f\156"][$action] = []; goto E683e; Fd7be: if (!(true === $isMagentoBackendRestricted)) { goto Db651; } goto f1037; F6995: fa560: goto be61b; E1a27: $isMagentoBackendRestricted = $this->isMagentoBackendRestricted(); goto Fd7be; e9dfc: if (!(true === isset($this->webAcl["\122\x75\x6c\145\x73"][$webAclRuleArrayIndex]))) { goto Fcda0; } goto f9ed4; ea711: $this->webAcl["\x52\165\x6c\x65\163"][$webAclRuleArrayIndex]["\123\164\141\164\145\155\x65\156\x74"]["\x41\x6e\144\123\x74\x61\x74\145\x6d\145\156\164"]["\123\164\141\164\x65\155\145\156\164\163"][0]["\x42\171\164\x65\x4d\141\x74\x63\150\x53\x74\141\x74\145\155\x65\x6e\164"]["\x53\145\141\x72\143\150\123\x74\x72\151\x6e\x67"] = $backendFrontName; goto Fe206; D16ea: ee9e4: goto Cc153; E683e: $this->webAcl["\122\x75\154\x65\163"][$webAclRuleArrayIndex]["\123\164\x61\x74\145\x6d\145\x6e\x74"]["\102\171\164\145\x4d\141\x74\143\150\123\x74\x61\164\145\155\145\x6e\164"]["\x53\x65\x61\x72\143\x68\x53\x74\x72\x69\156\x67"] = $backendFrontName; goto a3522; A8eeb: $action = true === $isMagentoBackendRestricted ? self::MAGENTO_BACKEND_RESTRICTION_ACTION_BLOCK : self::MAGENTO_BACKEND_RESTRICTION_ACTION_ALLOW; goto C979d; Ff5bf: if (filter_var($customerIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) { goto B83c0; } goto F1e75; E5448: if (!(false === empty($customerIp))) { goto Ef625; } goto Ff5bf; cc6f8: goto fa560; goto D1ec1; D1ec1: B83c0: goto Acca7; Ed46d: $isMagentoBackendRestricted = $this->isMagentoBackendRestricted(); goto b3edf; Acca7: $this->magentoBackendWhitelistedIpIpv6[] = $customerIp; goto F6995; Bab6b: $webAclRuleName = $awsWaf->getWebAclRuleName(AwsWaf::WEB_ACL_RULE_ALLOW_MAGENTO_BACKEND_ACCESS_IPV6); goto fd984; Dec50: $awsWaf->updateIpSet(AwsWaf::IP_SET_MAGENTO_BACKEND_WHITELISTED_IPV6, $this->magentoBackendWhitelistedIpIpv6); goto b181c; c82e5: $webAclRuleName = $awsWaf->getWebAclRuleName(AwsWaf::WEB_ACL_RULE_BLOCK_MAGENTO_BACKEND_ACCESS); goto C7029; e20d8: $awsWaf = $this->getAwsWaf(); goto d49ed; b8de2: Fcda0: goto Bab6b; a3522: Fdcbf: goto D85cb; f1037: $customerIp = $this->remoteAddress->getRemoteAddress(); goto E5448; f0a32: foreach ($this->magentoBackendWhitelistedIpIpv6 as &$ip) { $ip = sprintf("\45\163\x2f\61\62\70", $ip); A1c13: } goto D16ea; Bc759: Db651: goto A4cc2; Ee441: F2ce9: goto A8eeb; D554d: if (!(true === isset($this->webAcl["\x52\x75\x6c\x65\x73"][$webAclRuleArrayIndex]))) { goto Fdcbf; } goto Ed46d; b3edf: if (!(true === isset($this->webAcl["\x52\165\x6c\145\x73"][$webAclRuleArrayIndex]["\x41\143\x74\151\157\x6e"]))) { goto F2ce9; } goto B7642; d347a: Fb9f6: goto f0a32; D85cb: $webAclRuleName = $awsWaf->getWebAclRuleName(AwsWaf::WEB_ACL_RULE_ALLOW_MAGENTO_BACKEND_ACCESS_IPV4); goto d64dc; F1e75: $this->magentoBackendWhitelistedIpIpv4[] = $customerIp; goto cc6f8; A4cc2: foreach ($this->magentoBackendWhitelistedIpIpv4 as &$ip) { $ip = sprintf("\x25\x73\x2f\x33\62", $ip); b2b24: } goto d347a; Cc153: $awsWaf->updateIpSet(AwsWaf::IP_SET_MAGENTO_BACKEND_WHITELISTED_IPV4, $this->magentoBackendWhitelistedIpIpv4); goto Dec50; b181c: } protected function updateBlockedCountryCodes() { goto b5de9; cd2a2: throw new \Exception(sprintf("\x57\x65\x62\x20\101\x43\x4c\40\122\x75\x6c\145\40\x22\45\x73\x22\40\x6e\157\164\40\x66\157\x75\156\144\56", $webAclRuleName)); goto E12ed; E23a0: $awsWaf = $this->getAwsWaf(); goto a521c; b5de9: $blockedCountryCodes = $this->getBlockedCountryCodes(); goto f414b; a4cf7: $blockedCountryCodes = ["\x54\126"]; goto d1156; a521c: $webAclRuleName = $awsWaf->getWebAclRuleName(AwsWaf::WEB_ACL_RULE_NAME_BLOCKED_COUNTRIES); goto c24dc; c24dc: $webAclRuleArrayIndex = $this->getWebAclRuleArrayIndex($webAclRuleName); goto f7e53; F1ed5: $this->webAcl["\x52\x75\154\145\163"][$webAclRuleArrayIndex]["\x53\164\x61\164\145\155\x65\x6e\x74"]["\x47\145\x6f\x4d\x61\164\143\x68\x53\x74\x61\x74\x65\x6d\145\x6e\x74"]["\103\x6f\165\x6e\x74\x72\171\103\x6f\144\x65\163"] = $blockedCountryCodes; goto F0070; f414b: if (!(true === empty($blockedCountryCodes))) { goto A2d9c; } goto a4cf7; d1156: A2d9c: goto E23a0; F0070: c7b4f: goto Ecb6f; Ab69b: A6dac: goto F1ed5; E12ed: goto c7b4f; goto Ab69b; f7e53: if (true === isset($this->webAcl["\122\165\x6c\x65\x73"][$webAclRuleArrayIndex])) { goto A6dac; } goto cd2a2; Ecb6f: } protected function updateRateLimitValue() { goto Db6c8; F08dd: goto fca9a; goto f9d72; daad7: $webAclRuleArrayIndex = $this->getWebAclRuleArrayIndex($webAclRuleNameRateLimitIPv4); goto c4a39; a1f9e: $webAclRuleArrayIndex = $this->getWebAclRuleArrayIndex($webAclRuleNameRateLimitIPv6); goto Baead; F4440: throw new \Exception(sprintf("\x57\145\142\x20\101\103\x4c\x20\122\x75\154\145\x20\x22\x25\163\x22\x20\156\x6f\x74\40\x66\157\165\x6e\x64\x2e", $webAclRuleNameRateLimitIPv4)); goto F08dd; Cfbe0: fca9a: goto f6ce2; Bcf6a: $rateLimit = (int) $this->getRateLimit(); goto f2b30; f9687: $this->webAcl["\122\165\x6c\x65\x73"][$webAclRuleArrayIndex]["\x53\x74\x61\x74\145\x6d\145\156\x74"]["\122\141\164\145\102\x61\163\x65\144\123\x74\141\x74\x65\x6d\145\x6e\164"]["\x4c\151\x6d\151\164"] = $rateLimit; goto Cfbe0; f2b30: $webAclRuleNameRateLimitIPv4 = $awsWaf->getWebAclRuleName(AwsWaf::WEB_ACL_RULE_NAME_RATE_LIMIT_IPV4); goto daad7; f9d72: d33e7: goto f9687; f6ce2: $webAclRuleNameRateLimitIPv6 = $awsWaf->getWebAclRuleName(AwsWaf::WEB_ACL_RULE_NAME_RATE_LIMIT_IPV6); goto a1f9e; B8a28: goto D768b; goto dfacd; Baead: if (true === isset($this->webAcl["\x52\165\154\145\x73"][$webAclRuleArrayIndex])) { goto Dbbcf; } goto B7444; E4d5c: D768b: goto Ec285; B7444: throw new \Exception(sprintf("\x57\x65\x62\x20\101\103\114\x20\122\165\x6c\145\40\x22\45\163\x22\x20\156\x6f\x74\x20\x66\157\165\x6e\x64\56", $webAclRuleNameRateLimitIPv6)); goto B8a28; c4a39: if (true === isset($this->webAcl["\x52\x75\154\x65\x73"][$webAclRuleArrayIndex])) { goto d33e7; } goto F4440; b23b9: $this->webAcl["\x52\x75\x6c\145\163"][$webAclRuleArrayIndex]["\123\164\x61\x74\145\155\145\156\164"]["\122\x61\x74\145\x42\141\163\145\144\x53\164\141\164\145\x6d\145\x6e\164"]["\x4c\151\x6d\x69\x74"] = $rateLimit; goto E4d5c; dfacd: Dbbcf: goto b23b9; Db6c8: $awsWaf = $this->getAwsWaf(); goto Bcf6a; Ec285: } protected function updateRateLimitWhitelistedIpSets() { goto b99f8; F1642: $awsWaf = $this->getAwsWaf(); goto Fda1a; b99f8: foreach ($this->rateLimitWhitelistedIpsIpv4 as &$ip) { $ip = sprintf("\x25\x73\57\63\62", $ip); Cea5f: } goto C2e39; F10be: $awsWaf->updateIpSet(AwsWaf::IP_SET_RATE_LIMIT_WHITELISTED_IPV6, $this->rateLimitWhitelistedIpsIpv6); goto de0df; De57d: foreach ($this->rateLimitWhitelistedIpsIpv6 as &$ip) { $ip = sprintf("\x25\x73\x2f\61\x32\x38", $ip); d2867: } goto c22a8; C2e39: a7291: goto De57d; Fda1a: $awsWaf->updateIpSet(AwsWaf::IP_SET_RATE_LIMIT_WHITELISTED_IPV4, $this->rateLimitWhitelistedIpsIpv4); goto F10be; c22a8: ee13b: goto F1642; de0df: } protected function updateBlockedIpsIpSets() { goto e088c; A9748: $awsWaf->updateIpSet(AwsWaf::IP_SET_BLOCKED_IPS_IPV6, $this->blockedIpsIpv6); goto a6941; b0211: $awsWaf->updateIpSet(AwsWaf::IP_SET_BLOCKED_IPS_IPV4, $this->blockedIpsIpv4); goto A9748; fc7ac: $awsWaf = $this->getAwsWaf(); goto b0211; c3871: De0f2: goto fc7ac; C1ebe: B0a44: goto Dd4fd; Dd4fd: foreach ($this->blockedIpsIpv6 as &$ip) { $ip = sprintf("\x25\163\57\61\62\x38", $ip); D9e71: } goto c3871; e088c: foreach ($this->blockedIpsIpv4 as &$ip) { $ip = sprintf("\45\x73\57\x33\x32", $ip); D04e0: } goto C1ebe; a6941: } protected function updateBlockedBots() { goto Ee875; ae356: $blockedBots[] = "\x6d\x67\x74"; goto ea64b; d27a9: $awsWaf->updateBlockedBotsRegexPatternSet($blockedBots); goto Eaa1a; ea64b: ed6a1: goto e5820; a9ce1: if (!(true === empty($blockedBots))) { goto ed6a1; } goto ae356; Ee875: $blockedBots = $this->getBlockedBots(); goto a9ce1; e5820: $awsWaf = $this->getAwsWaf(); goto d27a9; Eaa1a: } protected function getAwsWaf() { goto Ae474; Ae474: if (!(true === is_null($this->awsWaf))) { goto ed7d1; } goto Ae810; E562c: $this->awsWaf = new AwsWaf($awsAccessKey, $awsSecretAccessKey, $awsRegion, $projectName); goto E4e93; Ea38a: $projectName = $this->getProjectName(); goto E562c; f420f: $awsRegion = $this->getAwsRegion(); goto Ea38a; D83c7: return $this->awsWaf; goto ce4bd; Ae810: $awsAccessKey = $this->getAwsAccessKey(); goto Abbc5; Abbc5: $awsSecretAccessKey = $this->getAwsSecretAccessKey(); goto f420f; E4e93: ed7d1: goto D83c7; ce4bd: } protected function getAwsAccessKey() { goto b4f89; b2fb5: A42fd: goto db290; b4f89: if (!(true === is_null($this->awsAccessKey))) { goto A42fd; } goto f251b; f251b: $this->awsAccessKey = $this->getConfigValue("\x73\x65\x74\x74\x69\156\x67\163", "\x61\x77\x73\x5f\x61\x63\143\145\x73\163\137\153\145\x79"); goto b2fb5; db290: return $this->awsAccessKey; goto d663c; d663c: } protected function getAwsSecretAccessKey() { goto Bec77; Cfc50: $this->awsSecretAccessKey = $this->getConfigValue("\163\145\x74\x74\151\x6e\147\x73", "\x61\167\163\137\x73\x65\x63\162\145\164\137\x61\x63\x63\145\x73\x73\x5f\x6b\x65\171"); goto B5417; Bec77: if (!(true === is_null($this->awsSecretAccessKey))) { goto d0026; } goto Cfc50; A1815: return $this->awsSecretAccessKey; goto cde62; B5417: d0026: goto A1815; cde62: } protected function getAwsRegion() { goto E6b7d; d0c62: return $this->awsRegion; goto Ae39f; Ea957: Bfbcd: goto d0c62; E6b7d: if (!(true == is_null($this->awsRegion))) { goto Bfbcd; } goto E9646; E9646: $this->awsRegion = $this->getConfigValue("\163\x65\x74\x74\151\x6e\147\163", "\141\x77\x73\137\x72\145\147\151\157\156"); goto Ea957; Ae39f: } protected function getProjectName() { goto aaf5f; f9d0b: f34c3: goto C7a53; aaf5f: if (!(true === is_null($this->projectName))) { goto f34c3; } goto B02ca; B02ca: $this->projectName = $this->getConfigValue("\163\145\164\164\x69\156\x67\x73", "\160\162\x6f\x6a\145\x63\164\x5f\x6e\141\155\145"); goto f9d0b; C7a53: return $this->projectName; goto D3aa2; D3aa2: } protected function getRateLimit() { goto cccde; cd4e1: $this->rateLimit = $this->getConfigValue("\162\141\164\x65\137\x6c\x69\155\151\x74", "\162\x61\x74\x65\x5f\154\x69\155\151\164"); goto f1f15; cccde: if (!(true === is_null($this->rateLimit))) { goto e4968; } goto cd4e1; f1f15: e4968: goto F6826; F6826: return $this->rateLimit; goto Df740; Df740: } protected function getBlockedCountryCodes() { goto Da948; Be2fb: $this->blockedCountryCodes = $blockedCountryCodes; goto E0684; D64c3: $blockedCountryCodes = $this->getConfigValue("\142\x6c\157\143\x6b\x65\x64\137\143\157\x75\156\x74\162\x69\145\163", "\x63\x6f\165\156\x74\x72\x79\137\x63\157\x64\x65\163"); goto da014; e3d62: return $this->blockedCountryCodes; goto C7d59; Da948: if (!(true === empty($this->blockedCountryCodes))) { goto d193c; } goto D64c3; Fa3ab: d193c: goto e3d62; E0684: c0e00: goto Fa3ab; da014: if (!(false === empty($blockedCountryCodes))) { goto c0e00; } goto Be2fb; C7d59: } protected function getBlockedIps() { goto b3301; Eaf0c: $blockedIps = explode(PHP_EOL, $blockedIps); goto Cde56; e8de1: $blockedIps = $this->getConfigValue("\142\x6c\157\143\153\145\x64\137\151\x70\x73", "\142\154\x6f\x63\153\145\144\137\151\160\163"); goto Eaf0c; Cdef2: $this->blockedIps = $blockedIps; goto f9e3a; b3301: if (!(true === empty($this->blockedIps))) { goto b80ee; } goto e8de1; Cde56: $blockedIps = array_filter(array_map("\164\162\x69\x6d", $blockedIps)); goto C19ce; f9e3a: ba808: goto c47c7; c47c7: b80ee: goto ebb5b; ebb5b: return $this->blockedIps; goto F6089; C19ce: if (!(false === empty($blockedIps))) { goto ba808; } goto Cdef2; F6089: } protected function getRateLimitWhitelistedIps() { goto Ce670; Ca9cd: b0e9e: goto Fc2bf; Fc2bf: return $this->rateLimitWhitelistedIps; goto C92af; Ce1da: $rateLimitWhitelistedIps = explode(PHP_EOL, $rateLimitWhitelistedIps); goto b6733; e0591: if (!(false === empty($rateLimitWhitelistedIps))) { goto Aa480; } goto B7912; B7912: $this->rateLimitWhitelistedIps = $rateLimitWhitelistedIps; goto eb4b9; Ce670: if (!(true === empty($this->rateLimitWhitelistedIps))) { goto b0e9e; } goto Baa38; Baa38: $rateLimitWhitelistedIps = $this->getConfigValue("\162\x61\164\145\x5f\x6c\151\x6d\x69\x74", "\167\150\x69\x74\145\x6c\x69\163\x74\145\144\x5f\151\160\x73"); goto Ce1da; b6733: $rateLimitWhitelistedIps = array_filter(array_map("\x74\x72\151\x6d", $rateLimitWhitelistedIps)); goto e0591; eb4b9: Aa480: goto Ca9cd; C92af: } protected function getBlockedBots() { goto dc1c3; e42ce: E247a: goto fb351; b0707: $blockedBots = explode(PHP_EOL, $blockedBots); goto Ed7cd; B0fbe: D6c96: goto e42ce; dc1c3: if (!(true === empty($this->blockedBots))) { goto E247a; } goto e0257; e0257: $blockedBots = $this->getConfigValue("\142\154\x6f\143\153\145\144\x5f\x62\157\x74\163", "\x62\154\157\143\x6b\145\144\137\142\157\x74\x73"); goto b0707; fb351: return $this->blockedBots; goto bb72b; ff477: $this->blockedBots = $blockedBots; goto B0fbe; f68b9: if (!(false === empty($blockedBots))) { goto D6c96; } goto ff477; Ed7cd: $blockedBots = array_filter(array_map("\164\162\x69\x6d", $blockedBots)); goto f68b9; bb72b: } protected function getMagentoBackendWhitelistedIps() { goto Ab267; f2443: $magentoBackendWhitelistedIps = explode(PHP_EOL, $magentoBackendWhitelistedIps); goto bb044; e049d: $magentoBackendWhitelistedIps = $this->getConfigValue("\155\141\147\x65\x6e\x74\x6f\137\142\141\143\153\x65\156\144", "\x77\150\x69\x74\145\154\151\x73\164\x65\x64\x5f\151\x70\x73"); goto f2443; f9526: Ba4af: goto dedb1; dedb1: Ff249: goto d5269; Ab267: if (!(true === empty($this->magentoBackendWhitelistedIps))) { goto Ff249; } goto e049d; d5269: return $this->magentoBackendWhitelistedIps; goto df1be; bb044: $magentoBackendWhitelistedIps = array_filter(array_map("\x74\x72\151\155", $magentoBackendWhitelistedIps)); goto ccac2; a2811: $this->magentoBackendWhitelistedIps = $magentoBackendWhitelistedIps; goto f9526; ccac2: if (!(false === empty($magentoBackendWhitelistedIps))) { goto Ba4af; } goto a2811; df1be: } protected function isMagentoBackendRestricted() { goto d764e; d764e: $configValue = $this->getConfigValue("\155\141\147\145\x6e\x74\x6f\x5f\142\x61\143\153\x65\x6e\x64", "\151\x73\137\x65\x6e\x61\x62\x6c\145\144"); goto b0567; b0567: $this->isMagentoBackendRestricted = $configValue == self::MAGENTO_BACKEND_RESTRICTION_ENABLED ? true : false; goto Da410; Da410: return $this->isMagentoBackendRestricted; goto C3565; C3565: } protected function getWebAcl() { goto A4706; f9242: d3390: goto Ad2c6; A4706: if (!(true === is_null($this->webAcl))) { goto d3390; } goto e85c0; De96c: $this->webAcl = $awsWaf->getWebAcl($webAclName); goto f9242; Ad2c6: return $this->webAcl; goto e31bc; c7df3: $webAclName = $this->getWebAclName(); goto De96c; e85c0: $awsWaf = $this->getAwsWaf(); goto c7df3; e31bc: } protected function getWebAclName() { goto Fab19; fcfd7: $projectName = ucfirst($this->getProjectName()); goto Ff286; Fab19: if (!(true === is_null($this->webAclName))) { goto D3ec4; } goto fcfd7; Ff286: $this->webAclName = sprintf("\x25\163\55\115\107\124\55\127\145\142\55\101\103\114", $projectName); goto cd2e9; cd2e9: D3ec4: goto E4577; E4577: return $this->webAclName; goto A6a33; A6a33: } protected function getWebAclRuleArrayIndex($webAclRuleName) { goto b239b; bfb3a: goto C854c; goto f6152; Aa8da: $arrayIndex = array_search($webAclRuleName, array_column($webAclRules, "\116\141\x6d\x65")); goto d3503; D8e3a: return $arrayIndex; goto b4b6b; b239b: $webAcl = $this->getWebAcl(); goto ee7da; d3503: if (false === is_null($arrayIndex) && true === isset($webAclRules[$arrayIndex])) { goto e3a9d; } goto C5d3c; C5d3c: throw new \Exception(sprintf("\127\145\142\x20\x41\x43\x4c\40\122\165\154\145\40\42\45\163\x22\x20\156\157\164\40\x66\157\165\156\x64\x2e", $webAclRuleName)); goto bfb3a; b4b6b: C854c: goto ec1a6; ee7da: $webAclRules = $webAcl["\122\165\154\x65\x73"] ?? []; goto Aa8da; f6152: e3a9d: goto D8e3a; ec1a6: } protected function getBackendFrontName() { $backendFrontName = $this->deploymentConfig->get(BackendConfigOptionsList::CONFIG_PATH_BACKEND_FRONTNAME); return $backendFrontName; } protected function getConfigValue($group, $field) { goto D0381; bbd8b: B6a62: goto f3cc9; f1e10: d85b7: goto bbd8b; b69bd: $configValue = trim($configValue); goto f1e10; F7b3f: if (!(true === isset($this->configData["\147\x72\x6f\165\160\163"][$group]["\x66\151\145\154\144\163"][$field]["\x76\x61\154\165\x65"]))) { goto B6a62; } goto a7280; a7280: $configValue = $this->configData["\147\162\x6f\x75\x70\163"][$group]["\146\x69\x65\x6c\144\163"][$field]["\166\141\154\x75\145"]; goto bce0a; D0381: $configValue = ''; goto F7b3f; bce0a: if (!(true === is_string($configValue))) { goto d85b7; } goto b69bd; f3cc9: return $configValue; goto d99de; d99de: } protected function retry(callable $fn, $retries = 2, $delay = 3) { return Retry::retry($fn, $retries, $delay); } }