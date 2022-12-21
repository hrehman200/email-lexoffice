<?php

use Laminas\Mail\Storage;

require_once 'vendor/autoload.php';

define('IMAP_HOST', '');
define('IMAP_USERNAME', '');
define('IMAP_PASS', '');
define('LEXOFFICE_API_TOKEN', '');
define('ATTACHMENT_FOLDER', __DIR__ . '/attachments/');

$mailbox = new \Pb\Imap\Mailbox(
    IMAP_HOST,
    IMAP_USERNAME,
    IMAP_PASS,
    'INBOX',
    __DIR__ . '/attachments',
    [
        \Pb\Imap\Mailbox::OPT_DEBUG_MODE => true
    ]
);
$messageIds = $mailbox->search('UNSEEN');

if(count($messageIds) == 0) {
    echo "No emails found \n";
    exit();
}

foreach ($messageIds as $messageId) {
    $message = $mailbox->getMessage($messageId);

    // print_r($message);
    // print_r($message->getAttachments());

    $attachments = $message->getAttachments();
    foreach($attachments as $attachment) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.lexoffice.io./v1/files',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('file' => new CURLFILE(ATTACHMENT_FOLDER . $attachment->filepath), 'type' => 'voucher'),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . LEXOFFICE_API_TOKEN,
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

        $response = json_decode($response, true);
        if(array_key_exists('id', $response)) {
            unlink(ATTACHMENT_FOLDER . $attachment->filepath);

            try {
                $mailbox->addFlags([$messageId], [Storage::FLAG_DELETED]);
                $mailbox->expunge();
            } catch (Exception $e) {
                echo $e->getMessage() . "\n";
            }
        }
    }    
}

