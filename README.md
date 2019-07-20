# magento1-hold-orders-by-email
Sometimes, we want to prevent certain people (fraudsters) from ordering in our magento website.
This module allows you to set a list of emails and hold the orders from those in the list.

You will probably tell me: Hey, but they (fraudsters) can still place orders?

Well yes, but many shipping options only export orders in 'Processing'. 
By holding the orders, we can prevent them getting exported and/or shipped.
Useful if you're dealing with timeconsuming chargebacks. Quite common on international PayPal orders. 

You can save time and money by not dispatching/shipping the order. Just refund/cancel the order and keep selling.

To set the list, you can do that on:
System - Configuration - Customer - Customer Configuration
Use a comma "," as a delimeter when more than 1 email address.
