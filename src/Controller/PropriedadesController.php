<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Propriedades Controller
 *
 * @property \App\Model\Table\PropriedadesTable $Propriedades
 * @method \App\Model\Entity\Propriedade[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PropriedadesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {        
        $propriedades = $this->Propriedades->find()->contain(['Produtores' => ['joinType' => 'INNER']]);
        
        $this->set(compact('propriedades'));
    }

    /**
     * Add method (também usado pelo edit)
     *
     * @param string|null $id Propriedade id.
     * @return \Cake\Http\Response|null|void Redireciona ao salvar com sucesso, ou renderiza a view.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function add($id = null)
    {
        $produtorId = $this->request->getQuery('id_produtor'); // Retrieve from query string for initial load

        $formTitle = 'Cadastrar Nova Propriedade';
        if ($id) {
            $propriedade = $this->Propriedades->get($id, [
                'contain' => ['Produtores'], // Garante que os dados do produtor sejam carregados
            ]);
            $formTitle = 'Editar Propriedade';
        } else {
            $propriedade = $this->Propriedades->newEmptyEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            // Converte explicitamente o valor do checkbox 'terreno' para 0 ou 1
            $data['terreno'] = isset($data['terreno']) && $data['terreno'] == '1';
            $propriedade = $this->Propriedades->patchEntity($propriedade, $data);
            if ($this->Propriedades->save($propriedade)) {
                    $this->Flash->success(__('A propriedade foi salva com sucesso.'));
                    $produtorId = $this->request->getData('id_produtor');
                    $redirectTo = $this->request->getData('redirect_to');

                    if ($redirectTo === 'produtor_view' && $produtorId) {
                        return $this->redirect(['controller' => 'Produtores', 'action' => 'view', $produtorId]);
                    }
                    return $this->redirect(['action' => 'index']);
                }
            $errors = $propriedade->getErrors();
            $errorMessage = 'A propriedade não pôde ser salva. Por favor, corrija os erros abaixo:';
            foreach ($errors as $field => $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $errorMessage .= "\n- " . $error;
                }
            }
            $this->Flash->error($errorMessage);
        }

        // Busca a lista de produtores para o dropdown (formato 'id' => 'nome')
        $produtores = $this->Propriedades->Produtores->find('list')->all();
        
        // Listas para os campos <select> )
        $ufs = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
        $relacoes = ['Proprietário', 'Arrendatário', 'Parceiro', 'Meeiro', 'Outro'];
        $areas = ['0 a 10', 'Menos de 1', '1 a 5', '5 a 10', '10 a 50', '50 a 100', 'Mais de 100'];
        $unidades = ['m²' => 'm²', 'ha' => 'Hectare (ha)', 'km²' => 'Km²', 'alqueire' => 'Alqueire', 'tarefa' => 'Tarefa'];
        $this->set(compact('propriedade', 'formTitle', 'produtores', 'ufs', 'relacoes', 'areas', 'unidades', 'id', 'produtorId'));
        $this->render('form');
    }

    /**
     * Edit method
     *
     * @param string|null $id Propriedade id.
     * @return \Cake\Http\Response|null|void
     */
    public function edit($id = null)
    {
        // Reutiliza a lógica do método add
        return $this->add($id);
    }

    /**
     * Delete method
     *
     * @param string|null $id Propriedade id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $propriedade = $this->Propriedades->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('A propriedade com o ID {0} não foi encontrada.', $id));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Propriedades->delete($propriedade)) {
            $this->Flash->success(__('A propriedade foi excluída com sucesso.'));
        } else {
            $this->Flash->error(__('A propriedade não pôde ser excluída. Por favor, tente novamente.'));
        }

        $produtorId = $this->request->getData('id_produtor');
        $redirectTo = $this->request->getData('redirect_to');

        if ($redirectTo === 'produtor_view' && $produtorId) {
            return $this->redirect(['controller' => 'Produtores', 'action' => 'view', $produtorId]);
        }
        return $this->redirect(['action' => 'index']);
    }
}