<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Usuario $usuario
 * @var string $formTitle
 */
?>
    <div class="header">
        <h1><?= $id == null ? "Adicionar novo usuário" : "Atualizar Usuário" ?></h1>
        <p>Preencha os dados do usuário.</p>
    </div>

    <div class="list-container">
        <?= $this->Form->create($usuario, ['url' => ['action' => 'add', $id]]) ?>

        <?= $this->Form->hidden('id') ?>

        <div class="form-row">
            <div class="form-group col-md-8">
                <?= $this->Form->control('nome', [
                    'label' => 'Nome <span class="required">*</span>',
                    'escape' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nome Completo do Usuário',
                    'required' => true,
                    'maxlength' => 255,
                    'data-mask-type' => 'uppercase-text',
                ]) ?>
            </div>
            <div class="form-group col-md-4">
                <?= $this->Form->control('matricula', [
                    'label' => 'Matrícula <span class="required">*</span>',
                    'escape' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Matrícula do Usuário',
                    'required' => true,
                    'maxlength' => 50,
                    'data-mask-type' => 'uppercase',

                ]) ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <?= $this->Form->control('cpf', [
                    'label' => 'CPF',
                    'class' => 'form-control',
                    'placeholder' => '000.000.000-00',
                    'maxlength' => 14,
                    'oninput' => 'window.AppMasks.maskCPF(this)'
                ]) ?>
            </div>
            <div class="form-group col-md-6">
                <br>
                <br>
                <?= $this->Form->control('grupo', [
                    'label' => 'Grupo',
                    'class' => 'form-control',
                    'placeholder' => 'Grupo do Usuário',
                    'maxlength' => 50,
                ]) ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <?= $this->Form->control('senha', [
                    'label' => 'Senha',
                    'type' => 'password',
                    'class' => 'form-control',
                    'placeholder' => 'Deixe em branco para não alterar',
                ]) ?>
            </div>
            <div class="form-group col-md-6">
                <?= $this->Form->control('confirma_senha', [
                    'label' => 'Confirmar Senha',
                    'type' => 'password',
                    'class' => 'form-control',
                    'placeholder' => 'Confirme a senha',
                ]) ?>
            </div>
        </div>

        <div class="form-actions">
            <?= $this->Form->button($id == null ? 'Salvar' : 'Atualizar', ['type' => 'submit', 'class' => 'btn btn-primary', 'id'=> 'form-feedback-container', 'data-user-id' => $id]) ?>
            <?= $this->Html->link($id == null ? 'Voltar' : 'Cancelar', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
<?php $this->append(name: 'script'); ?>
<?= $this->Html->script('app-masks'); ?>
<?php $this->end(); ?>