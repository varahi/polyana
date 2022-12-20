<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;

class CoordinateService extends AbstractController
{
    /**
     * @param ManagerRegistry $doctrine
     */
    public function __construct(
        ManagerRegistry $doctrine
    ) {
        $this->doctrine = $doctrine;
    }

    public function setCoordinates($item)
    {
        // Create url request
        $address = str_replace(" ", "+", $item->getAddress());
        $urlRequest = 'https://nominatim.openstreetmap.org/search.php?q='.$address.'+'.'&countrycodes=ru&limit=1&format=jsonv2';

        // Create a stream
        $opts = array('http'=>array('header'=>"User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
        $context = stream_context_create($opts);

        // Open the file using the HTTP headers set above
        $data = file_get_contents($urlRequest, false, $context);
        $json = json_decode($data);
        foreach ($json as $data) {
            $lat = $data->lat;
            $lon = $data->lon;
        }

        if (isset($lat) && isset($lon)) {
            $item->setLat($lat);
            $item->setLng($lon);
        }

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($item);
        $entityManager->flush();
    }
}