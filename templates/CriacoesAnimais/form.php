<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CriacaoAnimai $criacaoAnimai
 
 * @var string $formTitle
 * @var string|null $id
 */
?>

<div class="header">
    <h1><?= h($formTitle) ?></h1>
    <p>Preencha os dados da criação de animais.</p>
</div>

<div class="list-container">
    <?= $this->Form->create($criacaoAnimai, ['id' => 'criacoesAnimaisForm', 'url' => ['action' => 'add', $id]]) ?>
    <?= $this->Form->hidden('redirect_to', ['value' => $produtorId ? 'produtor_view' : 'criacoes_animais_index']) ?>

    <?php if (isset($criacaoAnimai) && $criacaoAnimai->getErrors()): ?>
        <div class="alert alert-danger">
            <strong>Por favor, corrija os seguintes erros:</strong>
            <ul>
                <?php foreach ($criacaoAnimai->getErrors() as $field => $errors): ?>
                    <?php foreach ($errors as $error): ?>
                        <li><?= h($error) ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <div class="form-row col-md-12">
            <?= $this->Form->control('id_produtor', [
                'label' => 'Produtor Associado <span class="required">*</span>',
                'escape' => false,
                'options' => [], // As opções são carregadas via AJAX
                'empty' => 'Selecione um produtor...',
                'class' => 'form-control select2-producer',
                'id' => 'produtor-select',
                'required' => true,
                'data-initial-value' => $criacaoAnimai->id_produtor ?? '',
                'data-initial-text-nome' => $criacaoAnimai->has('produtor') ? $criacaoAnimai->produtor->nome : '',
                'data-initial-text-cpf' => $criacaoAnimai->has('produtor') ? $criacaoAnimai->produtor->cpf : '',
            ]) ?>
            <div class="form-group">
                <br>
                <div class="form-row">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="search_by_name">Nome</label>
                        <input class="form-check-input" type="radio" name="search_type" id="search_by_name" value="nome"
                            checked>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="search_by_cpf">CPF</label>
                        <input class="form-check-input" type="radio" name="search_type" id="search_by_cpf" value="cpf">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Primeira linha: Espécie e Raça -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <?= $this->Form->control('especie', [
                'label' => 'Espécie', 
                'class' => 'form-control', 
                'placeholder' => 'Ex: Bovino, Suíno, Galinha', 
                'data-mask-type' => 'uppercase-text'
            ]) ?>
        </div>
        <div class="form-group col-md-6">
            <?= $this->Form->control('raca', [
                'label' => 'Raça', 
                'class' => 'form-control', 
                'placeholder' => 'Ex: Nelore, Yorkshire', 
                'data-mask-type' => 'uppercase-text'
            ]) ?>
        </div>
    </div>

    <!-- Segunda linha: Quantidade e Unidade -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <?= $this->Form->control('quantidade', [
                'type' => 'text', 
                'class' => 'form-control', 
                'data-mask-type' => 'float',
                'label' => 'Quantidade' // Adicionado label para consistência
            ]) ?>
        </div>
        <div class="form-group col-md-6">
            <?= $this->Form->control('unidade', [
                'label' => 'Unidade',
                'type' => 'select',
                'options' => array_combine($unidades, $unidades),
                'empty' => 'Selecione',
                'class' => 'form-control'
            ]) ?>
        </div>
    </div>
    
    <!-- Terceira linha: Finalidade -->
    <div class="form-row">
        <div class="form-group col-md-12">
             <?= $this->Form->control('finalidade', [
                'type' => 'text', 
                'class' => 'form-control', 
                'data-mask-type' => 'uppercase-text',
                'label' => 'Finalidade' // Adicionado label para consistência
             ]) ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <?= $this->Form->control('realiza_exame', [
                'type' => 'checkbox',
                'label' => 'Realiza Exame',
                'class' => 'form-check-input'
            ]) ?>
        </div>
        <div class="form-group col-md-6">
            <?= $this->Form->control('vacinado', [
                'type' => 'checkbox',
                'label' => 'Vacinado',
                'class' => 'form-check-input'
            ]) ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <?= $this->Form->control('tipo_exame', [
                'label' => 'Tipo de Exame',
                'class' => 'form-control',
                'placeholder' => 'Ex: Brucelose, Tuberculose'
            ]) ?>
        </div>
        <div class="form-group col-md-6">
            <?= $this->Form->control('tipo_vacinacao', [
                'label' => 'Tipo de Vacinação',
                'class' => 'form-control',
                'placeholder' => 'Ex: Raiva, Febre Aftosa'
            ]) ?>
        </div>
    </div>

    <!-- Botões de Ação -->
    <div class="form-actions">
        <?= $this->Form->button($id == null ? 'Salvar' : 'Atualizar', [
            'type' => 'submit', 
            'class' => 'btn btn-primary', 
            'id' => 'form-feedback-container', 
            'data-criacao-animal-id' => $id
        ]) ?>
        <?= $this->Html->link($id == null ? 'Voltar' : 'Cancelar', $produtorId ? ['controller' => 'Produtores', 'action' => 'view', $produtorId] : ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>


    <?= $this->Form->end() ?>
</div>

<?php $this->append(name: 'script'); ?>
<?= $this->Html->script(url: 'producer-select'); ?>
<?= $this->Html->script(url: 'form-all'); ?>
<?php $this->end(); ?>