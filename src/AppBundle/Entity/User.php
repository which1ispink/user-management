<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Exception\InvalidInputDataException;
use AppBundle\Exception\InvalidOperationException;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="users", options={"collate"="utf8_unicode_ci"})
 */
class User extends Entity
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
     */
    public function setName($name)
    {
        $name = (string) $name;
        if (strlen($name) > 60) {
            throw new InvalidInputDataException(
                'User name must be a string that is less than 60 characters in length'
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
}
