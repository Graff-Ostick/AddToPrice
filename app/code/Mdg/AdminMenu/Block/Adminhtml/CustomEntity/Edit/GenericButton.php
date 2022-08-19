<?php

namespace Mdg\AdminMenu\Block\Adminhtml\CustomEntity\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\LocalizedException;
use Mdg\Models\Api\MdgEntityRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use function PHPUnit\Framework\throwException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var MdgEntityRepositoryInterface
     */
    protected $mdgEntityRepository;

    /**
     * @param Context $context
     * @param MdgEntityRepositoryInterface $mdgEntityRepository
     */
    public function __construct(
        Context $context,
        MdgEntityRepositoryInterface $mdgEntityRepository
    ) {
        $this->context = $context;
        $this->mdgEntityRepository = $mdgEntityRepository;
    }

    /**
     * Return Mdg Entity ID
     *
     * @return int|null
     * @throws LocalizedException
     */
    public function getMdgEntityId()
    {
        try {
            return $this->mdgEntityRepository->getById(
                $this->context->getRequest()->getParam('mdg_entity_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            throwException($e);
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
