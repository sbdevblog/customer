<?php
/**
 * @copyright Copyright (c) sbdevblog https://www.sbdevblog.com)
 */

namespace SbDevBlog\Customer\Services;

use Magento\Framework\App\Http\Context as HttpContext;

class CurrentCustomerOnCache
{
    /**
     * @var HttpContext
     */
    protected HttpContext $httpContext;

    public function __construct(
        HttpContext $httpContext
    ){
        $this->httpContext = $httpContext;
    }

    /**
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->httpContext->getValue("customer_id");
    }

    /**
     * @return string|null
     */
    public function getCustomerEmail()
    {
        return $this->httpContext->getValue("customer_email");
    }

    /**
     * @return string|null
     */
    public function getCustomerName()
    {
        return $this->httpContext->getValue("customer_name");
    }
}
