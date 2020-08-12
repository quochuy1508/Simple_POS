<?php


namespace ProjectFinal\POS\Model;

use Magento\Framework\Model\AbstractModel;
use ProjectFinal\POS\Api\Data\StaffInterface;
use ProjectFinal\POS\Model\ResourceModel\Staff as ResourceModel;

/**
 * Class Staff description information of staff in POS system
 *
 */
class Staff extends AbstractModel implements StaffInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'pos_staff';

    /**
     * @var string
     */
    protected $cacheTag = 'pos_staff';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $eventPrefix = 'pos_staff';

    /**
     * Initialize resource model.
     */

    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->getData(self::USERNAME);
    }

    /**
     * @inheritDoc
     */
    public function setUsername($username)
    {
        return $this->setData(self::USERNAME, $username);
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->getData(self::PASSWORD);
    }

    /**
     * @inheritDoc
     */
    public function setPassword($password)
    {
        return $this->setData(self::PASSWORD, $password);
    }

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @inheritDoc
     */
    public function getTelephone()
    {
        return $this->getData(self::TELEPHONE);
    }

    /**
     * @inheritDoc
     */
    public function setTelephone($telephone)
    {
        return $this->setData(self::TELEPHONE, $telephone);
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
}
