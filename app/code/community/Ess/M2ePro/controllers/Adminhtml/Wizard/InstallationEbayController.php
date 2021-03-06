<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  M2E LTD
 * @license    Commercial use is forbidden
 */

use Ess_M2ePro_Model_Ebay_Account as Account;

class Ess_M2ePro_Adminhtml_Wizard_InstallationEbayController
    extends Ess_M2ePro_Controller_Adminhtml_Ebay_WizardController
{
    protected $_sessionKey = 'ebay_listing_product_add';

    //########################################

    protected function _initAction()
    {
        $result = parent::_initAction();

        $this->getLayout()->getBlock('head')
             ->addJs('M2ePro/Wizard/InstallationEbay.js');

        return $result;
    }

    protected function getNick()
    {
        return Ess_M2ePro_Helper_View_Ebay::WIZARD_INSTALLATION_NICK;
    }

    //########################################

    public function beforeTokenAction()
    {
        $accountMode = $this->getRequest()->getParam('mode');

        if ($accountMode === null) {
            return $this->getResponse()->setBody(
                Mage::helper('M2ePro')->jsonEncode(
                    array('message' => Mage::helper('M2ePro')->__('Account type have not been specified.'))
                )
            );
        }

        try {
            $backUrl = $this->getUrl('*/*/afterToken', array('mode' => $accountMode));

            $dispatcherObject = Mage::getModel('M2ePro/Ebay_Connector_Dispatcher');
            $connectorObj = $dispatcherObject->getVirtualConnector(
                'account',
                'get',
                'grandAccessUrl',
                array('back_url' => $backUrl, 'mode' => $accountMode),
                null,
                null,
                null
            );

            $dispatcherObject->process($connectorObj);
            $response = $connectorObj->getResponseData();
        } catch (Exception $exception) {
            Mage::helper('M2ePro/Module_Exception')->process($exception);

            Mage::getModel('M2ePro/Servicing_Dispatcher')->processTask(
                Mage::getModel('M2ePro/Servicing_Task_License')->getPublicNick()
            );

            $error = 'The eBay token obtaining is currently unavailable.<br/>Reason: %error_message%';

            if (!Mage::helper('M2ePro/Module_License')->isValidDomain() ||
                !Mage::helper('M2ePro/Module_License')->isValidIp()) {
                $error .= '</br>Go to the <a href="%url%" target="_blank">License Page</a>.';
                $error = Mage::helper('M2ePro')->__(
                    $error,
                    $exception->getMessage(),
                    Mage::helper('M2ePro/View_Configuration')->getLicenseUrl(array('wizard' => 1))
                );
            } else {
                $error = Mage::helper('M2ePro')->__($error, $exception->getMessage());
            }

            return $this->getResponse()->setBody(Mage::helper('M2ePro')->jsonEncode(array('message' => $error)));
        }

        if (!$response || !isset($response['url'], $response['session_id'])) {
            $error = Mage::helper('M2ePro')->__(
                'The eBay token obtaining is currently unavailable. Please try again later.'
            );

            return $this->getResponse()->setBody(Mage::helper('M2ePro')->jsonEncode(array('message' => $error)));
        }

        Mage::helper('M2ePro/Data_Session')->setValue('token_session_id', $response['session_id']);

        return $this->getResponse()->setBody(Mage::helper('M2ePro')->jsonEncode(array('url' => $response['url'])));
    }

    public function afterTokenAction()
    {
        $tokenSessionId = Mage::helper('M2ePro/Data_Session')->getValue('token_session_id', true);

        if (!$tokenSessionId) {
            $this->_getSession()->addError(Mage::helper('M2ePro')->__('Token is not defined'));

            return $this->_redirect('*/*/installation');
        }

        $accountMode = $this->getRequest()->getParam('mode');

        $requestParams = array(
            'mode'          => $accountMode,
            'token_session' => $tokenSessionId
        );

        $dispatcherObject = Mage::getModel('M2ePro/Ebay_Connector_Dispatcher');
        $connectorObj = $dispatcherObject->getVirtualConnector(
            'account',
            'add',
            'entity',
            $requestParams,
            null,
            null,
            null
        );

        $dispatcherObject->process($connectorObj);
        $response = array_filter($connectorObj->getResponseData());

        if (empty($response)) {
            $this->_getSession()->addError(Mage::helper('M2ePro')->__('Account Add Entity failed.'));
            return $this->_redirect('*/*/installation');
        }

        if ($accountMode == 'sandbox') {
            $accountMode = Account::MODE_SANDBOX;
        } else {
            $accountMode = Account::MODE_PRODUCTION;
        }

        $data = array_merge(
            $this->getEbayAccountDefaultSettings(),
            array(
                'title'              => $response['info']['UserID'],
                'user_id'            => $response['info']['UserID'],
                'mode'               => $accountMode,
                'info'               => Mage::helper('M2ePro')->jsonEncode($response['info']),
                'server_hash'        => $response['hash'],
                'token_session'      => $tokenSessionId,
                'token_expired_date' => $response['token_expired_date']
            )
        );

        /** @var Ess_M2ePro_Model_Account $accountModel */
        $accountModel = Mage::helper('M2ePro/Component_Ebay')->getModel('Account');
        Mage::getModel('M2ePro/Ebay_Account_Builder')->build($accountModel, $data);
        $accountModel->getChildObject()->updateEbayStoreInfo();

        $this->setStep($this->getNextStep());

        return $this->_redirect('*/*/installation');
    }

    public function listingAccountAction()
    {
        return $this->_redirect('*/adminhtml_ebay_listing_create', array('step' => 1,'wizard' => true,'clear' => true));
    }

    public function listingGeneralAction()
    {
        return $this->_redirect('*/adminhtml_ebay_listing_create', array('step' => 2, 'wizard' => true));
    }

    public function listingSellingAction()
    {
        return $this->_redirect('*/adminhtml_ebay_listing_create', array('step' => 3, 'wizard' => true));
    }

    public function listingSynchronizationAction()
    {
        return $this->_redirect('*/adminhtml_ebay_listing_create', array('step' => 4, 'wizard' => true));
    }

    public function sourceModeAction()
    {
        $listingId = Mage::helper('M2ePro/Component_Ebay')->getCollection('Listing')->getLastItem()->getId();

        return $this->_redirect(
            '*/adminhtml_ebay_listing_productAdd/sourceMode',
            array(
                'wizard' => true,
                'listing_id' => $listingId,
                'listing_creation' => true
            )
        );
    }

    public function productSelectionAction()
    {
        $listingId = Mage::helper('M2ePro/Component_Ebay')->getCollection('Listing')->getLastItem()->getId();

        $productAddSessionData = Mage::helper('M2ePro/Data_Session')->getValue($this->_sessionKey . $listingId);

        return $this->_redirect(
            '*/adminhtml_ebay_listing_productAdd',
            array(
                'clear'            => true,
                'step'             => 1,
                'wizard'           => true,
                'listing_id'       => $listingId,
                'listing_creation' => true,
                'source'           => isset($productAddSessionData['source']) ? $productAddSessionData['source'] : null
            )
        );
    }

    public function productSettingsAction()
    {
        $listingId = Mage::helper('M2ePro/Component_Ebay')->getCollection('Listing')->getLastItem()->getId();

        return $this->_redirect(
            '*/adminhtml_ebay_listing_productAdd',
            array(
                'step'             => 2,
                'wizard'           => true,
                'listing_id'       => $listingId,
                'listing_creation' => true,
            )
        );
    }

    public function categoryStepOneAction()
    {
        $listingId = Mage::helper('M2ePro/Component_Ebay')->getCollection('Listing')->getLastItem()->getId();

        return $this->_redirect(
            '*/adminhtml_ebay_listing_categorySettings',
            array(
                'step'             => 1,
                'wizard'           => true,
                'listing_id'       => $listingId,
                'listing_creation' => true,
            )
        );
    }

    public function categoryStepTwoAction()
    {
        $listingId = Mage::helper('M2ePro/Component_Ebay')->getCollection('Listing')->getLastItem()->getId();

        return $this->_redirect(
            '*/adminhtml_ebay_listing_categorySettings',
            array(
                'step'             => 2,
                'wizard'           => true,
                'listing_id'       => $listingId,
                'listing_creation' => true,
            )
        );
    }

    public function categoryStepThreeAction()
    {
        $listingId = Mage::helper('M2ePro/Component_Ebay')->getCollection('Listing')->getLastItem()->getId();

        return $this->_redirect(
            '*/adminhtml_ebay_listing_categorySettings',
            array(
                'step'             => 3,
                'wizard'           => true,
                'listing_id'       => $listingId,
                'listing_creation' => true,
            )
        );
    }

    //########################################

    protected function getEbayAccountDefaultSettings()
    {
        $data = Mage::getModel('M2ePro/Ebay_Account_Builder')->getDefaultData();

        $data['marketplaces_data'] = array();

        $data['other_listings_synchronization'] = 0;

        $data['magento_orders_settings']['listing_other']['store_id'] = Mage::helper('M2ePro/Magento_Store')
            ->getDefaultStoreId();
        $data['magento_orders_settings']['qty_reservation']['days'] = 0;

        return $data;
    }

    //########################################
}
