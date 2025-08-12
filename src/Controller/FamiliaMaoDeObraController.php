<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * FamiliaMaoDeObra Controller
 *
 * @property \App\Model\Table\FamiliaMaoDeObraTable $FamiliaMaoDeObra
 * @method \App\Model\Entity\FamiliaMaoDeObra[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FamiliaMaoDeObraController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $familiasMaoDeObra = $this->FamiliaMaoDeObra->find()
            ->contain(['Produtores'])->all();

        $this->set(name: compact('familiasMaoDeObra'));
    }

    /**
     * Salvar method (for add/edit)
     *
     * @param string|null $id_familia FamiliaMaoDeObra id.
     * @return \Cake\Http\Response|null|void Redirects on successful add/edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function add($id = null)
    {
        $produtorId = $this->request->getQuery('id_produtor'); // Retrieve from query string for initial load

        $errors = [];

        $formTitle = 'Cadastrar Nova Família Mão de Obra';
        if ($id) {
            $formTitle = 'Atualizar Família Mão de Obra';
            $familiaMaoDeObra = $this->FamiliaMaoDeObra->get($id, ['contain' => []]);
        } else {
            $familiaMaoDeObra = $this->FamiliaMaoDeObra->newEmptyEntity();
        }

        if ($this->request->is(['post', 'put'])) {
            $familiaMaoDeObra = $this->FamiliaMaoDeObra->patchEntity($familiaMaoDeObra, $this->request->getData());
            if ($this->FamiliaMaoDeObra->save($familiaMaoDeObra)) {
                $this->Flash->success(__('A família mão de obra foi salva com sucesso.'));
                $produtorId = $this->request->getData('id_produtor');
                $redirectTo = $this->request->getData('redirect_to');

                if ($redirectTo === 'produtor_view' && $produtorId) {
                    return $this->redirect(['controller' => 'Produtores', 'action' => 'view', $produtorId]);
                }
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('A família mão de obra não pôde ser salva. Por favor, tente novamente.'));
                $errors = $familiaMaoDeObra->getErrors();
            }
        }
        $produtores = $this->FamiliaMaoDeObra->Produtores->find('list')->all();
        $this->set(compact('familiaMaoDeObra', 'formTitle', 'id', 'errors', 'produtores', 'produtorId'));
        $this->render('form');
    }

    /**
     * Edit method
     *
     * @param string|null $id FamiliaMaoDeObra id.
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
     * @param string|null $id_familia FamiliaMaoDeObra id.
     * @return \Cake\Http\Response|null|void Redirects on successful delete, renders error on failure.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $familiaMaoDeObra = $this->FamiliaMaoDeObra->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('A família mão de obra com o ID {0} não foi encontrada.', $id));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->FamiliaMaoDeObra->delete($familiaMaoDeObra)) {
            $this->Flash->success(__('A família mão de obra foi excluída com sucesso.'));
        } else {
            $this->Flash->error(__('A família mão de obra não pôde ser excluída. Por favor, tente novamente.'));
        }

        $produtorId = $this->request->getData('id_produtor');
        $redirectTo = $this->request->getData('redirect_to');

        if ($redirectTo === 'produtor_view' && $produtorId) {
            return $this->redirect(['controller' => 'Produtores', 'action' => 'view', $produtorId]);
        }
        return $this->redirect(['action' => 'index']);
    }
}
