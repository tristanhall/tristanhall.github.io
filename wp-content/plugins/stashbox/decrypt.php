<?php

require_once(__DIR__.'/vendor/autoload.php');

$key = 'N0EvghgEUK4REo7myRsF7B2o88pR6sni';
$crypter = new \Illuminate\Encryption\Encrypter($key);

$comments = json_decode(file_get_contents(__DIR__.'/comments.json'));

foreach ($comments->data as $comment) {
    $cText = $crypter->decrypt($comment->comment_content);
    echo $cText . "\n\n";
}