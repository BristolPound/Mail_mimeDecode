--TEST--
Bug #30     Mail_Mime: _encodeHeaders is not RFC-2047 compliant. (ISO-8859-1)
--SKIPIF--
--FILE--
<?php
error_reporting(E_ALL); // ignore E_STRICT
include("Mail/mime.php");
include("Mail/mimeDecode.php");
$encoder = new Mail_mime();
$decoder = new Mail_mimeDecode("");

$input[] = "Just a simple test";
$input[] = "_this=?Q?U:I:T:E_a_test?=";
$input[] = "_=?S�per?=_";
$input[] = "_ = ? S�per ? = _";
$input[] = "S�per gr�se tolle gr��e?! Fur mir!?";
$input[] = "S�per = gr�se tolle gr��e von mir";
$input[] = "TEST  S�per gr�se tolle gr��e von mir S�per gr�se tolle gr��e von mir S�per gr�se tolle gr��e von mir!!!?";
$input[] = '"German Umlauts ���"';

$encoded = $encoder->_encodeHeaders($input, array('head_encoding' => 'quoted-printable'));
$decoded = array();

foreach ($encoded as $encodedString){
    $decoded[] = $decoder->_decodeHeader($encodedString);
}
if ($input === $decoded){
    print("MATCH");
}else{
    print("FAIL");
}
?>
--EXPECT--
MATCH
