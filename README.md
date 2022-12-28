# email-lexoffice
Uploads attachments (pdf invoices) from emails to lexoffice.de

# Description by Client

A website is to be created. The user can register via a form: first step of the form specify e-mail address and verify via this specified e-mail address. After a successful verification, a random e-mail address is assigned to the interested party. Now the customer enters his complete data company name, first name, address, postal code, city as well as if necessary country. He also confirmed that he is a trader (checkbox). After saving, he has the possibility to enter his Lexoffice API Key.

Possibly there is also the possibility of an automatic link see Lexoffice API description this is easier for the customer.

The input of the customer data is directly transmitted to our Lexoffice API and the customer data is created as a customer in our Lexoffice

Now to the function:

The customer deposits his new email address with his suppliers. From now on, the invoices will be sent by email to our email address assigned to the customer. Once received in the mailbox, the script can assign the email address to an API key and upload this invoice to the customer's Lexoffice customer portal.

After each registration I receive an email with the user data.

The registration runs completely automatically. The customer account is fully usable after complete registration. The entered user data is automatically stored in our lexoffice account as a new customer. The customer can cancel his contract online. And also change his settings also, if for example the API Key has changed .
If it is possible, the system should show the customer that there is a connection to his lexoffice account. Possibly a green tick.

I will create the invoices manually in Lexoffice at the beginning (the customer data was then already transmitted).
