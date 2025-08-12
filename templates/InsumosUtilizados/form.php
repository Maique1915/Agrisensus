<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InsumoUtilizado $insumosUtilizado
 * @var array $produtores
 * @var array $unidades
 * @var string $formTitle
 * @var string|null $id
 */
?>

<div class="header">
    <h1><?= h($formTitle) ?></h1>
    <p>Preencha os dados do insumo utilizado.</p>
</div>

<div class="list-container">
    <?= $this->Form->create($insumosUtilizado, ['id' => 'insumoUtilizadoForm', 'url' => ['action' => 'add', $id ?? null]]) ?>
    <?= $this->Form->hidden('redirect_to', ['value' => $produtorId ? 'produtor_view' : 'insumos_utilizados_index']) ?>

    <?php if ($insumosUtilizado->getErrors()): ?>
        <div class="alert alert-danger">
            <strong>Por favor, corrija os seguintes erros:</strong>
            <ul>
                <?php foreach ($insumosUtilizado->getErrors() as $field => $errors): ?>
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
                'options' => [],
                'empty' => 'Selecione um produtor...',
                'class' => 'form-control select2-producer',
                'id' => 'produtor-select',
                'required' => true,
                'data-initial-value' => $insumosUtilizado->id_produtor ?? '',
                'data-initial-text-nome' => $insumosUtilizado->has('produtore') ? $insumosUtilizado->produtore->nome : '',
                'data-initial-text-cpf' => $insumosUtilizado->has('produtore') ? $insumosUtilizado->produtore->cpf : '',
            ]) ?>

            <div class="form-group">
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
    
    <!-- Primeira Linha: Nome e Local da Compra -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <?= $this->Form->control('nome', [
                'label' => 'Nome do Insumo',
                'class' => 'form-control',
                'placeholder' => 'Ex: Adubo, Semente',
                'data-mask-type' => 'uppercase-text'
            ]) ?>
        </div>
        <div class="form-group col-md-6">
            <?= $this->Form->control('local_compra', [
                'label' => 'Local de Compra',
                'class' => 'form-control',
                'placeholder' => 'Ex: Loja Agrícola',
                'data-mask-type' => 'uppercase-text'
            ]) ?>
        </div>
    </div>

    <!-- Segunda Linha: Quantidade, Unidade e Preço -->
    <div class="form-row">
        <div class="form-group col-md-4">
            <?= $this->Form->control('quantidade', [
                'label' => 'Quantidade',
                'class' => 'form-control',
                'placeholder' => '0,00',
                'data-mask-type' => 'float',
                'type' => 'text'
            ]) ?>
        </div>
        <div class="form-group col-md-4">
            <?= $this->Form->control('unidade', [
                'options' => $unidades,
                'empty' => 'Selecione',
                'label' => 'Unidade',
                'class' => 'form-control'
            ]) ?>
        </div>
        <div class="form-group col-md-4">
            <?= $this->Form->control('preco', [
                'label' => 'Preço (R$)',
                'class' => 'form-control',
                'placeholder' => '0,00',
                'data-mask-type' => 'float',
                'type' => 'text'
            ]) ?>
        </div>
    </div>

    <!-- Botões de Ação -->
    <div class="form-actions">
        <?= $this->Form->button(($id ?? null) == null ? 'Salvar' : 'Atualizar', [
            'type' => 'submit',
            'class' => 'btn btn-primary',
            'id' => 'form-feedback-container'
        ]) ?>
        <?= $this->Html->link(($id ?? null) == null ? 'Voltar' : 'Cancelar', $produtorId ? ['controller' => 'Produtores', 'action' => 'view', $produtorId] : ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<?php $this->append(name: 'script'); ?>
<?= $this->Html->script(url: 'producer-select'); ?>
<?= $this->Html->script(url: 'insumos-utilizados'); ?>
<?= $this->Html->script(url: 'form-all'); ?>
<?php $this->end(); ?>