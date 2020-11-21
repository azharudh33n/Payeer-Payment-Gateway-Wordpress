# Payeer Payment Gateway Wordpress Plugin 

tested on Wordpress 5.5, Woocommerce 4.4



Merchant URL — the default way to pay //payeer.com/merchant/ (change only if an information notice from payeer.com about the change in payment URL) 
Merchant ID — id of your store in the system payeer.com (you can learn in a private office) 
Secret key – the secret key of your store in the system payeer.com (you specify it yourself) 
Payment description — additional comment if you pay in Payeer
Path to logfile — specify the path to the file where to write the information on all payments via Payeer (if field is empty, the entry is not happening) 
You can specify a list of trusted IP addresses of servers separated by commas. You can also specify a mask instead of an IP address. If the field is left empty, then checking for trusted IP addresses is not performed. 

For example: 
	192.168.71.87, 192.165.83.17, 192.178.34.15
Or 	192.*.71.87, 192.165.83.*, 192.*.34.15
Or 	*.*.*.* - available to all IP addresses 

Enter your email address to receive notices in the event of a payment error. The letter will state the reason and basic information about the payment. 
Enter the URL address in the “account Payeer → API → Merchant settings”

<br>
Success URL: 
https://*****/?wc-api=wc_payeer&payeer=calltrue
<br>
 Fail URL: 
https://*****/?wcapi=wc_payeer&payeer=callfalse
<br>
 Status URL: 
https://*****/?wc-api=wc_payeer&payeer=result
<br>
Where ***** is your domain.

