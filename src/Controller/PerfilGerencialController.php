<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PerfilGerencial Controller
 *
 * @property \App\Model\Table\PerfilGerencialTable $PerfilGerencial
 * @method \App\Model\Entity\PerfilGerencial[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PerfilGerencialController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->PerfilGerencial->find()->contain(['Produtores']);
        $perfis = $this->paginate($query);

        $this->set(compact('perfis'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $produtorId = $this->request->getQuery('id_produtor'); // Retrieve from query string for initial load

        $errors = [];

        $formTitle = 'Cadastrar Novo Perfil Gerencial';
        if ($id) {
            $formTitle = 'Atualizar Perfil Gerencial';
            $perfil = $this->PerfilGerencial->get($id, [
                'contain' => ['Produtores'],
            ]);
        } else {
            $perfil = $this->PerfilGerencial->newEmptyEntity();
        }

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $perfil->outras_receitas = $data['outras_receitas'];

            $perfil = $this->PerfilGerencial->patchEntity($perfil, $data);
            if ($this->PerfilGerencial->save($perfil)) {
                $this->Flash->success(__('O perfil gerencial foi salvo com sucesso.'));

                $produtorId = $this->request->getData('id_produtor');
                $redirectTo = $this->request->getData('redirect_to');

                if ($redirectTo === 'produtor_view' && $produtorId) {
                    return $this->redirect(['controller' => 'Produtores', 'action' => 'view', $produtorId]);
                }
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O perfil gerencial não pôde ser salvo. Por favor, tente novamente.'));
                $errors = $perfil->getErrors();
            }
        }

        $produtores = $this->PerfilGerencial->Produtores->find('list', ['limit' => 200])->all();

        $this->set(compact('perfil', 'formTitle', 'produtores', 'id', 'errors', 'produtorId'));
        $this->render('form');
    }

    /**
     * Search Producers without PerfilGerencial method for Select2 AJAX
     *
     * @return \Cake\Http\Response|null|void JSON response
     */
    public function searchUnusedProducerSelection($id_produtor = null)
    {
        $this->request->allowMethod(['ajax']);

        $query = $this->request->getQuery('q');
        $searchType = $this->request->getQuery('search_type', 'nome');

        // Subquery to get producer IDs that already have a PerfilGerencial
        $subquery = $this->PerfilGerencial->find()
            ->select(['id_produtor'])
            ->distinct('id_produtor');

        $conditions = [
            'Produtores.id NOT IN' => $subquery
        ];

        if ($id_produtor !== null) {
            $conditions = [
                'OR' => [
                    'Produtores.id NOT IN' => $subquery,
                    'Produtores.id' => $id_produtor
                ]
            ];
        }

        $produtores = $this->PerfilGerencial->Produtores->find('all')
            ->where($conditions);

        if (!empty($query)) {
            if ($searchType === 'cpf') {
                $produtores->where(['Produtores.cpf LIKE' => '%' . $query . '%']);
            } else {
                $produtores->where(['Produtores.nome LIKE' => '%' . $query . '%']);
            }
        }

       $results = [];
        foreach ($produtores as $produtor) {
            if ($searchType === 'cpf' && empty($produtor->cpf)) {
                continue;
            }
            $text = ($searchType === 'cpf') ? $produtor->cpf : $produtor->nome;
            $results[] = [
                'id' => $produtor->id,
                'text' => $text,
                'nome' => $produtor->nome,
                'cpf' => $produtor->cpf
            ];
        }

        $this->set(compact('results'));
        $this->viewBuilder()->setOption('serialize', ['results']);
        $this->viewBuilder()->setClassName('Json');
    }

    public function getProducerInfo($id = null)
    {
        $this->request->allowMethod(['ajax']);
        $produtor = $this->PerfilGerencial->Produtores->get($id);
        $this->set('produtor', $produtor);
        $this->viewBuilder()->setOption('serialize', ['produtor']);
        $this->viewBuilder()->setClassName('Json');
    }

    /**
     * Edit method
     *
     * @param string|null $id Perfil Gerencial id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        return $this->add($id);
    }

    /**
     * Delete method
     *
     * @param string|null $id Perfil Gerencial id.
     * @return \Cake\Http\Response|null|void Redirects on successful delete, renders error on failure.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $perfil = $this->PerfilGerencial->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('O perfil gerencial com o ID {0} não foi encontrado.', $id));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->PerfilGerencial->delete($perfil)) {
            $this->Flash->success(__('O perfil gerencial foi excluído com sucesso.'));
        } else {
            $this->Flash->error(__('O perfil gerencial não pôde ser excluído. Por favor, tente novamente.'));
        }

        $produtorId = $this->request->getData('id_produtor');
        $redirectTo = $this->request->getData('redirect_to');

        if ($redirectTo === 'produtor_view' && $produtorId) {
            return $this->redirect(['controller' => 'Produtores', 'action' => 'view', $produtorId]);
        }
        return $this->redirect(['action' => 'index']);
    }
}