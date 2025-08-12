<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * CriacoesAnimais Controller
 *
 * @property \App\Model\Table\CriacoesAnimaisTable $CriacoesAnimais
 * @method \App\Model\Entity\CriacaoAnimai[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CriacoesAnimaisController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $criacoes = $this->CriacoesAnimais->find()->contain(['Produtores' => ['joinType' => 'INNER']]);
        $this->set(compact('criacoes'));
    }

    /**
     * Salvar method (for add/edit)
     *
     * @param string|null $id_criacao CriacaoAnimai id.
     * @return \Cake\Http\Response|null|void Redirects on successful add/edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function add($id = null)
    {
        $produtorId = $this->request->getQuery('id_produtor'); // Retrieve from query string for initial load

        $formTitle = 'Cadastrar Nova Criação de Animal';
        if ($id) {
            $criacaoAnimai = $this->CriacoesAnimais->get($id, [
                'contain' => ['Produtores'],
            ]);
            $formTitle = 'Editar Criação de Animal';
        } else {
            $criacaoAnimai = $this->CriacoesAnimais->newEmptyEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Converte a vírgula para ponto no campo quantidade, se existir
            if (isset($data['quantidade']) && is_string($data['quantidade'])) {
                $data['quantidade'] = str_replace(',', '.', $data['quantidade']);
            }
            $criacaoAnimai = $this->CriacoesAnimais->patchEntity($criacaoAnimai, $data);

            if ($this->CriacoesAnimais->save($criacaoAnimai)) {
                $this->Flash->success(__('A criação de animal foi salva com sucesso.'));
                $produtorId = $this->request->getData('id_produtor');
                $redirectTo = $this->request->getData('redirect_to');

                if ($redirectTo === 'produtor_view' && $produtorId) {
                    return $this->redirect(['controller' => 'Produtores', 'action' => 'view', $produtorId]);
                }
                // Se não veio da view do produtor ou não tem id_produtor, redireciona para o index de CriacoesAnimais
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(message: __('A criação de animal não pôde ser salva. Por favor, tente novamente.'));
        }

        // Não buscar propriedades, pois não há id_propriedade na tabela criacoes_animais
        // $propriedades = $this->CriacoesAnimai->Propriedades->find('list', ['limit' => 500])->all();
        
        $unidades = [
            'Cabeça', 'Kg', 'Litro', 'Dúzia', 'Caixa', 'Saca', 'Arroba',
            'Unidade', 'Pé', 'Fardo', 'Grama', 'Miligrama', 'Tonelada',
            'Rolo', 'Pote', 'Bandeja', 'Pacote', 'Lote', 'Outro'
        ];

        $this->set(compact('criacaoAnimai', 'formTitle', 'unidades', 'id', 'produtorId'));
        $this->render('form');
    }

    /**
     * Edit method
     *
     * @param string|null $id_criacao CriacaoAnimai id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id_criacao = null)
    {
        return $this->add($id_criacao);
    }

    /**
     * Delete method
     *
     * @param string|null $id_criacao CriacaoAnimai id.
     * @return \Cake\Http\Response|null|void Redirects on successful delete, renders error on failure.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id_criacao = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $criacaoAnimai = $this->CriacoesAnimais->get($id_criacao);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('A criação de animal com o ID {0} não foi encontrada.', $id_criacao));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->CriacoesAnimais->delete($criacaoAnimai)) {
            $this->Flash->success(__('A criação de animal foi excluída com sucesso.'));
        } else {
            $this->Flash->error(__('A criação de animal não pôde ser excluída. Por favor, tente novamente.'));
        }

        $produtorId = $this->request->getData('id_produtor');
        $redirectTo = $this->request->getData('redirect_to');

        if ($redirectTo === 'produtor_view' && $produtorId) {
            return $this->redirect(['controller' => 'Produtores', 'action' => 'view', $produtorId]);
        }
        // Default redirect if no specific redirect_to is provided or if it's not 'produtor_view'
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Search Producers method for Select2 AJAX
     *
     * @return \Cake\Http\Response|null|void JSON response
     */
    public function searchProducers()
    {
        $this->request->allowMethod(['ajax']);

        $query = $this->request->getQuery('q');
        $searchType = $this->request->getQuery('search_type', 'nome');

        $produtores = $this->CriacoesAnimais->Produtores->find('all');

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
        $produtor = $this->CriacoesAnimais->Produtores->get($id);
        $this->set('produtor', $produtor);
        $this->viewBuilder()->setOption('serialize', ['produtor']);
        $this->viewBuilder()->setClassName('Json');
    }
}