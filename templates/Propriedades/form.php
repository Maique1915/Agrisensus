<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Propriedade $propriedade
 * @var array $produtores
 * @var array $ufs
 * @var array $relacoes
 * @var array $areas
 * @var string $formTitle
 * @var string|null $id
 */
?>

<div class="header">
    <h1><?= h($formTitle) ?></h1>
    <p>Preencha os dados da propriedade rural.</p>
</div>

<div class="list-container">
    <?= $this->Form->create($propriedade, ['id' => 'propriedadeForm', 'url' => ['action' => 'add', $id]]) ?>
    <?= $this->Form->hidden('redirect_to', ['value' => $produtorId ? 'produtor_view' : 'propriedades_index']) ?>

    

    <?php if ($propriedade->getErrors()): ?>
        <div class="alert alert-danger">
            <strong>Por favor, corrija os seguintes erros:</strong>
            <ul>
                <?php foreach ($propriedade->getErrors() as $field => $errors): ?>
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
                'data-initial-value' => $propriedade->id_produtor ?? '',
                'data-initial-text-nome' => $propriedade->has('produtor') ? $propriedade->produtor->nome : '',
                'data-initial-text-cpf' => $propriedade->has('produtor') ? $propriedade->produtor->cpf : '',
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
    <div class="form-container">

        <!-- Nome e Endereço -->
        <div class="form-row">
            <div class="form-group col-md-12">
                <?= $this->Form->control('nome_propriedade', ['label' => 'Nome da Propriedade', 'class' => 'form-control', 'placeholder' => 'Ex: Sítio Santo Antônio', 'data-mask-type' => 'uppercase-text']) ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <?= $this->Form->control('comunidade', ['class' => 'form-control', 'placeholder' => 'Ex: Jacó, Brejal', 'data-mask-type' => 'uppercase-text']) ?>
            </div>
            <div class="form-group col-md-6">
                <?= $this->Form->control('localidade', ['class' => 'form-control', 'placeholder' => 'Ex: Posse, Itaipava', 'data-mask-type' => 'uppercase-text']) ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <?= $this->Form->control('bairro', ['class' => 'form-control', 'placeholder' => 'Nome do Bairro', 'data-mask-type' => 'uppercase-text']) ?>
            </div>
            <div class="form-group col-md-3">
                <?= $this->Form->control('numero', ['type' => 'number', 'class' => 'form-control', 'placeholder' => 'Número', 'data-mask-type' => 'numeric']) ?>
            </div>
            <div class="form-group col-md-3">
                <?= $this->Form->control('cep', ['class' => 'form-control', 'placeholder' => '00000-000', 'data-mask-type' => 'cep']) ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-9">
                <?= $this->Form->control('cidade', ['class' => 'form-control', 'placeholder' => 'Cidade', 'data-mask-type' => 'uppercase-text']) ?>
            </div>
            <div class="form-group col-md-3">
                <?= $this->Form->control('estado', ['options' => array_combine($ufs, $ufs), 'empty' => 'Selecione', 'class' => 'form-control', 'value' => $propriedade->estado ?: 'RJ']) ?>
            </div>
        </div>

        <!-- Detalhes da Propriedade -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <?= $this->Form->control('relacao_propriedade', [
                    'label' => 'Relação com a Propriedade',
                    'options' => array_combine($relacoes, $relacoes),
                    'empty' => 'Selecione',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="form-group col-md-6 checkbox-group-align">
                <br>
                <?= $this->Form->control('terreno', [
                    'type' => 'checkbox',
                    'label' => 'O terreno está no nome do produtor?',
                    'class' => 'form-check-input'
                ]) ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <?= $this->Form->control('area_total', [
                    'label' => 'Área total',
                    'options' => array_combine($areas, $areas),
                    'empty' => 'Selecione',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="form-group col-md-6">
                <?= $this->Form->control('unidade', [
                    'label' => 'Unidade',
                    'type' => 'select',
                    'options' => $unidades,
                    'empty' => 'Selecione',
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>


        <!-- Complemento -->
        <div class="form-row">
            <div class="form-group col-md-12">
                <?= $this->Form->control('complemento', ['type' => 'textarea', 'rows' => 2, 'class' => 'form-control', 'placeholder' => 'Apartamento, Bloco, Referência', 'data-mask-type' => 'uppercase-text']) ?>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="form-actions">
            <?= $this->Form->button($id == null ? 'Salvar' : 'Atualizar', ['type' => 'submit', 'class' => 'btn btn-primary']) ?>
            <?= $this->Html->link($id == null ? 'Voltar' : 'Cancelar', $produtorId ? ['controller' => 'Produtores', 'action' => 'view', $produtorId] : ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
        </div>


        <?= $this->Form->end() ?>

        <?php $this->append(name: 'script'); ?>
        <?= $this->Html->script(url: 'producer-select'); ?>
        <?= $this->Html->script(url: 'form-all'); ?>
        <?php $this->end(); ?>