<?php

namespace App\Models\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Atividade
 *
 * @ORM\Table(name="atividade", indexes={@ORM\Index(name="idxprojeto", columns={"idProjeto"})})
 * @ORM\Entity
 */
class Atividade
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dataCadastro", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datacadastro = 'CURRENT_TIMESTAMP';

    /**
     * @var string|null
     *
     * @ORM\Column(name="descricao", type="string", length=255, nullable=true)
     */
    private $descricao;

    /**
     * @var \App\Models\Entity\Projeto
     *
     * @ORM\ManyToOne(targetEntity="App\Models\Entity\Projeto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProjeto", referencedColumnName="id")
     * })
     */
    private $idprojeto;



    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set datacadastro.
     *
     * @param \DateTime|null $datacadastro
     *
     * @return Atividade
     */
    public function setDatacadastro($datacadastro = null)
    {
        $this->datacadastro = $datacadastro;

        return $this;
    }

    /**
     * Get datacadastro.
     *
     * @return \DateTime|null
     */
    public function getDatacadastro()
    {
        return $this->datacadastro;
    }

    /**
     * Set descricao.
     *
     * @param string|null $descricao
     *
     * @return Atividade
     */
    public function setDescricao($descricao = null)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao.
     *
     * @return string|null
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set idprojeto.
     *
     * @param \App\Models\Entity\Projeto|null $idprojeto
     *
     * @return Atividade
     */
    public function setIdprojeto(\App\Models\Entity\Projeto $idprojeto = null)
    {
        $this->idprojeto = $idprojeto;

        return $this;
    }

    /**
     * Get idprojeto.
     *
     * @return \App\Models\Entity\Projeto|null
     */
    public function getIdprojeto()
    {
        return $this->idprojeto;
    }
}
