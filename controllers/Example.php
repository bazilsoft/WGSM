<?php
require __DIR__ . '/SourceQuery/bootstrap.php';

use SourceQuery\SourceQuery;

// For the sake of this example
Header( 'Content-Type: text/plain' );
Header( 'X-Content-Type-Options: nosniff' );

// Edit this ->
define( 'SQ_SERVER_ADDR', '185.189.255.19' );
define( 'SQ_SERVER_PORT', 29070 );
define( 'SQ_TIMEOUT',     5 );
define( 'SQ_ENGINE',      SourceQuery::SOURCE );
// Edit this <-

$Query = new SourceQuery( );

try
{
	$Query->Connect( SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE );

	$Query->SetRconPassword( 'ccie82CGk90' );

	$an =  $Query->Rcon( 'ServerChat Admin: Hi Ivan - man !!!' );
	$an =  $Query->Rcon( 'GetChat' );
	//echo print_r( $an);
	//echo "=== \n";
//	var_dump( $Query->Rcon( 'ServerChat Admin: Hi ppl !!~!' ) );

	echo "=== \n";
	//$an =  $Query->Rcon( 'GetChat' );
	echo print_r( $an);
	echo "=== \n";
}
catch( Exception $e )
{
	echo $e->getMessage( );
}
finally
{
	$Query->Disconnect( );
}
