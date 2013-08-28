<?php

function pre_print( $object, $title = null ) {

	if ( isset( $title ) ) {
		echo "<b>$title</b> <br />";
	}

	echo "<pre>";
	print_r( $object );
	echo "</pre>";

	return;
}

require_once '..\autoload.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\ServiceBus\Models\BrokeredMessage;

$connectionString = "Endpoint=https://olaround.servicebus.windows.net/;SharedSecretIssuer=owner;SharedSecretValue=gHz7yJRlH5/BGQ5N+2NljaSwv7+9m1UCQrV14i7LF6I=";

// Create Service Bus REST proxy.
$serviceBusRestProxy = ServicesBuilder::getInstance()->createServiceBusService($connectionString);

pre_print( $serviceBusRestProxy, "Service Bus Proxy" );

try {

	$messageData = array(

		"pictureId" => 156100,
		"entity" => "user_profile",
		"originalImage" => "fe2045967e99e93b5ee5dbc5653f1e26.jpg",
		"countainerName" => "1f9f0c14199de466e5c1b7e6081d4047",
		"sourceUrl" => "http://api.olaround.me/v2/users/10743/picture",
		"galleryId" => 10741
	);

    // Create message.
    $message = new BrokeredMessage();
    $message->setBody( json_encode( $messageData ) );

    pre_print( $message, "My Message" );

    // Send message.
    $serviceBusRestProxy->sendTopicMessage("olrd-picsys", $message);

    pre_print( true, "Message Sent" );
}
catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/hh780775
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";

    pre_print( $e, "Exception" );
}

?>