
<div class="header">
    <h1>Gestão de <?= $this->Custom->pluralize('ProdutoCultivado') ?></h1>
    <p>Cadastre, consulte e gerencie os <?= $this->Custom->pluralize('ProdutoCultivado') ?>.</p>
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
                    (Produto)</label>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="produtosCultivadosTable" class="display responsive nowrap">
            <thead>
                <tr>
                    <th class="hidden-column">Produtor (Nome)</th>
                    <th class="hidden-column">Produtor (Cpf)</th>
                    <th>Nome do Produto</th>
                    <th>Preço</th>
                    <th>Produção Anual</th>
                    <th>Receita Total</th>
                    <th>Periodo Colheita</th>
                    <th class="actions-column">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td class="hidden-column"><?= h($produto->produtore ? $produto->produtore->nome : 'N/A') ?>
                        </td>
                        <td class="hidden-column"><?= h($produto->produtore ? $produto->produtore->cpf : 'N/A') ?>
                        </td>
                        <td><?= h($produto->nome) ?></td>
                        <td><?= h($produto->preco) ?></td>
                        <td><?= h($produto->producao_anual.' '.($produto->unidade? $produto->unidade.'(s)':'    ')) ?></td>
                        <td><?= h($produto->receita_total) ?></td>
                        <td><?= h($produto->periodo_colheita) ?></td>
                        <td class="actions">
                            <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $produto->id], ['class' => 'btn btn-action btn-edit', 'title' => 'Editar Produto', 'escape' => false]) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-trash"></i>',
                                '#',
                                ['class' => 'btn btn-action btn-delete js-delete-produto-link', 'title' => 'Excluir Produto', 'escape' => false, 'data-produto-id' => $produto->id, 'data-url' => $this->Url->build(['action' => 'delete', $produto->id])]
                            ) ?>
                            <?= $this->Form->create(null, ['url' => ['action' => 'delete', $produto->id], 'id' => 'delete-form-' . $produto->id, 'class' => 'hidden']) ?>
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
<?= $this->Html->script(url: 'produtos-cultivados'); ?>
<?php $this->end(); ?>