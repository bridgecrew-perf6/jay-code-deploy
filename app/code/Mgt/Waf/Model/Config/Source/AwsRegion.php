<?php
 namespace Mgt\Waf\Model\Config\Source; class AwsRegion implements \Magento\Framework\Option\ArrayInterface { protected static $awsRegions = ["\x75\x73\55\145\141\x73\164\55\x31" => "\125\123\40\x45\141\163\x74\40\50\116\x2e\x20\126\x69\162\147\x69\x6e\x69\x61\51", "\x75\x73\x2d\x65\x61\163\x74\55\x32" => "\125\123\x20\x45\x61\x73\164\x20\x28\x4f\x68\151\157\51", "\165\x73\55\167\145\163\164\x2d\62" => "\x55\x53\x20\127\x65\x73\x74\40\x28\117\162\145\147\x6f\156\x29", "\165\x73\x2d\167\145\163\x74\x2d\x31" => "\125\x53\40\x57\x65\163\x74\x20\x28\116\x2e\40\103\141\154\x69\146\x6f\162\x6e\151\141\x29", "\x63\x61\x2d\143\145\156\x74\x72\141\154\55\x31" => "\x43\141\156\x61\x64\x61\x20\x28\x43\x65\x6e\x74\x72\141\x6c\x29", "\x65\165\x2d\x77\x65\x73\x74\55\x31" => "\x45\125\x20\x28\x49\162\x65\x6c\141\x6e\x64\51", "\x65\x75\x2d\143\145\x6e\x74\162\x61\154\55\x31" => "\105\x55\x20\50\106\162\141\x6e\x6b\x66\x75\162\x74\x29", "\x65\x75\x2d\x77\x65\x73\x74\55\x32" => "\x45\125\40\50\x4c\x6f\x6e\144\x6f\x6e\51", "\x65\165\x2d\x77\145\x73\164\55\x33" => "\105\125\x20\x28\x50\x61\162\x69\x73\51", "\x65\165\x2d\156\157\162\164\x68\55\61" => "\105\125\40\50\123\x74\x6f\x63\x6b\150\x6f\154\x6d\x29", "\155\145\55\163\x6f\165\x74\x68\x2d\61" => "\x4d\151\144\x64\x6c\x65\x20\x45\141\x73\x74\x20\50\x42\x61\150\162\141\x69\156\x29", "\141\160\x2d\163\x6f\x75\164\150\x65\x61\x73\164\x2d\61" => "\x41\x73\151\x61\40\120\141\x63\x69\x66\151\x63\x20\50\123\x69\156\x67\x61\x70\x6f\x72\145\x29", "\141\160\55\156\157\x72\x74\150\145\141\163\x74\x2d\61" => "\x41\x73\151\141\x20\120\x61\x63\151\x66\151\x63\x20\x28\124\x6f\x79\153\157\x29", "\141\160\55\x65\141\x73\x74\55\61" => "\101\x73\151\x61\x20\x50\x61\x63\151\146\x69\x63\x20\50\110\x6f\156\147\40\113\157\156\147\x29", "\141\x70\x2d\x73\157\165\x74\150\x65\x61\x73\x74\x2d\62" => "\x41\163\x69\x61\x20\120\x61\143\151\146\x69\143\40\x28\123\171\144\156\x65\x79\51", "\141\x70\x2d\156\157\162\x74\x68\x65\141\x73\x74\55\x32" => "\101\163\x69\141\x20\120\x61\x63\x69\x66\151\x63\40\50\123\145\x6f\165\x6c\x29", "\x61\160\x2d\x73\157\165\x74\150\x2d\x31" => "\x41\x73\151\141\40\120\x61\x63\x69\146\151\x63\x20\x28\115\165\x6d\142\x61\151\51", "\x73\x61\x2d\x65\141\163\x74\x2d\x31" => "\x53\x6f\165\x74\150\40\101\x6d\x65\162\151\143\141\x20\x28\x53\141\157\x20\x50\x61\165\x6c\157\x29"]; public function toOptionArray() { goto A6c00; A6c00: $optionArray = []; goto ff8f2; ff8f2: foreach (self::$awsRegions as $awsRegion => $awsRegionName) { $optionArray[] = ["\x76\x61\154\165\145" => $awsRegion, "\x6c\141\x62\x65\154" => $awsRegionName]; a80bf: } goto A1d03; A1d03: Ca729: goto ec908; ec908: return $optionArray; goto E6572; E6572: } public function toArray() { goto D2d51; d9f29: E7340: goto ade0e; e966f: foreach (self::$awsRegions as $awsRegion => $awsRegionName) { $toArray[$awsRegion] = $awsRegionName; b3e89: } goto d9f29; D2d51: $toArray = []; goto e966f; ade0e: return $toArray; goto e9148; e9148: } }
