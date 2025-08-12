<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * InsumosUtilizados Controller
 *
 * @property \App\Model\Table\InsumosUtilizadosTable $InsumosUtilizados
 * @method \App\Model\Entity\InsumosUtilizado[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InsumosUtilizadosController extends AppController
{

    public  $unidades = [
            'KG' => 'Quilograma (Kg)',
            'L' => 'Litro (L)',
            'UN' => 'Unidade',
            'PCT' => 'Pacote',
            'CX' => 'Caixa',
            'M' => 'Metro',
            'M2' => 'Metro Quadrado',
            'M3' => 'Metro Cúbico',
        ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $insumos = $this->paginate($this->InsumosUtilizados);
        $this->set(compact('insumos'));
        $this->set('unidades', $this->unidades);
    }

    /**
     * Salvar method (for add/edit)
     *
     * @param string|null $id InsumosUtilizado id.
     * @return \Cake\Http\Response|null|void Redirects on successful add/edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function add($id = null)
    {
        $produtorId = $this->request->getQuery('id_produtor'); // Retrieve from query string for initial load

        $successMessage = null;
        $errorMessage = null;
        $errors = [];

        $formTitle = 'Cadastrar Novo Insumo';
        if ($id) {
            $formTitle = 'Atualizar Insumo';
            $insumosUtilizado = $this->InsumosUtilizados->get($id, ['contain' => []]);
        } else {
            $insumosUtilizado = $this->InsumosUtilizados->newEmptyEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            //debug($data);
            $insumosUtilizado->nome = $data['nome'];        
            $insumosUtilizado->preco = (float) str_replace(',', '.', str_replace('.', '', $data['preco'] ?? '0'));
            $insumosUtilizado->quantidade = (float) str_replace(',', '.', str_replace('.', '', $data['quantidade'] ?? '0'));
        
            $insumosUtilizado = $this->InsumosUtilizados->patchEntity($insumosUtilizado, $data);

            //debug($insumosUtilizado);
            if ($this->InsumosUtilizados->save($insumosUtilizado)) {
                $this->Flash->success(__('O insumo utilizado foi salvo com sucesso.'));
                $produtorId = $this->request->getData('id_produtor');
                $redirectTo = $this->request->getData('redirect_to');

                if ($redirectTo === 'produtor_view' && $produtorId) {
                    return $this->redirect(['controller' => 'Produtores', 'action' => 'view', $produtorId]);
                }
                return $this->redirect(['action' => 'index']);
            } else {
                //debug($insumosUtilizado->getErrors());
                $this->Flash->error(__('O insumo utilizado não pôde ser salvo. Por favor, tente novamente.'));
                $errors = $insumosUtilizado->getErrors();
            }
        }
        $produtores = $this->InsumosUtilizados->Produtores->find('list')->all();
        
        $this->set(compact('insumosUtilizado', 'formTitle', 'id', 'successMessage', 'errorMessage', 'errors', 'produtores', 'produtorId'));
        $this->set('unidades', $this->unidades);
        $this->render('form');
    }

    /**
     * Edit method
     *
     * @param string|null $id InsumosUtilizado id.
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
     * @param string|null $id InsumosUtilizado id.
     * @return \Cake\Http\Response|null|void Redirects on successful delete, renders error on failure.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $insumosUtilizado = $this->InsumosUtilizados->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('O insumo utilizado com o ID {0} não foi encontrado.', $id));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->InsumosUtilizados->delete($insumosUtilizado)) {
            $this->Flash->success(__('O insumo utilizado foi excluído com sucesso.'));
        } else {
            $this->Flash->error(__('O insumo utilizado não pôde ser excluído. Por favor, tente novamente.'));
        }
        $produtorId = $this->request->getData('id_produtor');
        $redirectTo = $this->request->getData('redirect_to');

        if ($redirectTo === 'produtor_view' && $produtorId) {
            return $this->redirect(['controller' => 'Produtores', 'action' => 'view', $produtorId]);
        }
        return $this->redirect(['action' => 'index']);
    }
}
