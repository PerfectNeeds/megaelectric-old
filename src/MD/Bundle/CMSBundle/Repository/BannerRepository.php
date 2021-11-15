<?php

namespace MD\Bundle\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BannerRepository extends EntityRepository {

    public function getRandBanner($placment) {
        $queryResult = $this->getEntityManager()->getConnection()->executeQuery("SELECT id FROM Banner WHERE placement = '" . $placment . "'");
        $result = array();
        foreach ($queryResult as $key => $r) {
            $result[$key] = $this->getEntityManager()->getRepository('CMSBundle:Banner')->find($r['id']);
        }

        if ($result == null) {
            return;
        } else {
            return $result;
        }
    }

}
