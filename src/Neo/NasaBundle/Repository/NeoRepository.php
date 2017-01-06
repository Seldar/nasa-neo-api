<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 5.12.2016
 * Time: 11:17
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Neo\NasaBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Neo\NasaBundle\Document\Neo;

/**
 * Class NeoRepository
 *
 * Repository to handle database related logic
 *
 * @package Neo\NasaBundle\Repository
 */
class NeoRepository extends DocumentRepository
{

    /**
     * Persists the document Neo in the database
     *
     * @param $date
     * @param \StdClass $data
     */
    public function save($date, \StdClass $data)
    {
        $neo = $this->getDocumentManager()->createQueryBuilder('NasaBundle:Neo')
            ->find()
            ->field('reference')->equals((float)$data->neo_reference_id)
            ->getQuery()
            ->execute();

        if ($neo->count() == 0) {
            $neo = new Neo();
            $neo->setName($data->name);
            $neo->setDate($date);
            $neo->setReference($data->neo_reference_id);
            $neo->setSpeed($data->close_approach_data[0]->relative_velocity->kilometers_per_hour);
            $neo->setIsHazardous($data->is_potentially_hazardous_asteroid);

            $this->getDocumentManager()->persist($neo);
        }
    }

    /**
     * Saves all documents with specified date
     *
     * @param $date
     * @param array $data
     */
    public function saveAll($date, array $data)
    {
        foreach ($data as $neo) {
            $this->save($date, $neo);
        }
        $this->getDocumentManager()->flush();
    }

    /**
     * Retrieves all documents with is_hazardous set to true from database
     *
     * @return array
     */
    public function getHazardousNeo()
    {
        $neos = $this->getDocumentManager()->createQueryBuilder('NasaBundle:Neo')
            ->find()
            ->field('is_hazardous')->equals(true)
            ->getQuery()
            ->execute();
        $result = [];
        foreach ($neos as $neo) {
            $result[] = $neo->toArray();
        }

        return $result;
    }

    /**
     * Retrieves Neo document with the maximum speed.
     *
     * @return array
     */
    public function getFastestNeo()
    {
        $neo = $this->getDocumentManager()->createQueryBuilder('NasaBundle:Neo')
            ->find()
            ->sort('speed', 'desc')
            ->limit(1)
            ->getQuery()
            ->getSingleResult();
        $result = $neo->toArray();
        return $result;
    }
}