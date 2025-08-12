<div class="header">
    <h1>Gestão de Produtores</h1>
    <p>Cadastre, consulte e gerencie os produtores rurais.</p>
</div>

<div class="list-container">
    <?= $this->Form->hidden('_csrfToken'); ?>
    <div class="filter-section">
        <?= $this->Html->link('+ Adicionar', ['action' => 'add'], ['class' => 'btn btn-new-producer']) ?>

        <div class="specific-filter-container">
            <div class="input-filter">
                <input type="text" id="specificSearchInput" class="form-control" placeholder="Filtrar por...">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" id="clearSpecificFilterBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="radio-group horizontal" id="filterColumnSelector">
                <label class="radio-inline"><input type="radio" name="filterColumn" value="0" checked> Nome</label>
                <label class="radio-inline"><input type="radio" name="filterColumn" value="1"> CPF</label>
                <label class="radio-inline"><input type="radio" name="filterColumn" value="2"> CNPJ</label>
                <label class="radio-inline"><input type="radio" name="filterColumn" value="3"> Telefone</label>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="produtoresTable" class="display responsive nowrap">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>CNPJ</th>
                    <th>Telefone</th>
                    <th class="actions-column">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtores as $produtor): ?>
                    <tr>
                        <td><?= h($produtor->nome) ?></td>
                        <td><?= h($produtor->cpf ?: 'N/A') ?></td>
                        <td><?= h($produtor->cnpj ?: 'N/A') ?></td>
                        <td class="phone-column"><?= h($produtor->telefone ?: 'N/A') ?></td>
                        <td class="actions">
                            <?= $this->Html->link('<i class="fas fa-eye"></i>', ['action' => 'view', $produtor->id], ['class' => 'btn btn-action btn-view', 'title' => 'Visualizar Detalhes', 'escape' => false]) ?>
                            <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $produtor->id], ['class' => 'btn btn-action btn-edit', 'title' => 'Editar Produtor', 'escape' => false]) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-trash"></i>',
                                '#',
                                [
                                    'class' => 'btn btn-action btn-delete js-delete-producer-link',
                                    'title' => 'Excluir Produtor',
                                    'escape' => false,
                                    'data-produtor-id' => $produtor->id,
                                    'data-url' => $this->Url->build(['action' => 'delete', $produtor->id])
                                ]
                            ) ?>

                            <!-- form oculto que contém o _Token gerado pelo FormHelper -->
                            <?= $this->Form->create(null, [
                                'url' => ['action' => 'delete', $produtor->id],
                                'id' => 'delete-form-' . $produtor->id,
                                'style' => 'display:none;'
                            ]) ?>
                            <?= $this->Form->end() ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->append(name: 'script'); ?>
<?= $this->Html->script('common_datatable'); ?>
<?= $this->Html->script('produtores'); ?>
<?php $this->end(); ?>