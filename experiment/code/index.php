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
    // Create message.
    $message = new BrokeredMessage();
    $message->setBody("my message");

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