<?php
declare (strict_types = 1);

namespace pidan\response;

use pidan\Response;

/**
 * Html Response
 */
class Html extends Response
{
    /**
     * 输出type
     * @var string
     */
    protected $contentType = 'text/html';

    public function __construct($data = '', int $code = 200)
    {
        $this->init($data, $code);
    }
}
