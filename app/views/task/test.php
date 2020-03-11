<?php

use Plasticbrain\FlashMessages\FlashMessages;

if (!session_id()) @session_start();

$msg = new FlashMessages();

$msg->info('This is an info message');

$msg->display();