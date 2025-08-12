<div class="header">
    <h1>Gestão de Propriedades</h1>
    <p>Cadastre, consulte e gerencie as propriedades.</p>
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
                    (Propriedade)</label>
                <label class="radio-inline"><input type="radio" name="filterColumn" value="3" data-search-type="uppercase-text"> Relação</label>
                <label class="radio-inline"><input type="radio" name="filterColumn" value="4" data-search-type="uppercase-text"> Bairro</label>
                <label class="radio-inline"><input type="radio" name="filterColumn" value="5" data-search-type="uppercase-text"> Complemento</label>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="propriedadesTable" class="display responsive nowrap">
            <thead>
                <tr>
                    <th class="hidden-column">Produtor (Nome)</th>
                    <th class="hidden-column">Produtor (Cpf)</th>
                    <th>Área Total</th>
                    <th>Nome da Propriedade</th>
                    <th>Relação com a Propriedade</th>
                    <th>Bairro</th>
                    <th>Complemento</th>
                    <th>Número</th>
                    <th class="actions-column">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($propriedades as $propriedade): ?>
                    <tr>
                        <td class="hidden-column"><?= h($propriedade->produtore ? $propriedade->produtore->nome : 'N/A') ?>
                        </td>
                        <td class="hidden-column"><?= h($propriedade->produtore ? $propriedade->produtore->cpf : 'N/A') ?>
                        </td>
                        <td><?= h($propriedade->area_total . ' ' . $propriedade->unidade) ?></td>
                        <td><?= h($propriedade->nome_propriedade) ?></td>
                        <td><?= h($propriedade->relacao_propriedade) ?></td>
                        <td><?= h($propriedade->bairro) ?></td>
                        <td><?= h($propriedade->complemento) ?></td>
                        <td><?= h($propriedade->numero) ?></td>
                        <td class="actions">
                            <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $propriedade->id], ['class' => 'btn btn-action btn-edit', 'title' => 'Editar Propriedade', 'escape' => false]) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-trash"></i>',
                                '#',
                                ['class' => 'btn btn-action btn-delete js-delete-propriedade-link', 'title' => 'Excluir Propriedade', 'escape' => false, 'data-propriedade-id' => $propriedade->id, 'data-url' => $this->Url->build(['action' => 'delete', $propriedade->id])]
                            ) ?>
                            <?= $this->Form->create(null, ['url' => ['action' => 'delete', $propriedade->id], 'id' => 'delete-form-' . $propriedade->id, 'class' => 'hidden']) ?>
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
<?= $this->Html->script('propriedades'); ?>
<?php $this->end(); ?>