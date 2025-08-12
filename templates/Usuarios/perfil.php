<section layout:fragment="content" class="produtores-content">
    <div class="produtores-header">
        <h1>Meu Perfil</h1>
        <p>Visualize e atualize suas informações pessoais.</p>
    </div>

    <div class="produtores-list-container">
        <?= $this->Form->create($usuario, ['id' => 'profileForm', 'url' => ['action' => 'perfil']]) ?>
            <?= $this->Form->hidden('id') ?>
            <?php if ($usuario->getErrors()): ?>
                <div class="alert alert-danger">
                    <strong>Por favor, corrija os seguintes erros:</strong>
                    <ul>
                        <?php foreach ($usuario->getErrors() as $field => $errors): ?>
                            <?php foreach ($errors as $error): ?>
                                <li><?= h($error) ?></li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <h3 class="form-section-title">Informações Pessoais</h3>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="nome">Nome Completo</label>
                    <?= $this->Form->control('nome', ['class' => 'form-control', 'data-mask-type' => 'uppercase-all', 'readonly' => true, 'label' => false]) ?>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="matricula">Matrícula (Login)</label>
                    <?= $this->Form->control('matricula', ['class' => 'form-control', 'readonly' => true, 'label' => false]) ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="cpf">CPF</label>
                    <?= $this->Form->control('cpf', ['class' => 'form-control', 'data-mask-type' => 'cpf', 'readonly' => true, 'label' => false]) ?>
                </div>
            </div>

            <!-- ============================================== -->
            <!--    SEÇÃO DE SENHA - SÓ APARECE NO MODO EDIÇÃO  -->
            <!-- ============================================== -->
            <div id="passwordSection" style="display: none;">
                <h3 class="form-section-title">Alterar Senha</h3>
                <p class="form-subtitle">Deixe os campos abaixo em branco para manter sua senha atual.</p>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="novaSenha">Nova Senha</label>
                        <input type="password" class="form-control" id="novaSenha" name="novaSenha" placeholder="Digite a nova senha" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="confirmaSenha">Confirmar Senha</label>
                        <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha" placeholder="Confirme a nova senha" />
                    </div>
                </div>
            </div>
            
            <!-- ============================================== -->
            <!--       BOTÕES DINÂMICOS - MUDAM COM O MODO      -->
            <!-- ============================================== -->
            <div class="form-actions">
                <!-- Botão de Edição (modo visualização) -->
                <button type="button" id="btnEdit" class="btn btn-primary">Editar Perfil</button>
                <?= $this->Html->link('Voltar', ['controller' => 'Usuarios', 'action' => 'index'], ['class' => 'btn btn-secondary']) ?>

                <!-- Botões de Ação (modo edição) -->
                <div id="editActions" style="display: none;">
                    <button type="submit" id="btnSave" class="btn btn-primary">Salvar Alterações</button>
                    <button type="button" id="btnCancel" class="btn btn-secondary">Cancelar</button>
                </div>
            </div>
        <?= $this->Form->end() ?>
    </div>
</section>

<?php $this->append('script'); ?>
<?= $this->Html->script('producer-select'); ?>
<?= $this->Html->script('form-all'); ?>
<?= $this->Html->script('perfil'); ?>
<?php $this->end(); ?>