<div class="header">
    <h1>Gestão de Insumos</h1>
    <p>Cadastre, consulte e gerencie os <?= $this->Custom->pluralize('InsumoUtilizado') ?>.</p>
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
                <label class="radio-inline"><input type="radio" name="filterColumn" value="0" data-search-type="nome"
                        checked> Produtor</label>
                <label class="radio-inline"><input type="radio" name="filterColumn" value="1" data-search-type="cpf">
                    CPF</label>
                <label class="radio-inline"><input type="radio" name="filterColumn" value="2" data-search-type="uppercase-text"> Nome
                    (Insumo)</label>

                <label class="radio-inline"><input type="radio" name="filterColumn" value="2" data-search-type="uppercase-text"> Local de compra</label>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="insumosUtilizadosTable" class="display responsive nowrap">
            <thead>
                <tr>
                    <th class="hidden-column">Produtor (Nome)</th>
                    <th class="hidden-column">Produtor (Cpf)</th>
                    <th>Nome</th>
                    <th>Local de compra</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th class="actions-column">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($insumos as $insumo): ?>
                    <tr>
                        <td class="hidden-column"><?= h($insumo->produtore ? $insumo->produtore->nome : 'N/A') ?>
                        </td>
                        <td class="hidden-column"><?= h($insumo->produtore ? $insumo->produtore->cpf : 'N/A') ?>
                        </td>
                        <td><?= h($insumo->nome) ?></td>
                        <td><?= h($insumo->local_compra) ?></td>
                        <td><?= h($insumo->quantidade.(' '.$unidades[$insumo->unidade].'(s)' ?? '')) ?></td>
                        <td><?= h($insumo->preco) ?></td>
                        <td class="actions">
                            <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $insumo->id], ['class' => 'btn btn-action btn-edit', 'title' => 'Editar Insumo', 'escape' => false]) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-trash"></i>',
                                '#',
                                ['class' => 'btn btn-action btn-delete js-delete-insumo-link', 'title' => 'Excluir Insumo', 'escape' => false, 'data-insumo-id' => $insumo->id, 'data-url' => $this->Url->build(['action' => 'delete', $insumo->id])]
                            ) ?>
                            <?= $this->Form->create(null, ['url' => ['action' => 'delete', $insumo->id], 'id' => 'delete-form-' . $insumo->id, 'class' => 'hidden']) ?>
                            <?= $this->Form->hidden('_method', ['value' => 'DELETE']) ?>
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
<?= $this->Html->script('insumos-utilizados'); ?>
<?php $this->end(); ?>