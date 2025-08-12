<?php
$currentController = $this->request->getParam('controller');
$currentAction = $this->request->getParam('action');

// Helper function to check if a link is active
function isActive($controller, $action, $currentController, $currentAction) {
    return ($controller === $currentController && $action === $currentAction) ? 'active' : '';
}
?>
<nav class="sidebar">
        <div class="logo">
            <span class="fas fa-seedling">AgriCensus</span>
        </div>
        <ul class="menu-items">
            <li><?= $this->Html->link('<i class="fas fa-tachometer-alt"></i> Dashboard', ['controller' => 'Pages', 'action' => 'display', 'home'], ['escape' => false, 'class' => isActive('Pages', 'display', $currentController, $currentAction)]) ?></li>
            <li><?= $this->Html->link('<i class="fas fa-users"></i> Produtores', ['controller' => 'Produtores', 'action' => 'index'], ['escape' => false, 'class' => isActive('Produtores', 'index', $currentController, $currentAction)]) ?></li>
            <li><?= $this->Html->link('<i class="fas fa-handshake"></i> Família Mão de Obra', ['controller' => 'FamiliaMaoDeObra', 'action' => 'index'], ['escape' => false, 'class' => isActive('FamiliaMaoDeObra', 'index', $currentController, $currentAction)]) ?></li>
            <li><?= $this->Html->link('<i class="fas fa-home"></i> Propriedades', ['controller' => 'Propriedades', 'action' => 'index'], ['escape' => false, 'class' => isActive('Propriedades', 'index', $currentController, $currentAction)]) ?></li>
            <li><?= $this->Html->link('<i class="fas fa-paw"></i> Criações Animais', ['controller' => 'CriacoesAnimais', 'action' => 'index'], ['escape' => false, 'class' => isActive('CriacoesAnimais', 'index', $currentController, $currentAction)]) ?></li>   
            <li><?= $this->Html->link('<i class="fas fa-spray-can"></i> Insumos Utilizados', ['controller' => 'InsumosUtilizados', 'action' => 'index'], ['escape' => false, 'class' => isActive('InsumosUtilizados', 'index', $currentController, $currentAction)]) ?></li>
            <li><?= $this->Html->link('<i class="fas fa-user-cog"></i> Perfil Gerencial', ['controller' => 'PerfilGerencial', 'action' => 'index'], ['escape' => false, 'class' => isActive('PerfilGerencial', 'index', $currentController, $currentAction)]) ?></li>
            <li><?= $this->Html->link('<i class="fas fa-seedling"></i> Produtos Cultivados', ['controller' => 'ProdutosCultivados', 'action' => 'index'], ['escape' => false, 'class' => isActive('ProdutosCultivados', 'index', $currentController, $currentAction)]) ?></li>
            
            <?php if (!empty($loggedInUser) && $loggedInUser->grupo): // Assumindo que 'isAdmin' é uma propriedade do objeto de usuário logado ?>
            <hr>
            <li><?= $this->Html->link('<i class="fas fa-users-cog"></i> Usuários', ['controller' => 'Usuarios', 'action' => 'index'], ['escape' => false, 'class' => isActive('Usuarios', 'index', $currentController, $currentAction)]) ?></li>
            <?php endif; ?>
        </ul>
        <a href="<?= $this->Url->build(['controller' => 'Usuarios', 'action' => 'perfil']) ?>" class="user-profile-link <?= isActive('Usuarios', 'perfil', $currentController, $currentAction) ?>">
            <div class="user-profile">
                <i class="fas fa-user"></i>
                <div class="user-info">
                    <?php if (!empty($loggedInUser)): ?>
                    <span class="username"><?= h($loggedInUser->nome) ?></span>
                    <span class="email"><?= h($loggedInUser->matricula) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </a>

        <div class="logout-section">
            <?= $this->Html->link(
                '<i class="fas fa-sign-out-alt"></i> Sair',
                ['controller' => 'Usuarios', 'action' => 'logout'], // Assumindo um controller Usuarios e ação logout
                ['class' => 'btn btn-logout', 'escape' => false]
            ) ?>
        </div>
    </nav>