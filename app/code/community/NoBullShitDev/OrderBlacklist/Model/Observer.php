<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension
 * to newer versions in the future.
 *
 *
 * @category   NoBullShitDev
 * @package    NoBullShitDev_OrderBlacklist
 * @author     Copyright (c) 2019 Alberto Segura https://nobullshit.dev/
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class NoBullShitDev_OrderBlacklist_Model_Observer {
  /**
  * Validate customer email values.
  *
  */
  public function checkFullEmail (Varien_Event_Observer $observer){
    #Mage::log('Flagged Email List: START'.print_r($params,1), null, 'blacklist.log', true);
    $orderIds = $observer->getData('order_ids');
    foreach($orderIds as $orderId):
      $orderObject = Mage::getModel('sales/order')->load($orderId);
      $emailList = Mage::getStoreConfig('customer/create_account/blocked_emails_list');

      #Mage::log('-- OrderId: '.$orderId, null, 'spam.log', true);
      #Mage::log('-- Customer Email: '.$orderObject->getCustomerEmail(), null, 'blacklist.log', true);

      if($emailList):
        $emailList = str_replace(" ","",$emailList);
        $emailList = explode(",",$emailList);
        #Mage::log('-- Email List: '.json_encode($emailList), null, 'blacklist.log', true);

        if (in_array($orderObject->getCustomerEmail(), $emailList)):
          #Mage::log('This order will be holded - '. $orderObject->getRealOrderId(), null, 'blacklist.log', true);
          $orderObject->hold();
          $orderObject->setState('holded');
          $orderObject->setStatus('holded');
          $orderObject->addStatusHistoryComment('Warning : This email was flagged by Customer Service and should not be shipped.');
          $orderObject->save();
          #Mage::log('Order holded - Finish - '.$orderObject->getRealOrderId(), null, 'blacklist.log', true);
        endif;
      endif;
    endforeach;
    #Mage::log('Flagged Email List: END'.print_r($params,1), null, 'blacklist.log', true);
  }
}