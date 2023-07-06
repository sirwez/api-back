<?php

namespace App\Controllers;

use App\Models\Entity\Atividade;
use App\Controllers\BaseController;

class Atividades extends BaseController
{
    public function __construct()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
    }
    protected $helpers = ['doctrine_helper'];


    public function listarID($id)
    {

        $data = [];
        $doctrine =  doctrine_instance();
        $atividades = $doctrine->em->getRepository('App\Models\Entity\Atividade')->findBy(array("id" => $id));

        if (!$atividades) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Not Found']);
        }

        foreach ($atividades as $atividade) {
            $data[] = [
                "id" => $atividade->getId(),
                "data" => $atividade->getDatacadastro()->format('Y-m-d'),
                "descricao" => $atividade->getDescricao(),
                "projeto" => $atividade->getIdprojeto()->getId()
            ];
        }
        return $this->response->setJSON($data);
    }

    public function listarTodos()
    {
        $data = [];
        $doctrine = doctrine_instance();
        $atividades = $doctrine->em->getRepository('App\Models\Entity\Atividade')->findAll();

        if (!$atividades) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Not Found']);
        }

        foreach ($atividades as $atividade) {
            $data[] = [
                "id" => $atividade->getId(),
                "data" => $atividade->getDatacadastro()->format('Y-m-d'),
                "descricao" => $atividade->getDescricao(),
                "projeto" => $atividade->getIdprojeto()->getId()
            ];
        }
        return $this->response->setJSON($data);
    }

    public function cadastrar()
    {
        // Recuperar os dados enviados no corpo da requisição
        $data = $this->request->getJSON(true);

        // Criar uma nova instância da entidade Atividade
        $atividade = new Atividade();
        $atividade->setDatacadastro((new \DateTime())->setDate(date('Y'), date('m'), date('d')));


        $atividade->setDescricao($data['descricao']);

        // Buscar o projeto pelo ID
        $doctrine = doctrine_instance();
        $projeto = $doctrine->em->getRepository('\App\Models\Entity\Projeto')->find($data['idProjeto']);

        // Verificar se o projeto existe
        if (!$projeto) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Not Found: Projeto - ' . $data['idProjeto']]);
        }

        // Associar o projeto à atividade
        $atividade->setIdprojeto($projeto);

        // Salvar a atividade no banco de dados usando o Doctrine
        $doctrine->em->persist($atividade);
        $doctrine->em->flush();
        return $this->response->setJSON(['message' => 'Atividade cadastrada com sucesso']);
    }


    public function alterar($id)
    {
        // Recuperar os dados enviados no corpo da requisição
        $data = $this->request->getJSON(true);
        // Buscar a atividade no banco de dados usando o Doctrine
        $doctrine = doctrine_instance();
        $atividade = $doctrine->em->getRepository('App\Models\Entity\Atividade')->find($id);

        // Verificar se a atividade existe
        if (!$atividade) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Not Found']);
        }

        // Atualizar os dados da atividade
        $atividade->setDescricao($data['descricao']);

        // Salvar as alterações no banco de dados
        $doctrine->em->flush();

        return $this->response->setJSON(['message' => 'Atividade alterada com sucesso']);
    }

    public function excluir($id)
    {
        // Buscar a atividade no banco de dados usando o Doctrine
        $doctrine = doctrine_instance();
        $atividade = $doctrine->em->getRepository('App\Models\Entity\Atividade')->find($id);

        // Verificar se a atividade existe
        if (!$atividade) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Not Found']);
        }

        // Remover a atividade do banco de dados
        $doctrine->em->remove($atividade);
        $doctrine->em->flush();

        return $this->response->setJSON(['message' => 'Atividade excluída com sucesso']);
    }
}
