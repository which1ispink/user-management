<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Exception\InvalidInputDataException;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupRepository")
 * @ORM\Table(name="groups", options={"collate"="utf8_unicode_ci"})
 */
class Group extends Entity implements JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="name", length=64)
     **/
    protected $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
     */
    protected $users;

    /**
     * Group constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Group
     * @throws InvalidInputDataException if the given name is more than 60 characters in length
     */
    public function setName($name)
    {
        $name = (string) $name;
        if (empty($name) || strlen($name) > 60) {
            throw new InvalidInputDataException(
                'Group name must be a non-empty string that is less than 60 characters in length'
            );
        }

        $this->name = $name;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Assigns a user to the group
     *
     * @param User $user
     * @return Group
     */
    public function assignUser(User $user)
    {
        $user->assignToGroup($this);
        return $this;
    }

    /**
     * Removes a user from the group
     *
     * @param User $user
     * @return Group
     */
    public function removeUser(User $user)
    {
        $user->removeFromGroup($this);
        return $this;
    }

    /**
     * Returns whether or not group has users assigned to it as opposed to empty
     *
     * @return bool
     */
    public function hasAssignedUsers()
    {
        return count($this->users) > 0;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}
