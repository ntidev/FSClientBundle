<?php

namespace NTI\FSClientBundle\Model;


use JMS\Serializer\Annotation as Serializer;

class Token {
    /**
     * @var string
     * @Serializer\Type("string")
     */
    public $token;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    public $file_uuid;

    /**
     * @var string
     * @Serializer\Type("integer")
     */
    public $expires;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    public $application;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    public $download_url;
}