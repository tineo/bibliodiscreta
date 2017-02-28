<?php

/**
 * Created by PhpStorm.
 * User: tineo
 * Date: 28/02/17
 * Time: 12:12 AM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity
 * @ORM\Table(name="libros")
 */
class Libro
{
    /**
     * @ORM\Column(type="string", length=5 , name="codlib")
     * @ORM\Id
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=30, name="nomlib")
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=30, name="autor")
     */
    private $autor;

    /**
     * @ORM\Column(type="string", length=30, name="editorial")
     */
    private $editorial;

    /**
     * @ORM\Column(type="string", length=20, name="pais")
     */
    private $pais;

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     * @return Libro
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     * @return Libro
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $autor
     * @return Libro
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEditorial()
    {
        return $this->editorial;
    }

    /**
     * @param mixed $editorial
     * @return Libro
     */
    public function setEditorial($editorial)
    {
        $this->editorial = $editorial;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param mixed $pais
     * @return Libro
     */
    public function setPais($pais)
    {
        $this->pais = $pais;
        return $this;
    }






}