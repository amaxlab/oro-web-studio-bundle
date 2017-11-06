<?php

/*
 * This file is part of the WebStudioBundle project.
 *
 * (c) AmaxLab 2017 <http://www.amaxlab.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AmaxLab\Oro\WebStudioBundle\Entity;

use AmaxLab\Oro\WebStudioBundle\EntityProperty\DatesAwareTrait;
use AmaxLab\Oro\WebStudioBundle\EntityProperty\IdAwareTrait;
use AmaxLab\Oro\WebStudioBundle\EntityProperty\NameAwareTrait;
use AmaxLab\Oro\WebStudioBundle\Model\ExtendRole;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\OrganizationBundle\Entity\Ownership\BusinessUnitAwareTrait;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 * @ORM\Entity(repositoryClass="AmaxLab\Oro\WebStudioBundle\Repository\RoleRepository")
 * @ORM\Table(name="web_studio_role")
 * @ORM\HasLifecycleCallbacks()
 * @Config(
 *      routeName="web_studio_role_index",
 *      routeView="web_studio_role_view",
 *      routeCreate="web_studio_role_create",
 *      defaultValues={
 *          "entity"={
 *              "icon"="fa-bolt"
 *          },
 *          "security"={
 *              "type"="ACL",
 *              "group_name"="",
 *              "category"="web-studio"
 *          },
 *          "ownership"={
 *              "owner_type"="BUSINESS_UNIT",
 *              "owner_field_name"="owner",
 *              "owner_column_name"="business_unit_owner_id",
 *              "organization_field_name"="organization",
 *              "organization_column_name"="organization_id"
 *          },
 *          "grid"={
 *              "default"="web-studio-role-grid"
 *          }
 *      }
 * )
 */
class Role extends ExtendRole
{
    use IdAwareTrait, NameAwareTrait, BusinessUnitAwareTrait, DatesAwareTrait;

    /**
     * @var Host[]
     * @ORM\ManyToMany(targetEntity="AmaxLab\Oro\WebStudioBundle\Entity\Host", mappedBy="roles")
     * @ORM\JoinTable(name="web_studio_host_roles")
     */
    private $hosts;

    /**
     * Role constructor.
     */
    public function __construct()
    {
        $this->hosts = new ArrayCollection();
    }

    /**
     * @return Host[]
     */
    public function getHosts()
    {
        return $this->hosts;
    }

    /**
     * @param Host[] $hosts
     *
     * @return $this
     */
    public function setHosts($hosts)
    {
        $this->hosts = $hosts;

        return $this;
    }
}
