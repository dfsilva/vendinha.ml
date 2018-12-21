<?php

class FlashMessage extends \Phalcon\Flash\Direct {

    public function message($type, $message) {
        $message .= ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        parent::message($type, $message);
    }

}