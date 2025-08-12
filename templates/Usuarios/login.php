<div class="login-page">
    <div class="login-container">

        <!-- Logotipo da Aplicação -->
        <div class="login-logo">
            <span class="fas fa-seedling"></span> <!-- Ícone, se estiver usando Font Awesome -->
            <h1>AgriCensus</h1>
        </div>

        <!-- Cabeçalho do formulário -->
        <div class="login-header">
            <h2>Acessar sua Conta</h2>
            <p>Bem-vindo de volta! Insira suas credenciais para continuar.</p>
        </div>

        <!-- Renderiza as mensagens de erro (ex: "Usuário ou senha inválidos") -->
        <?= $this->Flash->render() ?>

        <!-- Formulário -->
        <?= $this->Form->create(null, ['class' => 'login-form']) ?>
        <fieldset>
            <!-- A legenda é importante para acessibilidade, mas vamos escondê-la visualmente -->
            <legend class="sr-only"><?= __('Please enter your username and password') ?></legend>

            <?= $this->Form->control('matricula', [
                'label' => 'Matrícula',
                'placeholder' => 'Digite sua matrícula',
                'data-mask-type' => 'uppercase',
                'required' => true
            ]) ?>

            <?= $this->Form->control('senha', [
                'type' => 'password',
                'label' => 'Senha',
                'placeholder' => 'Digite sua senha',
                'required' => true
            ]) ?>
        </fieldset>

        <?= $this->Form->submit(__('Entrar'), ['class' => 'btn-login']) ?>

        <?= $this->Form->end() ?>
    </div>
</div>
<?php $this->append(name: 'script'); ?>
<?= $this->Html->script('app-masks'); ?>
<?php $this->end(); ?>