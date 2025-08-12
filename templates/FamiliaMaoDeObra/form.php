<?php
declare(strict_types=1);

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FamiliaMaoDeObra $familiaMaoDeObra
 * @var array $produtores
 * @var string $formTitle
 * @var string|null $id
 */
?>

<div class="header">
    <h1><?= h($formTitle) ?></h1>
    <p>Preencha os dados da família e mão de obra.</p>
</div>

<div class="list-container">
    <?= $this->Form->create($familiaMaoDeObra, ['id' => 'familiaMaoDeObraForm', 'url' => ['action' => 'add', $id ?? null]]) ?>
    <?= $this->Form->hidden('redirect_to', ['value' => $produtorId ? 'produtor_view' : 'familia_mao_de_obra_index']) ?>

    <?php if (isset($familiaMaoDeObra) && $familiaMaoDeObra->getErrors()): ?>
        <div class="alert alert-danger">
            <strong>Por favor, corrija os seguintes erros:</strong>
            <ul>
                <?php foreach ($familiaMaoDeObra->getErrors() as $field => $errors): ?>
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
                'data-initial-value' => $familiaMaoDeObra->id_produtor ?? '',
                'data-initial-text-nome' => $familiaMaoDeObra->has('produtor') ? $familiaMaoDeObra->produtor->nome : '',
                'data-initial-text-cpf' => $familiaMaoDeObra->has('produtor') ? $familiaMaoDeObra->produtor->cpf : '',
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

    <!-- Faixas etárias -->
    <div class="form-row">
        <div class="form-group col-md-4">
            <?= $this->Form->control('ate_sete', [
                'label' => 'Até 7 anos',
                'type' => 'text',
                'data-mask-type' => 'numeric',
                'class' => 'form-control',
                'min' => 0
            ]) ?>
        </div>
        <div class="form-group col-md-4">
            <?= $this->Form->control('oito_quinze', [
                'label' => '8 a 15 anos',
                'type' => 'text',
                'data-mask-type' => 'numeric',
                'class' => 'form-control',
                'min' => 0
            ]) ?>
        </div>
        <div class="form-group col-md-4">
            <?= $this->Form->control('dezesseis_vintecinco', [
                'label' => '16 a 25 anos',
                'type' => 'text',
                'data-mask-type' => 'numeric',
                'class' => 'form-control',
                'min' => 0
            ]) ?>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <?= $this->Form->control('vintecinco_sessentacinco', [
                'label' => '26 a 65 anos',
                'type' => 'text',
                'data-mask-type' => 'numeric',
                'class' => 'form-control',
                'min' => 0
            ]) ?>
        </div>
        <div class="form-group col-md-6">
            <?= $this->Form->control('mais_sessentacinco', [
                'label' => 'Mais de 65 anos',
                'type' => 'text',
                'data-mask-type' => 'numeric',
                'class' => 'form-control',
                'min' => 0
            ]) ?>
        </div>
    </div>

    <!-- Quantidades -->
    <div class="form-row">
        <div class="form-group col-md-4">
            <?= $this->Form->control('qtd_familia_producao', [
                'label' => 'Qtd. Família na Produção',
                'type' => 'text',
                'data-mask-type' => 'numeric',
                'class' => 'form-control',
                'min' => 0
            ]) ?>
        </div>
        <div class="form-group col-md-4">
            <?= $this->Form->control('qtd_empregados', [
                'label' => 'Qtd. Empregados',
                'type' => 'text',
                'data-mask-type' => 'numeric',
                'class' => 'form-control',
                'min' => 0
            ]) ?>
        </div>
        <div class="form-group col-md-4">
            <?= $this->Form->control('total_dependentes', [
                'label' => 'Total de Dependentes',
                'type' => 'text',
                'data-mask-type' => 'numeric',
                'class' => 'form-control',
                'min' => 0
            ]) ?>
        </div>
    </div>

    <!-- Botões de Ação -->
    <div class="form-actions">
        <?= $this->Form->button(($id ?? null) == null ? 'Salvar' : 'Atualizar', [
            'type' => 'submit',
            'class' => 'btn btn-primary'
        ]) ?>
        <?= $this->Html->link(($id ?? null) == null ? 'Voltar' : 'Cancelar', $produtorId ? [
            'controller' => 'Produtores',
            'action' => 'view',
            $produtorId
        ] : ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<?php $this->append(name: 'script'); ?>
<?= $this->Html->script(url: 'producer-select'); ?>
<?= $this->Html->script(url: 'form-all'); ?>
<?php $this->end(); ?>