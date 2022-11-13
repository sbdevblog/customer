<?php
/**
 * @copyright Copyright (c) sbdevblog (https://www.sbdevblog.com)
 */
 
namespace SbDevBlog\Customer\Plugin;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Http\Context;

class CustomerSessionContext
{
    /**
     * @var Session
     */
    protected Session $customerSession;

    /**
     * @var Context
     */
    protected Context $httpContext;

    /**
     * Constructor
     *
     * @param Session $customerSession
     * @param Context $httpContext
     */
    public function __construct(
        Session $customerSession,
        Context $httpContext
    ) {
        $this->customerSession = $customerSession;
        $this->httpContext = $httpContext;
    }

    /**
     * Set Customer Session while caching
     *
     * @param \Magento\Framework\App\ActionInterface $subject
     * @param \Closure $proceed
     * @param \Magento\Framework\App\RequestInterface $request
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function aroundDispatch(
        \Magento\Framework\App\ActionInterface $subject,
        \Closure $proceed,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->httpContext->setValue(
            'customer_id',
            $this->customerSession->getCustomerId(),
            false
        );

        $this->httpContext->setValue(
            'customer_name',
            $this->customerSession->getCustomer()->getName(),
            false
        );

        $this->httpContext->setValue(
            'customer_email',
            $this->customerSession->getCustomer()->getEmail(),
            false
        );

        return $proceed($request);
    }
}
