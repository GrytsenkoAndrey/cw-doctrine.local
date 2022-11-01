<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

/**
 * @Entity
 */
class Article
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string")
     */
    private $name;

    /**
     * @Column(type="string", unique=true)
     */
    private $slug;

    /**
     * @Column(type="string")
     */
    private $image;

    /**
     * @Column(type="text")
     */
    private $body;

    /**
     * @Column(type="datetime")
     */
    private $published_at;
}
