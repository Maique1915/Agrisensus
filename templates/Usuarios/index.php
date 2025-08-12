<div class="header">
    <h1>Gestão de Usuários</h1>
    <p>Cadastre, consulte e gerencie os usuários do sistema.</p>
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
                <label class="radio-inline"><input type="radio" name="filterColumn" value="1"> Matrícula</label>
                <label class="radio-inline"><input type="radio" name="filterColumn" value="2"> CPF</label>
                <label class="radio-inline"><input type="radio" name="filterColumn" value="3"> Grupo</label>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="usuariosTable" class="display responsive nowrap">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Matrícula</th>
                    <th>CPF</th>
                    <th>Grupo</th>
                    <th class="actions-column">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= h($usuario->nome) ?></td>
                        <td><?= h($usuario->matricula) ?></td>
                        <td><?= h($usuario->cpf ?: 'N/A') ?></td>
                        <td><?= $usuario->grupo? 'Admin' : 'Usuário' ?></td>
                        <td class="actions">
                            <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $usuario->id], ['class' => 'btn btn-action btn-edit', 'title' => 'Editar Usuário', 'escape' => false]) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-trash"></i>',
                                '#',
                                [
                                    'class' => 'btn btn-action btn-delete js-delete-user-link',
                                    'title' => 'Excluir Usuário',
                                    'escape' => false,
                                    'data-user-id' => $usuario->id,
                                    'data-url' => $this->Url->build(['action' => 'delete', $usuario->id])
                                ]
                            ) ?>

                            <!-- form oculto que contém o _Token gerado pelo FormHelper -->
                            <?= $this->Form->create(null, [
                                'url' => ['action' => 'delete', $usuario->id],
                                'id' => 'delete-form-' . $usuario->id,
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
<?= $this->Html->script('usuarios'); ?>
<?php $this->end(); ?>