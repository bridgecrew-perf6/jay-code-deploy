<?php
 namespace Mgt\Varnish\Controller\Adminhtml\Purge; class Action extends \Magento\Backend\App\Action { public function execute() { goto E725d; a3635: $resultRedirect = $this->resultRedirectFactory->create(); goto f3e25; Ba71a: $storeId = (int) $request->getParam("\x73\164\x6f\162\x65\137\151\144"); goto Fd6c5; f3e25: return $resultRedirect->setPath("\x61\x64\155\151\156\x68\164\x6d\154\57\x63\x61\143\x68\145\x2f\x69\156\144\x65\170"); goto ff0ab; E725d: $request = $this->getRequest(); goto Ba71a; Fd6c5: try { goto e49d8; e8f23: $this->messageManager->addSuccessMessage(sprintf("\x54\150\x65\40\x53\x74\x6f\x72\x65\x20\x22\x25\163\42\40\x68\x61\x73\x20\x62\145\x65\156\40\x70\165\x72\x67\x65\144\40\x66\162\x6f\155\40\126\x61\162\156\x69\163\150\x20\103\141\143\x68\x65", $storeBaseUrl)); goto Fed2b; a00c7: $storeManager = $this->_objectManager->get("\x5c\115\141\x67\145\156\164\157\x5c\123\164\x6f\162\145\x5c\x4d\x6f\x64\145\154\x5c\x53\x74\x6f\x72\x65\115\x61\x6e\141\147\145\162\x49\x6e\x74\145\162\146\x61\x63\x65"); goto d0962; a8918: $storeBaseUrl = $store->getBaseUrl(); goto e8f23; d0962: $store = $storeManager->getStore($storeId); goto D7b59; D7b59: $cachePurger->purgeStoreRequest($store); goto a8918; e49d8: $cachePurger = $this->_objectManager->get("\134\x4d\141\147\145\x6e\164\x6f\x5c\x43\x61\x63\150\x65\x49\156\x76\x61\154\x69\x64\141\164\x65\x5c\115\157\144\145\x6c\x5c\120\x75\x72\147\145\x43\141\143\150\145"); goto a00c7; Fed2b: } catch (\Exception $e) { $errorMessage = $e->getMessage(); $this->messageManager->addErrorMessage($errorMessage); } goto a3635; ff0ab: } }
