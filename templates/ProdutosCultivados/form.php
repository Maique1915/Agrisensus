<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProdutoCultivado $produto
 * @var array $produtores
 * @var string $formTitle
 * @var string|null $id
 */
?>

<div class="header">
    <h1><?= h($formTitle) ?></h1>
    <p>Preencha os dados do produto cultivado.</p>
</div>

<div class="list-container">
    <?= $this->Form->create($produto, ['id' => 'produtoForm', 'url' => ['action' => 'add', $id ?? null]]) ?>
    <?= $this->Form->hidden('redirect_to', ['value' => $produtorId ? 'produtor_view' : 'produtos_cultivados_index']) ?>

    <?php if ($produto->getErrors()): ?>
        <div class="alert alert-danger">
            <strong>Por favor, corrija os seguintes erros:</strong>
            <ul>
                <?php foreach ($produto->getErrors() as $field => $errors): ?>
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
                'data-initial-value' => $produto->id_produtor ?? '',
                'data-initial-text-nome' => $produto->has('produtor') ? $produto->produtore->nome : '',
                'data-initial-text-cpf' => $produto->has('produtor') ? $produto->produtore->cpf : '',
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

    <!-- Primeira Linha: Nome do Produto e Preço -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <?= $this->Form->control('nome', [
                'label' => 'Nome do Produto', 
                'class' => 'form-control', 
                'placeholder' => 'Ex: Alface, Tomate', 
                'data-mask-type' => 'uppercase-text'
            ]) ?>
        </div>
        <div class="form-group col-md-6">
            <?= $this->Form->control('preco', [
                'label' => 'Preço (R$)', 
                'class' => 'form-control', 
                'placeholder' => '0,00', 
                'data-mask-type' => 'money'
            ]) ?>
        </div>
    </div>

    <!-- Segunda Linha: Produção, Unidade e Receita -->
    <div class="form-row">
        <div class="form-group col-md-4">
            <?= $this->Form->control('producao_anual', [
                'label' => 'Produção Anual', 
                'class' => 'form-control', 
                'placeholder' => '0,00', 
                'data-mask-type' => 'money'
            ]) ?>
        </div>
        <div class="form-group col-md-4">
            <?= $this->Form->control('unidade', [
                'label' => 'Unidade',
                'type' => 'select',
                'options' => $unidades,
                'empty' => 'Selecione',
                'class' => 'form-control'
            ]) ?>
        </div>
        <div class="form-group col-md-4">
            <?= $this->Form->control('receita_total', [
                'label' => 'Receita Total (R$)', 
                'class' => 'form-control', 
                'placeholder' => '0,00', 
                'data-mask-type' => 'money'
                /*, 'readonly' => true*/
            ]) ?>
        </div>
    </div>

    <!-- Terceira Linha: Período da Colheita -->
    <div class="form-row">
        <div class="form-group col-md-12">
            <?= $this->Form->control('periodo_colheita', [
                'label' => 'Período da Colheita', 
                'class' => 'form-control', 
                'placeholder' => 'Ex: Janeiro a Março', 
                'data-mask-type' => 'uppercase-text'
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
<?= $this->Html->script(url: 'produtos-cultivados'); ?>
<?= $this->Html->script(url: 'form-all'); ?>
<?php $this->end(); ?>