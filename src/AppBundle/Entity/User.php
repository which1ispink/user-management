<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Exception\InvalidInputDataException;
use AppBundle\Exception\InvalidOperationException;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="users", options={"collate"="utf8_unicode_ci"})
 */
class User extends Entity implements JsonSerializable
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
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
     * @ORM\JoinTable(
     *  name="users_groups",
     *  joinColumns={
     *      @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $groups;

    /**
     * User constructor
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
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
     * @return User
     * @throws InvalidInputDataException if the given name is more than 60 characters in length
     */
    public function setName($name)
    {
        $name = (string) $name;
        if (empty($name) || strlen($name) > 60) {
            throw new InvalidInputDataException(
                'User name must be a non-empty string that is less than 60 characters in length'
            );
        }

        $this->name = $name;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Assigns user to a group
     *
     * @param Group $group
     * @return User
     * @throws InvalidOperationException if the user is already assigned to the given group
     */
    public function assignToGroup(Group $group)
    {
        if ($this->groups->contains($group)) {
            throw new InvalidOperationException(
                'User is already assigned to the specified group'
            );
        }

        $this->groups->add($group);
        return $this;
    }

    /**
     * Removes user from a group
     *
     * @param Group $group
     * @return User
     * @throws InvalidOperationException if the user is not assigned to the given group
     */
    public function removeFromGroup(Group $group)
    {
        if (! $this->groups->contains($group)) {
            throw new InvalidOperationException(
                'User is not assigned to the specified group'
            );
        }

        $this->groups->removeElement($group);
        return $this;
    }

    /**
     * Removes user from all assigned groups
     *
     * @return User
     */
    public function clearGroups()
    {
        $this->groups = new ArrayCollection();
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'groups' => $this->getGroups()->toArray(),
        ];
    }
}
