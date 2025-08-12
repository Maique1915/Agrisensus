<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsuariosTable $Usuarios
 * @method \App\Model\Entity\Usuario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsuariosController extends AppController
{
    /**
     * Initialize method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('FormProtection');
        $this->Authentication->allowUnauthenticated(['login', 'logout']);
        $this->FormProtection->setConfig('unlockedActions', ['login']);
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // If the user is logged in send them to the welcome page
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';

            return $this->redirect($target);
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    /**
     * Logout method
     *
     * @return \Cake\Http\Response|null|void Redirects to login
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Authentication->logout();

            return $this->redirect(['controller' => 'Usuarios', 'action' => 'login']);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $usuarios = $this->paginate($this->Usuarios);

        $this->set(compact('usuarios'));
    }

    public function add($id = null)
    {
        $formTitle = 'Cadastrar Novo Usuário';
        if ($id) {
            $formTitle = 'Atualizar Usuário';
            $usuario = $this->Usuarios->get($id);
        } else {
            $usuario = $this->Usuarios->newEmptyEntity();
        }

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            // Handle password change
            if (!empty(trim($data['senha']))) {
                $usuario->senha = $data['senha']; // The setter in the entity should hash it
            } else {
                // Remove password fields from data if not changing password
                unset($data['senha']);
                unset($data['confirma_senha']);
            }

            $usuario = $this->Usuarios->patchEntity($usuario, $data);

            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success(__('O usuário foi salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O usuário não pôde ser salvo. Por favor, tente novamente.'));
            }
        }

        $this->set(compact('usuario', 'formTitle', 'id'));
        $this->render('add'); // Render the add.php template
    }

    public function edit($id = null)
    {
        return $this->add($id);
    }

    public function perfil()
    {
        $userId = $this->Authentication->getIdentity()->get('id');
        $usuario = $this->Usuarios->get($userId);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            // Handle password change
            if (!empty($data['novaSenha'])) {
                $usuario->senha = $data['novaSenha']; // The setter in the entity should hash it
            } else {
                // Remove password fields from data if not changing password
                unset($data['novaSenha']);
                unset($data['confirmaSenha']);
            }

            $usuario = $this->Usuarios->patchEntity($usuario, $data, [
                // Add fields that are mass assignable
                'fields' => ['nome', 'matricula', 'cpf', 'senha']
            ]);

            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success(__('Seu perfil foi atualizado com sucesso.'));
                return $this->redirect(['action' => 'perfil']);
            } else {
                $this->Flash->error(__('Não foi possível atualizar seu perfil. Por favor, tente novamente.'));
            }
        }

        $this->set(compact('usuario'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usuario = $this->Usuarios->get($id);

        if ($this->Usuarios->delete($usuario)) {
            $this->Flash->success(__('O usuário foi excluído com sucesso.'));
        } else {
            $this->Flash->error(__('O usuário não pôde ser excluído. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}