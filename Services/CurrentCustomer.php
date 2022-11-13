<?php
namespace SbDevBlog\Customer\Services;

use Magento\Customer\Model\Session;

class CurrentCustomer
{
    /**
     * @var Session
     */
    protected Session $customerSession;

    /**
     * Constructor
     *
     * @param Session $customerSession
     */
    public function __construct(
        Session $customerSession,
    ) {
        $this->customerSession = $customerSession;
    }

    /**
     * Get Current Customer Id
     *
     * @return int
     */
    public function getCurrentCustomerId() {
        $this->customerSession->getCustomerId(),
    }

    /**
     * Check Whether Customer is logged in
     *
     * @return boolean
     */
    public function isLoggedInCustomer()
    {
      return $this->customerSession->isLoggedIn()
    }
}
