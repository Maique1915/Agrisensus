<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Produtores Controller
 *
 * @property \App\Model\Table\ProdutoresTable $Produtores
 * @method \App\Model\Entity\Produtore[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProdutoresController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $produtores = $this->paginate($this->Produtores);
        

        $this->set(compact('produtores'));
    }

    /**
     * View method
     *
     * @param string|null $id Produtore id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $produtor = $this->Produtores->get($id, [
            'contain' => [
                'Propriedades',
                'ProdutosCultivados',
                'CriacoesAnimais',
                'InsumosUtilizados',
                'FamiliaMaoDeObra',
                'PerfilGerencial',
            ],
        ]);

        $this->set(compact('produtor'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Produtore id.
     * @return \Cake\Http\Response|null|void Redirects on successful delete, renders error on failure.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $produtore = $this->Produtores->get($id);
        
        if ($this->Produtores->delete($produtore)) {
            $this->Flash->success(__('Produtor deletado com sucesso.'));
        } else {
            $this->Flash->error(__('Falha ao tentar excluir o produtor.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Salvar method (for add/edit)
     *
     * @param string|null $id Produtore id.
     * @return \Cake\Http\Response|null|void Redirects on successful add/edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function add($id = null)
    {
        $successMessage = null;
        $errorMessage = null;
        $errors = [];

        $formTitle = 'Cadastrar Novo Produtor';
        if ($id) {
            $formTitle = 'Atualizar Produtor';
            $produtor = $this->Produtores->get($id, ['contain' => []]);
        } else {
            $produtor = $this->Produtores->newEmptyEntity();
        }

        

        if ($this->request->is(['post', 'put'])) {
            $produtor = $this->Produtores->patchEntity($produtor, $this->request->getData());

            // --- Duplicate CPF/CNPJ check ---
            $data = $this->request->getData(); // Get data again to ensure latest values
            if (!empty($data['cpf']) || !empty($data['cnpj'])) {
                $conditions = [];
                if (!empty($data['cpf'])) {
                    $conditions['OR']['cpf'] = $data['cpf'];
                }
                if (!empty($data['cnpj'])) {
                    $conditions['OR']['cnpj'] = $data['cnpj'];
                }

                $duplicateQuery = $this->Produtores->find()->where($conditions);

                if ($id) { // If editing, exclude current record
                    $duplicateQuery->where(['id !=' => $id]);
                }

                if ($duplicateQuery->count() > 0) {
                    $this->Flash->error(__('Já existe um produtor cadastrado com o mesmo CPF ou CNPJ.'));
                    // Re-render the form with existing data and errors
                    $this->set(compact('produtor', 'formTitle', 'id', 'errors'));
                    $this->render('form');
                    return; // Stop further execution
                }
            }
            // --- End of Duplicate CPF/CNPJ check ---

            if ($this->Produtores->save($produtor)) {
                $this->Flash->success(__('O produtor foi salvo com sucesso.'));
                if ($id)
                    return $this->redirect(['action' => 'index']);
                return $this->redirect(['action' => 'add']);
            } else {
            $this->Flash->error(message: __('O produtor não pôde ser salvo. Por favor, tente novamente.'));
                $errors = $produtor->getErrors();
            }
        }
            $this->set(compact('produtor', 'id', 'errors'));
            $this->render('form'); // Renderiza o template form.php
    }

    /**
     * Edit method
     *
     * @param string|null $id Produtore id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        return $this->add($id);
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

        $produtores = $this->Produtores->find('all');

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
        $produtor = $this->Produtores->get($id);
        $this->set('produtor', $produtor);
        $this->viewBuilder()->setOption('serialize', ['produtor']);
        $this->viewBuilder()->setClassName('Json');
    }
}
