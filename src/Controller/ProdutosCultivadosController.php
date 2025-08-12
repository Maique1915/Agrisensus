<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client\Response;

/**
 * ProdutosCultivados Controller
 *
 * @property \App\Model\Table\ProdutosCultivadosTable $ProdutosCultivados
 * @method \App\Model\Entity\ProdutosCultivado[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProdutosCultivadosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $produtos = $this->ProdutosCultivados->find()->contain(['Produtores' => ['joinType' => 'INNER']]);
        $this->set(compact('produtos'));
    }

    /**
     * Salvar method (for add/edit)
     *
     * @param string|null $id_produto ProdutosCultivado id.
     * @return \Cake\Http\Response|null|void Redirects on successful add/edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function add($id = null)
    {
        $produtorId = $this->request->getQuery('id_produtor'); // Retrieve from query string for initial load

        $successMessage = null;
        $errorMessage = null;
        $errors = [];

        $formTitle = 'Cadastrar Novo Produto Cultivado';
        if ($id) {
            $formTitle = 'Atualizar Produto Cultivado';
            $produto = $this->ProdutosCultivados->get($id, ['contain' => []]);
        } else {
            $produto = $this->ProdutosCultivados->newEmptyEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            //debug($data);

            // Explicitly set fields to ensure they are marked as dirty
            $produto->id_produtor = $data['id_produtor'];
            $produto->nome = $data['nome'] ?? '';
            $produto->preco = (float) $data['preco'] ?? '0';
            $produto->producao_anual = (float) $data['producao_anual'] ?? '0';
            $produto->unidade = $data['unidade'];
            $produto->periodo_colheita = $data['periodo_colheita'];
            $produto->receita_total = $data['receita_total'] ?? '0';

            if ($this->ProdutosCultivados->save($produto)) {
                $this->Flash->success(__('O produto cultivado foi salvo com sucesso.'));
                $produtorId = $this->request->getData('id_produtor');
                $redirectTo = $this->request->getData('redirect_to');

                if ($redirectTo === 'produtor_view' && $produtorId) {
                    return $this->redirect(['controller' => 'Produtores', 'action' => 'view', $produtorId]);
                }
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O produto cultivado não pôde ser salvo. Por favor, tente novamente.'));
                $errors = $produto->getErrors();
            }
        }

        $produtores = $this->ProdutosCultivados->Produtores->find('list')->all();
        $unidades = [
            'KG' => 'Quilograma (Kg)',
            'SACA' => 'Saca',
            'TONELADA' => 'Tonelada (t)',
            'DUZIA' => 'Dúzia',
            'UNIDADE' => 'Unidade',
            'MOLHO' => 'Molho',
            'CAIXA' => 'Caixa',
            'LITRO' => 'Litro (L)',
        ];
        $this->set(compact('produto', 'formTitle', 'id', 'successMessage', 'errorMessage', 'errors', 'produtores', 'unidades', 'produtorId'));
        $this->render('form');
    }

    /**
     * Edit method
     *
     * @param string|null $id ProdutosCultivado id.
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
     * @param string|null $id ProdutosCultivado id.
     * @return \Cake\Http\Response|null|void Redirects on successful delete, renders error on failure.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $produto = $this->ProdutosCultivados->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('O produto cultivado com o ID {0} não foi encontrado.', $id));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->ProdutosCultivados->delete($produto)) {
            $this->Flash->success(__('O produto foi excluído com sucesso.'));
        } else {
            $this->Flash->error(__('O produto não pôde ser excluído. Por favor, tente novamente.'));
        }
        $produtorId = $this->request->getData('id_produtor');
        $redirectTo = $this->request->getData('redirect_to');

        if ($redirectTo === 'produtor_view' && $produtorId) {
            return $this->redirect(['controller' => 'Produtores', 'action' => 'view', $produtorId]);
        }
        return $this->redirect(['action' => 'index']);
    }
}
