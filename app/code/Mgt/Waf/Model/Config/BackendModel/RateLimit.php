<?php
 namespace Mgt\Waf\Model\Config\BackendModel; use Mgt\Waf\Model\Config\BackendModel\Value as ConfigValue; use Mgt\Waf\Model\Aws\Waf as AwsWaf; class RateLimit extends ConfigValue { protected function _afterLoad() { goto ba809; d33ed: $projectName = $this->getProjectName(); goto C132a; Fd78d: ec3b2: goto B306a; fce68: c9acf: goto Ed3c1; c249c: $awsWaf = new AwsWaf($awsAccessKey, $awsSecretAccessKey, $awsRegion, $projectName); goto de060; A2ccb: if (true === isset($sessionConfigData["\147\x72\x6f\x75\160\x73"]["\162\141\164\x65\x5f\x6c\151\155\151\x74"]["\x66\x69\x65\154\144\x73"]["\x72\141\x74\145\137\154\x69\x6d\151\x74"]["\x76\141\154\165\x65"])) { goto c9acf; } goto f5010; Ad4ad: $webAclName = $this->getWebAclName(); goto c249c; f5010: $awsAccessKey = $this->getAwsAccessKey(); goto d33ed; C95f4: $value = (string) $this->getValue(); goto A2ccb; de060: $value = $awsWaf->getRateLimit($webAclName); goto Fd78d; Ed3c1: $value = $sessionConfigData["\147\x72\157\x75\160\163"]["\162\x61\x74\x65\137\154\151\x6d\x69\x74"]["\146\x69\145\x6c\144\163"]["\x72\141\164\x65\x5f\x6c\151\x6d\x69\x74"]["\166\141\x6c\165\x65"]; goto dd5ca; B306a: goto aa4f9; goto fce68; E8bbf: $awsSecretAccessKey = $this->getAwsSecretAccessKey(); goto aaedd; C132a: if (!(false === empty($awsAccessKey) && false === empty($projectName))) { goto ec3b2; } goto E8bbf; dd5ca: aa4f9: goto Fd287; Fd287: $this->setValue($value); goto B2eb3; aaedd: $awsRegion = $this->getAwsRegion(); goto Ad4ad; ba809: $sessionConfigData = $this->getSessionConfigData(); goto C95f4; B2eb3: } }