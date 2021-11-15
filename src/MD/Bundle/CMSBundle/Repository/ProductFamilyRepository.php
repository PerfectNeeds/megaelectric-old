<?php

namespace MD\Bundle\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MD\Utils\SQL;
use MD\Utils\Validate;

class ProductFamilyRepository extends EntityRepository {

    const MAX_PER_PAGE = 1;

    public function getByBrandSlug($slug) {
        $families = $this->getEntityManager()
                ->createQuery('SELECT f.id FROM CMSBundle:ProductBrand b LEFT JOIN b.families f WHERE b.htmlSlug = :slug')
                ->setParameter('slug', $slug)
                ->getResult();


        $result = array();
        foreach ($families as $key => $r) {
            $result[$key] = $this->getEntityManager()->getRepository('CMSBundle:ProductFamily')->find($r['id']);
        }

        return $result;
    }

    public function getOneByBrandSlugAndFamilySlug($brandSlug, $categorySlug, $familySlug) {
        $families = $this->getEntityManager()
                ->createQuery('SELECT f.id FROM CMSBundle:ProductBrand b LEFT JOIN b.categories c LEFT JOIN c.families f WHERE b.htmlSlug = :brandSlug AND c.htmlSlug = :categorySlug AND f.htmlSlug = :familySlug')
                ->setMaxResults(1)
                ->setParameter('brandSlug', $brandSlug)
                ->setParameter('categorySlug', $categorySlug)
                ->setParameter('familySlug', $familySlug)
                ->getResult();


        $result = array();
        foreach ($families as $key => $r) {
            $result[$key] = $this->getEntityManager()->getRepository('CMSBundle:ProductFamily')->find($r['id']);
        }


        if ($result == null) {
            return;
        } else {
            return $result[0];
        }
    }

    public function getRandByCategorySlugAndFamilySlug($categorySlug, $familySlug) {
        $families = $this->getEntityManager()
                ->createQuery('SELECT f.id FROM CMSBundle:ProductCategory c LEFT JOIN c.families f WHERE c.htmlSlug = :categorySlug AND f.htmlSlug != :familySlug ')
                ->setMaxResults(3)
                ->setParameter('categorySlug', $categorySlug)
                ->setParameter('familySlug', $familySlug)
                ->getResult();


        $result = array();
        foreach ($families as $key => $r) {
            $result[$key] = $this->getEntityManager()->getRepository('CMSBundle:ProductFamily')->find($r['id']);
        }


        if ($result == null) {
            return;
        } else {
            return $result;
        }
    }

    public function LoadImagesbyType($type, $id) {
        return $this->getEntityManager()
                        ->createQuery('SELECT i.id FROM CMSBundle:ProductFamily b LEFT JOIN b.images i Where i.imageType = :type AND b.id = :id ')
                        ->setParameter('type', $type)
                        ->setParameter('id', $id)
                        ->getResult();
    }

    public function UpdateImagesbyType($id) {
        $this->getEntityManager()->getConnection()->executeQuery("UPDATE image i JOIN productfamily_image b on i.id = b.image_id set
i.imageType = 200 where i.imageType = 201 and b.productfamily_id = :id ", array("id" => $id));
    }

    public function filter($search, $count = false, $targetPage) {
        if ($search->month != null && $search->year != null) {
            $sqlCondition = ' WHERE DATE_FORMAT(b.created,"%M-%Y") =  ?  ';
            $productfamilyDateInterval = $search->month . "-" . $search->year;
        } else if ($search->month != null && $search->year == null) {
            $sqlCondition = ' WHERE DATE_FORMAT(b.created,"%M-%Y") =  ?  ';
            $productfamilyDateInterval = $search->month . "-" . date("Y");
        } else if ($search->month == null && $search->year != null) {
            $sqlCondition = ' WHERE DATE_FORMAT(b.created,"%Y") =  ?  ';
            $productfamilyDateInterval = $search->year;
        } else if ($search->month == null && $search->year == null) {
            $sqlCondition = '  ';
            $productfamilyDateInterval = date("Y");
        }
        $clause = " ";
        if ($targetPage !== -1 && ($search->month != null || $search->year != null )) {
            if (is_numeric($targetPage) && ($targetPage != 0)) {
                $start = ($targetPage - 1) * self::MAX_PER_PAGE;
                $clause .= ' LIMIT ' . $start . ',' . self::MAX_PER_PAGE;
            } else {
                $clause .= ' LIMIT ' . $start . ',' . self::MAX_PER_PAGE;
            }
        }
        if ($count) {
            $sql = ' SELECT COUNT(id) AS `productfamilyCount`  FROM ProductFamily b ' . $sqlCondition . $clause;
            // exit($sql);

            return $this->getEntityManager()->getConnection()->executeQuery($sql, array($productfamilyDateInterval))->fetchColumn();
        } else {
            $sql = ' SELECT id  FROM ProductFamily b ' .
                    $sqlCondition . $clause;


//             exit($sql);
            $filterResult = $this->getEntityManager()->getConnection()->executeQuery($sql, array($productfamilyDateInterval));

            $result = array();
            foreach ($filterResult as $key => $r) {
                $result[$key] = $this->getEntityManager()->getRepository('CMSBundle:ProductFamily')->find($r['id']);
            }
            return $result;
        }
    }

    public function getRandProductFamily() {
        $queryResult = $this->getEntityManager()->getConnection()->executeQuery("SELECT id FROM ProductFamily ORDER BY RAND() LIMIT 1");
        $result = array();
        foreach ($queryResult as $key => $r) {
            $result[$key] = $this->getEntityManager()->getRepository('CMSBundle:ProductFamily')->find($r['id']);
        }
        if ($result == null) {
            return;
        } else {
            return $result[0];
        }
    }

}
