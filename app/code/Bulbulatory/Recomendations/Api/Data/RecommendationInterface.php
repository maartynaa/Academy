<?php
 
namespace Bulbulatory\Recomendations\Api\Data;
 
use Magento\Framework\Api\ExtensibleDataInterface;
 
interface RecommendationInterface extends ExtensibleDataInterface
{
    /**
     * @return int
     */
    public function getId();
 
    /**
     * @param int $id
     * @return void
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getRecommenderId();
 
    /**
     * @param int $id
     * @return void
     */
    public function setRecommenderId($id);
 
    /**
     * @return string
     */
    public function getEmail();
 
    /**
     * @param string $email
     * @return void
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getHash();
 
    /**
     * @param string $hash
     * @return void
     */
    public function setHash($hash);

    /**
     * @return bool
     */
    public function getStatus();
 
    /**
     * @param bool $status
     * @return void
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getCreatedAt();
 
    /**
     * @param string $created_at
     * @return void
     */
    public function setCreatedAt($created_at);

    /**
     * @return string|null
     */
    public function getConfirmedAt();
 
    /**
     * @param string $confirmed_at
     * @return void
     */
    public function setConfirmedAt($confirmed_at);
 
    
}