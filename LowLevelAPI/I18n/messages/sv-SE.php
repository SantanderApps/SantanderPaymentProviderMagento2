<?php

/**
 * @file sv-SE.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 1.0.0
 * @created 2015-aug-04
 */

return array(
    // General
    'Santander Consumer Bank' => 'Santander Consumer Bank',
    '<strong>Version:</strong> {versionNumber}' => '<strong>Version:</strong> {versionNumber}',
    
    // Check requirements
    'PHP version (5.3.0 or greater)' => 'PHP version (5.3.0 eller senare)',
    'valid ({phpVersion})' => 'giltig ({phpVersion})',
    'invalid ({phpVersion})' => 'ogiltig ({phpVersion})',
    'PHP SoapClient class' => 'PHP SoapClient klass',
    'exists' => 'existerar',
    'not exist' => 'existerar ej',
    'cURL' => 'cURL',
    'enabled' => 'tillgänglig',
    'not enabled' => 'otillgänglig',
    
    // Module Configuration
    'Available Markets' => 'Tillgängliga marknader',
    'Sweden' => 'Sverige',
    'Denmark' => 'Danmark',
    'Norway' => 'Norge',
    'Finland' => 'Finland',
    'Great Britain' => 'Storbritannien',
    'Test connection with the web service' => 'Test connection with the web service',
    'Result' => 'Resultat',
    'Success! Connected to {host}' => 'Ok! Uppkopplad mot {host}',
    '<p>Error! Failed to connect to {host}.<br>It may be due to some of the following reasons:</p><ul><li>The server is not available at the moment.</li><li>Your server do not have an outbound Internet connection.</li></ul>' => '<p>Fel! Misslyckades att koppla upp mot {host}.<br>Det kan bero på en eller flera av följande orsaker:</p><ul><li>Servern är inte tillgänglig för tillfället.</li><li>Din server har ingen utgående internet-uppkoppling.</li></ul>',
    'Success! Connected to {host}' => 'Ok! Uppkopplad mot {host}',
    '<p>Error! Failed to connect to {host}.<br>It may be due to some of the following reasons:</p><ul><li>The server is not available at the moment.</li><li>Your server do not have an outbound Internet connection.</li></ul>' => '<p>Fel! Misslyckades att koppla upp mot {host}.<br>Det kan bero på en eller flera av följande orsaker:</p><ul><li>Servern är inte tillgänglig för tillfället.</li><li>Din server har ingen utgående internet-uppkoppling.</li></ul>',
    'Verify user details' => 'Verifiera användaruppgifter',
    '<strong>Note:</strong> Only available when "Module Environment" is set to "{statusLive}".' => '<strong>Obs:</strong> Endast tillgänglig när "Module Environment" är satt till "{statusLive}".',
    'Success! The test connection with the web service works great. Your account details is correct.' => 'Ok! Testkontakten med webbtjänsten fungerar bra. Dina kontouppgifter är korrekta.',
    'Error! The test connection with the web service failed. It seems like your account details are incorrect. Make sure that they are correct, if it still doesn\'t work please {contactUs}.' => 'Fel! Misslyckades att test kontakt med webbtjänsten. Det verkar som att dina kontouppgifter är felaktiga. Kontrollera dem, om det fortfarande är fel <a href="http://santander.consid.se/site/contact?department=1" target="_blank">kontakta supporten</a>.',
    'Enable / Disable' => 'Aktivera / Inaktivera',
    'Enable Santander Consumer Bank' => 'Aktivera Santander Consumer Bank',
    'Store ID' => 'Store ID',
    'Type the store ID given to you by Santander Consumer Bank.' => 'Ange det "store ID" som du har fått av Santander Consumer Bank.',
    'Username' => 'Användarnamn',
    'Type the username given to you by Santander Consumer Bank.' => 'Ange det användarnamn som du har fått av Santander Consumer Bank.',
    'Password' => 'Lösenord',
    'Type the password given to you by Santander Consumer Bank.' => 'Ange det lösenord som du har fått av Santander Consumer Bank.',
    'Merchant ID' => 'Merchant ID',
    'Type the merchant ID given to you by your payment service provider.' => 'Ange det "merchant ID" som du har fått av din  given to you by your betaltjänstleverantör.',
    'Set Module Environment' => 'Sätt modul-läge',
    'Enable sandbox/test environment' => 'Aktivera sandbox/test-läge',
    'Version' => 'Version',
    'Test Connections' => 'Testa kontakt med webbtjänst',
    '<strong>Note:</strong> Only available when "Set Module Environment" is unchecked.' => '<strong>Obs:</strong> Endast tillgänglig då "Sätt module-läge" är urmarkerad.',
    'Support Logs' => 'Logga information',
	'For a better support experience Santander´s plugin logs all connections to and from Santander´s web services. You have the option to opt-out of these logs being automatically collected by Santander and can therefore choose to manually send in a log file when contacting Santander support services. Log files are located: {logdir}.' => 'Santanders plugin loggar alla anslutningar till och från Santanders webbtjänster. Du kan välja bort att dessa loggar automatiskt samlas in av Santander och kan därmed välja att manuellt skicka loggfil när du kontaktar Santanders kundtjänst. Loggfiler sparas i: {logdir}',
    "New order status" => "Status vid ny order",
    "Status of order when order created, but before it has been processed by Santander Consumer Bank" => "Status på order när order skapas, men innan den har behandlats av Santander Consumer Bank",
    
    // Order Comments
    'Santander Consumer Bank order number: {orderNumber}' => 'Santander Consumer Bank ordernummer: {orderNumber}',
    'Authorization receipt to be used when capturing the amount from your payment service provider: {authorizationCode}' => 'Auktorisationskvitto som skall användas vid transaktion hos din betalleverantör: {authorizationCode}',
    'Payment could not be completed. Result code: {resultCode}.' => 'Betalningen kunde inte slutföras. Resultatskod: {resultCode}.',
    
    // Log mail
    'Log file from {system}' => 'Logg-fil från {system}',
    'Log file from {yesterday} for {system} is attached in this e-mail.' => 'Logg-fil från {yesterday} för {system} finns bifogat i detta mail.',
    
    // Checkout
    'Proceed to Santander' => 'Fortsätt till Santander',
    'The customer was redirected from Santander Consumer Bank\'s web site back to the shop.' => 'Kunden skickades från Santander Consumer Banks webbsida tillbaka till butiken.',
    'You canceled the payment at the Santander Consumer Bank web site.' => 'Du abvröt betalningen på Santander Consumer Banks webbsida.',
    'Payment could not be completed.' => 'Betalningen kunde inte slutföras.',
    'Message displayed to customer' => 'Meddelande som visas för kunden',
    
    // Checkout error messages
    'A technical problem occurred when the order was processed. The order has been canceled.' => 'Ett tekniskt fel inträffande när ordern behandlades. Ordern har avbrytits.',
    'An error occured while communicating with Santander Consumer Bank. Try again or choose another payment method.' => 'Ett fel inträffade vid kommunikationen med Santander Consumer Bank. Försök igen eller välj ett annat betalalternativ.',
    'RETURN_CODE_DESCRIPTION_0' => '',
    'RETURN_CODE_DESCRIPTION_105' => 'Ett oväntat tekniskt fel har inträffat.',
    'RETURN_CODE_DESCRIPTION_110' => 'Ett oväntat tekniskt fel har inträffat.',
    'RETURN_CODE_DESCRIPTION_200' => 'Du har valt att avbryta ansökan (kod 200)',
    'RETURN_CODE_DESCRIPTION_201' => 'Du har valt att avbryta ansökan (kod 201)',
    'RETURN_CODE_DESCRIPTION_202' => 'Du har valt att avbryta ansökan (kod 202)',
    'RETURN_CODE_DESCRIPTION_203' => 'Du har valt att avbryta ansökan (kod 203)',
    'RETURN_CODE_DESCRIPTION_204' => 'Du har valt att avbryta ansökan (kod 204)',
    'RETURN_CODE_DESCRIPTION_207' => 'Du har valt att avbryta ansökan (kod 207)',
    'RETURN_CODE_DESCRIPTION_210' => 'Du har redan en påbörjad ansökan. Ring Santander Consumer Bank om du vill slutföra ansökan (kod 210)',
    'RETURN_CODE_DESCRIPTION_211' => 'Ett oväntat fel har inträffat. Vänligen meddela butiksinnehavaren (kod 211)',
    'RETURN_CODE_DESCRIPTION_300' => 'Ett oväntat fel har inträffat. Vänligen meddela butiksinnehavaren (kod 300)',
    'RETURN_CODE_DESCRIPTION_909' => 'Ett oväntat tekniskt fel har inträffat. Vänligen meddela butiksinnehavaren (felkod 909)',
    'RETURN_CODE_DESCRIPTION_310' => 'Ett oväntat fel har inträffat. Vänligen meddela butiksinnehavaren (kod 310)',
);