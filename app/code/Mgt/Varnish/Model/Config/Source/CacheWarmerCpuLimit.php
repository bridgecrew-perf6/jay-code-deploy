<?php
 namespace Mgt\Varnish\Model\Config\Source; class CacheWarmerCpuLimit implements \Magento\Framework\Option\ArrayInterface { public function toOptionArray() { goto F9f24; C72e5: foreach (range(10, 90, 10) as $number) { $optionsArray[] = ["\166\141\x6c\165\x65" => $number, "\154\x61\x62\145\154" => $number]; F6993: } goto Fa90b; Fa90b: B25ac: goto Bea57; Bea57: return $optionsArray; goto f438b; F9f24: $optionsArray = []; goto C72e5; f438b: } public function toArray() { goto e932d; e932d: $optionsArray = []; goto b1182; c2456: A6441: goto cf161; cf161: return $optionsArray; goto E87fb; b1182: foreach (range(10, 90, 10) as $number) { $optionsArray[$number] = $number; B56b2: } goto c2456; E87fb: } }
