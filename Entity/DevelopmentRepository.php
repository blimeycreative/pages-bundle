<?php

namespace Savvy\PagesBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * ContentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DevelopmentRepository extends EntityRepository
{

    public function getConstructionGalleries($development_id, $offset)
    {
        return $this->createQueryBuilder('d')
            ->select("d.*, md.*")
            ->innerJoin("d.cms_galleries", "g")
            ->innerJoin("g.files", "f")
            ->innerJoin("f.media_data", "md")
            ->innerJoin("g.gallery_type", "gt")
            ->where("d.id = :development AND gt.name = :construction")
            ->setParameter("development", $development_id)
            ->setParameter("construction", "construction")
            ->setMaxResults(5)
            ->setFirstResult($offset)
            ->getQuery()
            ->getOneOrNullResult();
    }

}