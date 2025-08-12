<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Produtore $produtor
 * @var string $formTitle
 */
?>
    <div class="header">
        <h1><?= $id == null ? "Adicionar novo produtor" : "Atualizar Produtor" ?></h1>
        <p>Preencha os dados do produtor rural.</p>
    </div>

    <div class="list-container">
        <?= $this->Form->create($produtor, ['url' => ['action' => 'add', $id]]) ?>

        <?= $this->Form->hidden('id') ?>

        <div class="form-row">
            <div class="form-group col-md-8">
                <?= $this->Form->control('nome', [
                    'label' => 'Nome <span class="required">*</span>',
                    'escape' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nome Completo do Produtor',
                    'required' => true,
                    'maxlength' => 255,
                    'oninput' => 'window.AppMasks.formatUppercaseAlpha(this)'
                ]) ?>
            </div>
            <div class="form-group col-md-4">
                <?= $this->Form->control('telefone', [
                    'label' => 'Telefone',
                    'class' => 'form-control',
                    'placeholder' => '(XX) XXXXX-XXXX',
                    'maxlength' => 15,
                    'oninput' => 'window.AppMasks.maskPhone(this)'
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
                <?= $this->Form->control('cnpj', [
                    'label' => 'CNPJ',
                    'class' => 'form-control',
                    'placeholder' => '00.000.000/0000-00',
                    'maxlength' => 18,
                    'oninput' => 'window.AppMasks.maskCNPJ(this)'
                ]) ?>
            </div>
        </div>

        <div class="form-actions">
            <?= $this->Form->button($id == null ? 'Salvar' : 'Atualizar', ['type' => 'submit', 'class' => 'btn btn-primary', 'id'=> 'form-feedback-container', 'data-produtor-id' => $id]) ?>
            <?= $this->Html->link('Cancelar', $id ? ['action' => 'view', $id] : ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
<?php $this->append(name: 'script'); ?>
<?= $this->Html->script('app-masks'); ?>
<?php $this->end(); ?>