<?php

namespace App\Utils;

use App\Entity\Feature;
use Doctrine\Persistence\ObjectManager;

class Utils
{
    public static function reOrderItems(ObjectManager $manager, array $array, int $fromPosition, int $newPosition)
    {
        $arrayOrdered = Utils::moveValueByIndex($array, $fromPosition, $newPosition);

        foreach ($arrayOrdered as $key => $feature) {
            if($feature->getOrderPosition() != $key) {
                $feature->setOrderPosition($key);
                $manager->persist($feature);
            }
        }

        $manager->flush();
        return $arrayOrdered;
    }

    public static function moveValueByIndex( array $array, $from = null, $to = null )
    {
        if ( null === $from )
        {
            $from = count( $array ) - 1;
        }

        if ( !isset( $array[$from] ) )
        {
            throw new \Exception( "Offset $from does not exist" );
        }

//        if ( array_keys( $array ) != range( 0, count( $array ) - 1 ) )
//        {
//            throw new \Exception( "Invalid array keys" );
//        }

        $value = $array[$from];
        unset( $array[$from] );

        if ( null === $to )
        {
            array_push( $array, $value );
        } else {
            $tail = array_splice( $array, $to );
            array_push( $array, $value );
            $array = array_merge( $array, $tail );
        }

        return $array;
    }
}